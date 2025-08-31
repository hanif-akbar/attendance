<?php

namespace App\Controllers\KepalaBagian;

use App\Controllers\BaseController;
use App\Models\PresensiModel;
use CodeIgniter\HTTP\ResponseInterface;

class RekapPresensi extends BaseController
{
    public function index()
    {
        $presensiModel = new PresensiModel();
        $filter_tanggal = $this->request->getVar('filter_tanggal');
        // dd($filter_tanggal);
        if ($filter_tanggal){
            $rekap_presensi = $presensiModel->rekap_presensi_pegawai_fiter($filter_tanggal);

        }else{
            $rekap_presensi = $presensiModel->rekap_presensi_peagawai(); 
        }
        $data =[
            'title' => 'Rekap Presensi',
            'rekap_presensi' => $rekap_presensi,
        ];
        return view('kepalaBagian/rekap_presensi',$data);
    }
}
