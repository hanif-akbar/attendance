<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ClockInOutLocationSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'zona_waktu' => 'WIB',
                'jam_masuk' => '08:00:00',
                'jam_keluar' => '16:00:00'
            ],
            [
                'zona_waktu' => 'WITA',
                'jam_masuk' => '08:00:00',
                'jam_keluar' => '16:00:00'
            ],
            [
                'zona_waktu' => 'WIT',
                'jam_masuk' => '08:00:00',
                'jam_keluar' => '16:00:00'
            ],
        ];

        $this->db->table('clock_in_out_location')->insertBatch($data);
    }
}