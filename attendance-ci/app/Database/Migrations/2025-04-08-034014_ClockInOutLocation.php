<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ClockInOutLocation extends Migration
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
            // 'nama_lokasi' => [
            //     'type' => 'VARCHAR',
            //     'constraint' => '255',
            // ],
            'zona_waktu' => [
                'type' => 'VARCHAR',
                'constraint' => '4',
            ],
            'jam_masuk' => [
                'type' => 'TIME',
            ],
            'jam_keluar' => [
                'type' => 'TIME',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('clock_in_out_location');
    }

    public function down()
    {
        $this->forge->dropTable('clock_in_out_location');
    }
}
