<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pegawai extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nip' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'jenis_kelamin' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'no_handphone' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'jabatan' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            // 'lokaso_presensi' => [
            //     'type' => 'VARCHAR',
            //     'constraint' => '50',
            // ],
            // 'role' => [
            //     'type' => 'ENUM',
            //     'constraint' => ['admin', 'pegawai'],
            //     'default' => 'pegawai',
            // ],
            'tanggal_lahir' => [
                'type' => 'DATE',
            ],
            'tanggal_masuk' => [
                'type' => 'DTAE',
            ],
            'clock_in_out_location' => [
                'type' => 'INT',
                'constraint' => '11',
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            // 'created_at' => [
            //     'type' => 'DATE',
            // ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pegawai');
    }

    public function down()
    {
        $this->forge->dropTable('pegawai');
    }
}
