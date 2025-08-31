<?php

namespace App\Models;

use CodeIgniter\Model;

class KepalaBagianModel extends Model
{
    protected $table            = 'kepala_bagian';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'id_pegawai',
        'divisi',
        'is_active',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getKepalaBagianWithPegawai()
    {
        return $this->select('kepala_bagian.*, pegawai.nama, pegawai.nip, pegawai.jabatan')
                   ->join('pegawai', 'pegawai.id = kepala_bagian.id_pegawai')
                   ->where('kepala_bagian.is_active', 1)
                   ->findAll();
    }

    public function getKepalaBagianByDivisi($divisi)
    {
        return $this->select('kepala_bagian.*, pegawai.nama, pegawai.nip')
                   ->join('pegawai', 'pegawai.id = kepala_bagian.id_pegawai')
                   ->where('kepala_bagian.divisi', $divisi)
                   ->where('kepala_bagian.is_active', 1)
                   ->first();
    }

    public function isKepalaBagian($idPegawai)
    {
        return $this->where('id_pegawai', $idPegawai)
                   ->where('is_active', 1)
                   ->first();
    }

    public function setKepalaBagian($idPegawai, $divisi)
    {
        // Nonaktifkan kepala bagian lama untuk divisi yang sama
        $this->where('divisi', $divisi)
             ->set(['is_active' => 0])
             ->update();

        // Hapus kepala bagian lama untuk pegawai yang sama
        $this->where('id_pegawai', $idPegawai)->delete();

        // Tambah kepala bagian baru
        return $this->insert([
            'id_pegawai' => $idPegawai,
            'divisi' => $divisi,
            'is_active' => 1
        ]);
    }

    public function removeKepalaBagian($idPegawai)
    {
        return $this->where('id_pegawai', $idPegawai)->delete();
    }
}
