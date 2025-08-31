<?php

namespace App\Models;

use CodeIgniter\Model;

class KetidakhadiranModel extends Model
{
    protected $table            = 'ketidakhadiran';
    protected $primaryKey       = 'id';
    // protected $useAutoIncrement = true;
    // protected $returnType       = 'array';
    // protected $useSoftDeletes   = false;
    // protected $protectFields    = true;
    protected $allowedFields    = [
        'id_pegawai',
        'keterangan',
        'jenis_ketidakhadiran',
        'tanggal',
        'deskripsi',
        'file',
        'sttatus_pengajuan',
        'status_verifikasi_kepala',
        'verifikasi_kepala_by',
        'verifikasi_kepala_at',
        'catatan_kepala',
        'status_verifikasi_direktur',
        'verifikasi_direktur_by',
        'verifikasi_direktur_at',
        'catatan_direktur',
        'created_at',
        'updated_at',
    ];
    // protected bool $allowEmptyInserts = false;
    // protected bool $updateOnlyChanged = true;

    // protected array $casts = [];
    // protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Methods untuk mendapatkan data ketidakhadiran dengan relasi
    public function getKetidakhadiranWithPegawai($idPegawai = null)
    {
        $builder = $this->db->table('ketidakhadiran k');
        $builder->select('k.*, p.nama as nama_pegawai, p.divisi, p.jabatan, 
                         kp.nama as verifikasi_kepala_nama, 
                         dp.nama as verifikasi_direktur_nama');
        $builder->join('pegawai p', 'p.id = k.id_pegawai', 'left');
        $builder->join('pegawai kp', 'kp.id = k.verifikasi_kepala_by', 'left');
        $builder->join('pegawai dp', 'dp.id = k.verifikasi_direktur_by', 'left');
        
        if ($idPegawai) {
            $builder->where('k.id_pegawai', $idPegawai);
        }
        
        $builder->orderBy('k.created_at', 'DESC');
        return $builder->get()->getResultArray();
    }

    public function getKetidakhadiranForVerifikasi($role, $idPegawai, $divisi = null)
    {
        $builder = $this->db->table('ketidakhadiran k');
        $builder->select('k.*, p.nama as nama_pegawai, p.divisi, p.jabatan, p.nip');
        $builder->join('pegawai p', 'p.id = k.id_pegawai', 'left');
        
        if ($role === 'kepala_bagian') {
            // Kepala bagian hanya bisa melihat pengajuan dari divisinya
            $builder->where('p.divisi', $divisi);
            $builder->where('k.status_verifikasi_kepala', 'pending');
            // Kepala bagian tidak bisa verifikasi pengajuannya sendiri
            $builder->where('k.id_pegawai !=', $idPegawai);
        } elseif ($role === 'direktur') {
            // Direktur melihat pengajuan dari kepala bagian yang sudah disetujui
            $builder->join('kepala_bagian kb', 'kb.id_pegawai = k.id_pegawai', 'inner');
            $builder->where('k.status_verifikasi_direktur', 'pending');
            // Atau pengajuan staff yang sudah disetujui kepala bagian
            $builder->orWhere('k.status_verifikasi_kepala', 'approved');
            $builder->where('k.status_verifikasi_direktur', 'pending');
        } elseif ($role === 'admin') {
            // Admin/HR bisa melihat semua
            $builder->where('k.status_verifikasi_kepala !=', 'pending');
        }
        
        $builder->orderBy('k.created_at', 'DESC');
        return $builder->get()->getResultArray();
    }

    public function updateVerifikasi($id, $data)
    {
        return $this->update($id, $data);
    }

    // Validation
    // protected $validationRules      = [];
    // protected $validationMessages   = [];
    // protected $skipValidation       = false;
    // protected $cleanValidationRules = true;

    // Callbacks
    // protected $allowCallbacks = true;
    // protected $beforeInsert   = [];
    // protected $afterInsert    = [];
    // protected $beforeUpdate   = [];
    // protected $afterUpdate    = [];
    // protected $beforeFind     = [];
    // protected $afterFind      = [];
    // protected $beforeDelete   = [];
    // protected $afterDelete    = [];
}
