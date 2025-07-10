<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nip' => 'admin',
            'nama' => 'Admin',
            'jenis_kelamin' => '-',
            'alamat' => '-',
            'no_handphone' => '000000000000',
            'divisi' => 'Admin',
            'jabatan' => 'Admin',
            'foto' => 'admin.jpg',
            'tanggal_lahir' => '0000-00-00',
            'tanggal_masuk' => '0000-00-00',
            'clock_in_out_location' => '',
        ];

        $this->db->table('pegawai')->insert($data);
    }
}
