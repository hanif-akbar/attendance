<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'id_pegawai' => 1,
            'username' => 'admin',
            'password' => password_hash('admin', PASSWORD_DEFAULT),
            'status' => '',
            'role' => 'Admin',
        ];

        $this->db->table('users')->insert($data);
    }
}
