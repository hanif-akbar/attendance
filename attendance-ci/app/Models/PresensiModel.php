<?php

namespace App\Models;

use CodeIgniter\Model;

class PresensiModel extends Model
{
    protected $table            = 'presensi';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'id_pegawai',
        'tanggal_masuk',
        'jam_masuk',
        'latitude_masuk',
        'longitude_masuk',
        'tanggal_keluar',
        'jam_keluar',
        'latitude_keluar',
        'longitude_keluar'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
