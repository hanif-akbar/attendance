<?php
$db = new mysqli('localhost', 'root', '', 'attendance_ci');
if ($db->connect_error) {
    die('Connection failed: ' . $db->connect_error);
}

// Insert sample divisi
$divisiData = [
    'Finance Tax',
    'Marketing', 
    'Produksi',
    'Maintenance'
];

foreach ($divisiData as $divisi) {
    $db->query("INSERT IGNORE INTO divisi (divisi) VALUES ('$divisi')");
    echo "Divisi '$divisi' inserted\n";
}

// Insert sample users dengan role yang berbeda
$userData = [
    // Admin
    ['admin', 'admin', 'admin'],
    // Direktur
    ['direktur', 'direktur123', 'direktur'],
    // Kepala Bagian Finance
    ['kepala_finance', 'kepala123', 'kepala_bagian'],
    // Kepala Bagian Marketing  
    ['kepala_marketing', 'kepala123', 'kepala_bagian'],
    // Kepala Bagian Produksi
    ['kepala_produksi', 'kepala123', 'kepala_bagian'],
    // Kepala Bagian Maintenance
    ['kepala_maintenance', 'kepala123', 'kepala_bagian'],
    // Staff
    ['staff_finance', 'staff123', 'pegawai'],
    ['staff_marketing', 'staff123', 'pegawai'],
];

// Check existing users first
$existingUsers = $db->query("SELECT username FROM users");
$existingUsernames = [];
while ($row = $existingUsers->fetch_assoc()) {
    $existingUsernames[] = $row['username'];
}

foreach ($userData as $index => $user) {
    [$username, $password, $role] = $user;
    
    if (!in_array($username, $existingUsernames)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insertUser = "INSERT INTO users (username, password, role, status) VALUES ('$username', '$hashedPassword', '$role', 'active')";
        
        if ($db->query($insertUser)) {
            echo "User '$username' with role '$role' created\n";
            
            // Get the user ID
            $userId = $db->insert_id;
            
            // Insert corresponding pegawai data
            $pegawaiData = [
                'admin' => ['001', 'Admin System', 'Laki-laki', '1990-01-01', 'Jakarta', '081234567890', 'Admin', 'Administrator', '2020-01-01'],
                'direktur' => ['002', 'Direktur Utama', 'Laki-laki', '1975-01-01', 'Jakarta', '081234567891', 'Direktur', 'Direktur', '2020-01-01'],
                'kepala_finance' => ['003', 'Kepala Finance Tax', 'Perempuan', '1985-01-01', 'Jakarta', '081234567892', 'Finance Tax', 'Kepala Bagian Finance', '2020-01-01'],
                'kepala_marketing' => ['004', 'Kepala Marketing', 'Laki-laki', '1985-01-01', 'Jakarta', '081234567893', 'Marketing', 'Kepala Bagian Marketing', '2020-01-01'],
                'kepala_produksi' => ['005', 'Kepala Produksi', 'Laki-laki', '1985-01-01', 'Jakarta', '081234567894', 'Produksi', 'Kepala Bagian Produksi', '2020-01-01'],
                'kepala_maintenance' => ['006', 'Kepala Maintenance', 'Perempuan', '1985-01-01', 'Jakarta', '081234567895', 'Maintenance', 'Kepala Bagian Maintenance', '2020-01-01'],
                'staff_finance' => ['007', 'Staff Finance', 'Laki-laki', '1990-01-01', 'Jakarta', '081234567896', 'Finance Tax', 'Staff Finance', '2021-01-01'],
                'staff_marketing' => ['008', 'Staff Marketing', 'Perempuan', '1990-01-01', 'Jakarta', '081234567897', 'Marketing', 'Staff Marketing', '2021-01-01'],
            ];
            
            if (isset($pegawaiData[$username])) {
                $p = $pegawaiData[$username];
                $insertPegawai = "INSERT INTO pegawai (nip, nama, jenis_kelamin, tanggal_lahir, alamat, no_handphone, divisi, jabatan, tanggal_masuk, clock_in_out_location, foto) 
                                VALUES ('{$p[0]}', '{$p[1]}', '{$p[2]}', '{$p[3]}', '{$p[4]}', '{$p[5]}', '{$p[6]}', '{$p[7]}', '{$p[8]}', 1, 'default.jpg')";
                
                if ($db->query($insertPegawai)) {
                    $pegawaiId = $db->insert_id;
                    
                    // Update user with pegawai ID
                    $db->query("UPDATE users SET id_pegawai = $pegawaiId WHERE id = $userId");
                    
                    echo "Pegawai data for '$username' created with ID $pegawaiId\n";
                    
                    // Set kepala bagian for each divisi
                    if ($role === 'kepala_bagian') {
                        $divisiName = $p[6];
                        $insertKepala = "INSERT INTO kepala_bagian (id_pegawai, divisi, is_active) VALUES ($pegawaiId, '$divisiName', 1)";
                        if ($db->query($insertKepala)) {
                            echo "Kepala bagian for '$divisiName' set to '{$p[1]}'\n";
                        }
                    }
                }
            }
        }
    } else {
        echo "User '$username' already exists\n";
    }
}

echo "Sample data creation completed!\n";
$db->close();
?>
