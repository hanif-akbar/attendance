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
        'foto_masuk',
        'latitude_masuk',
        'longitude_masuk',
        'tanggal_keluar',
        'jam_keluar',
        'foto_keluar',
        'latitude_keluar', 
        'longitude_keluar'
    ];
    public function rekap_harian(){
        $db      = \Config\Database::connect();
        $builder = $db->table('presensi');
        $builder->select('presensi.*, pegawai.nama, clock_in_out_location.jam_masuk as jam_masuk_office');
        $builder->join('pegawai', 'pegawai.id = presensi.id_pegawai');
        $builder->join('clock_in_out_location','clock_in_out_location.id = pegawai.clock_in_out_location');
        $builder->where('presensi.tanggal_masuk', date('Y-m-d'));
        return $query = $builder->get()->getResultArray();
    }

    public function rekap_mingguan(){
        $db      = \Config\Database::connect();
        $builder = $db->table('presensi');
        $builder->select('presensi.*, pegawai.nama, clock_in_out_location.jam_masuk as jam_masuk_office');
        $builder->join('pegawai', 'pegawai.id = presensi.id_pegawai');
        $builder->join('clock_in_out_location','clock_in_out_location.id = pegawai.clock_in_out_location');
        $builder->where('presensi.tanggal_masuk', date('Y-m-d'));
        return $query = $builder->get()->getResultArray();
    }

    public function rekap_harian_filter($filter_tanggal){
        $db      = \Config\Database::connect();
        $builder = $db->table('presensi');
        $builder->select('presensi.*, pegawai.nama, clock_in_out_location.jam_masuk as jam_masuk_office');
        $builder->join('pegawai', 'pegawai.id = presensi.id_pegawai');
        $builder->join('clock_in_out_location','clock_in_out_location.id = pegawai.clock_in_out_location');
        $builder->where('presensi.tanggal_masuk', $filter_tanggal);
        return $query = $builder->get()->getResultArray();
    }

    public function rekap_mingguan_filter($filter_mingguan){
    $db      = \Config\Database::connect();
    $builder = $db->table('presensi');
    $builder->select('presensi.*, pegawai.nama, clock_in_out_location.jam_masuk as jam_masuk_office');
    $builder->join('pegawai', 'pegawai.id = presensi.id_pegawai');
    $builder->join('clock_in_out_location','clock_in_out_location.id = pegawai.clock_in_out_location');

    if (!empty($filter_mingguan)) {
        // Format input: 2025-W21
        $tahun = substr($filter_mingguan, 0, 4);
        $mingguKe = substr($filter_mingguan, 6, 2);

        // Buat objek tanggal dari ISO Week Date (Senin sebagai awal minggu)
        $date = new \DateTime();
        $date->setISODate($tahun, $mingguKe);
        $startDate = $date->format('Y-m-d');
        $endDate = $date->modify('+6 days')->format('Y-m-d');

        // Filter berdasarkan rentang tanggal minggu itu
        $builder->where('presensi.tanggal_masuk >=', $startDate);
        $builder->where('presensi.tanggal_masuk <=', $endDate);
    }

    return $builder->get()->getResultArray();
    }
    

    public function rekap_bulanan(){
        $db      = \Config\Database::connect();
        $builder = $db->table('presensi');
        $builder->select('presensi.*, pegawai.nama, clock_in_out_location.jam_masuk as jam_masuk_office');
        $builder->join('pegawai', 'pegawai.id = presensi.id_pegawai');
        $builder->join('clock_in_out_location','clock_in_out_location.id = pegawai.clock_in_out_location');
        // $builder->where('MONTH(presensi.tanggal_masuk)', date('m'));
        // $builder->where('YEAR(presensi.tanggal_masuk)', date('Y'));
        // $builder->where('MONTH(presensi.tanggal_masuk)', date('Y-m'));

        $bulan = date('m');
        $tahun = date('Y');
        $builder->where('MONTH(presensi.tanggal_masuk)', $bulan);
        $builder->where('YEAR(presensi.tanggal_masuk)', $tahun);

        return $query = $builder->get()->getResultArray();
    }
    public function rekap_bulanan_filter($filter_bulan){
        $db      = \Config\Database::connect();
        $builder = $db->table('presensi');
        $builder->select('presensi.*, pegawai.nama, clock_in_out_location.jam_masuk as jam_masuk_office');
        $builder->join('pegawai', 'pegawai.id = presensi.id_pegawai');
        $builder->join('clock_in_out_location','clock_in_out_location.id = pegawai.clock_in_out_location');
        // $builder->where('MONTH(presensi.tanggal_masuk)', date('m'));
        // $builder->where('YEAR(presensi.tanggal_masuk)', date('Y'));
        // $builder->where('MONTH(presensi.tanggal_masuk)', date('Y-m'));
       
        $bulan = date('m', strtotime($filter_bulan . '-01'));
        $tahun = date('Y', strtotime($filter_bulan . '-01'));
        $builder->where('MONTH(presensi.tanggal_masuk)', $bulan);
        $builder->where('YEAR(presensi.tanggal_masuk)', $tahun);
        
        return $query = $builder->get()->getResultArray();
    }

    public function rekap_presensi_peagawai(/*$id_pegawai*/){
        $id_pegawai = session()->get('id_pegawai');
        // dd($id_pegawai);
        $db      = \Config\Database::connect();
        $builder = $db->table('presensi');
        $builder->select('presensi.*, pegawai.nama, clock_in_out_location.jam_masuk as jam_masuk_office');
        $builder->join('pegawai', 'pegawai.id = presensi.id_pegawai');
        $builder->join('clock_in_out_location','clock_in_out_location.id = pegawai.clock_in_out_location');
        $builder->where('presensi.id_pegawai', $id_pegawai);
        $builder->where('presensi.tanggal_masuk', date('Y-m-d'));
        return $query = $builder->get()->getResultArray();
    }
    public function rekap_presensi_pegawai_fiter($filter_tanggal){
        $id_pegawai = session()->get('id_pegawai');
        // dd($id_pegawai);
        $db      = \Config\Database::connect();
        $builder = $db->table('presensi');
        $builder->select('presensi.*, pegawai.nama, clock_in_out_location.jam_masuk as jam_masuk_office');
        $builder->join('pegawai', 'pegawai.id = presensi.id_pegawai');
        $builder->join('clock_in_out_location','clock_in_out_location.id = pegawai.clock_in_out_location');
        $builder->where('presensi.id_pegawai', $id_pegawai);
        $builder->where('presensi.tanggal_masuk', $filter_tanggal);
        return $query = $builder->get()->getResultArray();
    }
    
    // protected bool $allowEmptyInserts = false;
    // protected bool $updateOnlyChanged = true;

    // protected array $casts = [];
    // protected array $castHandlers = [];

    // // Dates
    // protected $useTimestamps = false;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // // Validation
    // protected $validationRules      = [];
    // protected $validationMessages   = [];
    // protected $skipValidation       = false;
    // protected $cleanValidationRules = true;

    // // Callbacks
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
