<?php

namespace App\Models;

use CodeIgniter\Model;

class PegawaiModel extends Model
{
    protected $table            = 'pegawai';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'nip',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'no_handphone',
        'divisi',
        'jabatan',
        'role',
        'foto',
        'tanggal_masuk',
        'clock_in_out_location',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    public function detailPegawai($id){
        $db      = \Config\Database::connect();
        $builder = $db->table('pegawai');
        $builder->select('pegawai.*, users.username, users.password, users.status, users.role');
        $builder->join('users', 'users.id_pegawai = pegawai.id', 'left');
        $builder->where('pegawai.id', $id);
        return $builder->get()->getRowArray();
    }
    public function getPegawai(){
        $builder = $this->db->table('pegawai');
        $builder->select('pegawai.*, users.role');
        $builder->join('users', 'users.id_pegawai = pegawai.id', 'left');
        return $builder->get()->getResultArray();
    }

    public function getPegawaiPaginated($perPage = 10){
        return $this->select('pegawai.*, users.role')
                   ->join('users', 'users.id_pegawai = pegawai.id', 'left')
                   ->orderBy('pegawai.nama', 'ASC')
                   ->paginate($perPage);
    }

    public function searchPegawai($search){
        return $this->select('pegawai.*, users.role')
                   ->join('users', 'users.id_pegawai = pegawai.id', 'left')
                   ->groupStart()
                       ->like('pegawai.nama', $search)
                       ->orLike('pegawai.nip', $search)
                       ->orLike('pegawai.jabatan', $search)
                       ->orLike('pegawai.divisi', $search)
                       ->orLike('users.role', $search)
                   ->groupEnd()
                   ->orderBy('pegawai.nama', 'ASC')
                   ->findAll();
    }
}
