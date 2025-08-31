<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id_pegawai' , 'username', 'password', 'status', 'role'];


    public function getUserWithNama($username)
    {
        return $this->select('users.*, pegawai.nama')
                    ->join('pegawai', 'pegawai.id = users.id_pegawai', 'left')
                    ->where('users.username', $username)
                    ->first();
    }
}
