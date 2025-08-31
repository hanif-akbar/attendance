<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateKetidakhadiranVerifikasi extends Migration
{
    public function up()
    {
        // Menambah field untuk sistem verifikasi
        $fields = [
            'status_verifikasi_kepala' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'approved', 'rejected'],
                'default' => 'pending',
                'after' => 'sttatus_pengajuan'
            ],
            'verifikasi_kepala_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'status_verifikasi_kepala'
            ],
            'verifikasi_kepala_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'verifikasi_kepala_by'
            ],
            'catatan_kepala' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'verifikasi_kepala_at'
            ],
            'status_verifikasi_direktur' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'approved', 'rejected'],
                'default' => 'pending',
                'after' => 'catatan_kepala'
            ],
            'verifikasi_direktur_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'status_verifikasi_direktur'
            ],
            'verifikasi_direktur_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'verifikasi_direktur_by'
            ],
            'catatan_direktur' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'verifikasi_direktur_at'
            ],
            'jenis_ketidakhadiran' => [
                'type' => 'ENUM',
                'constraint' => ['sakit', 'izin', 'cuti'],
                'default' => 'izin',
                'after' => 'keterangan'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'catatan_direktur'
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'created_at'
            ]
        ];

        $this->forge->addColumn('ketidakhadiran', $fields);

        // Menambah foreign key untuk verifikasi
        $this->forge->addForeignKey('verifikasi_kepala_by', 'pegawai', 'id', 'SET NULL', 'SET NULL');
        $this->forge->addForeignKey('verifikasi_direktur_by', 'pegawai', 'id', 'SET NULL', 'SET NULL');
        $this->forge->processIndexes('ketidakhadiran');
    }

    public function down()
    {
        $this->forge->dropColumn('ketidakhadiran', [
            'status_verifikasi_kepala',
            'verifikasi_kepala_by',
            'verifikasi_kepala_at',
            'catatan_kepala',
            'status_verifikasi_direktur',
            'verifikasi_direktur_by',
            'verifikasi_direktur_at',
            'catatan_direktur',
            'jenis_ketidakhadiran',
            'created_at',
            'updated_at'
        ]);
    }
}
