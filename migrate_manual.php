<?php
$db = new mysqli('localhost', 'root', '', 'attendance_ci');
if ($db->connect_error) {
    die('Connection failed: ' . $db->connect_error);
}

// Mark divisi migration as done
$db->query("INSERT INTO migrations (version, class, `group`, namespace, time, batch) VALUES ('2025-07-09-012445', 'App\\\\Database\\\\Migrations\\\\Divisi', 'default', 'App', " . time() . ", 2)");

// Add columns to ketidakhadiran table
$alterQueries = [
    'ALTER TABLE ketidakhadiran ADD COLUMN jenis_ketidakhadiran ENUM("sakit", "izin", "cuti") DEFAULT "izin" AFTER keterangan',
    'ALTER TABLE ketidakhadiran ADD COLUMN status_verifikasi_kepala ENUM("pending", "approved", "rejected") DEFAULT "pending" AFTER sttatus_pengajuan',
    'ALTER TABLE ketidakhadiran ADD COLUMN verifikasi_kepala_by INT(11) UNSIGNED NULL AFTER status_verifikasi_kepala',
    'ALTER TABLE ketidakhadiran ADD COLUMN verifikasi_kepala_at DATETIME NULL AFTER verifikasi_kepala_by',
    'ALTER TABLE ketidakhadiran ADD COLUMN catatan_kepala TEXT NULL AFTER verifikasi_kepala_at',
    'ALTER TABLE ketidakhadiran ADD COLUMN status_verifikasi_direktur ENUM("pending", "approved", "rejected") DEFAULT "pending" AFTER catatan_kepala',
    'ALTER TABLE ketidakhadiran ADD COLUMN verifikasi_direktur_by INT(11) UNSIGNED NULL AFTER status_verifikasi_direktur',
    'ALTER TABLE ketidakhadiran ADD COLUMN verifikasi_direktur_at DATETIME NULL AFTER verifikasi_direktur_by',
    'ALTER TABLE ketidakhadiran ADD COLUMN catatan_direktur TEXT NULL AFTER verifikasi_direktur_at',
    'ALTER TABLE ketidakhadiran ADD COLUMN created_at DATETIME NULL AFTER catatan_direktur',
    'ALTER TABLE ketidakhadiran ADD COLUMN updated_at DATETIME NULL AFTER created_at'
];

foreach ($alterQueries as $query) {
    if ($db->query($query)) {
        echo "Query executed: $query\n";
    } else {
        echo "Error: " . $db->error . " for query: $query\n";
    }
}

// Create kepala_bagian table
$createTable = "
CREATE TABLE kepala_bagian (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_pegawai INT(11) UNSIGNED NOT NULL,
    divisi VARCHAR(50) NOT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    FOREIGN KEY (id_pegawai) REFERENCES pegawai(id) ON DELETE CASCADE ON UPDATE CASCADE
)
";

if ($db->query($createTable)) {
    echo "Table kepala_bagian created successfully\n";
} else {
    echo "Error creating table: " . $db->error . "\n";
}

// Mark migrations as done
$db->query("INSERT INTO migrations (version, class, `group`, namespace, time, batch) VALUES ('2025-08-22-000001', 'App\\\\Database\\\\Migrations\\\\UpdateKetidakhadiranVerifikasi', 'default', 'App', " . time() . ", 3)");
$db->query("INSERT INTO migrations (version, class, `group`, namespace, time, batch) VALUES ('2025-08-22-000002', 'App\\\\Database\\\\Migrations\\\\KepalaBagian', 'default', 'App', " . time() . ", 3)");

echo "Migration completed!\n";
$db->close();
?>
