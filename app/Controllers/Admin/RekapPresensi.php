<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PresensiModel;
use CodeIgniter\HTTP\ResponseInterface;

class RekapPresensi extends BaseController
{
    public function rekap_harian()
    {
        $presensiModel = new PresensiModel();
        $filter_tanggal = $this->request->getVar('filter_tanggal');
        if ($filter_tanggal){
            $rekap_harian = $presensiModel->rekap_harian_filter($filter_tanggal);
        }else{
            $rekap_harian = $presensiModel->rekap_harian();
        }
        $data = [
            'title' => 'Rekap Harian',
            'rekap_harian' => $rekap_harian
        ];
        return view('admin/rekap_presensi/rekap_harian', $data);
    }

    public function rekap_mingguan(){
    $presensiModel = new PresensiModel();
    $filter_mingguan = $this->request->getVar('filter_mingguan');

    if ($filter_mingguan) {
        $rekap_mingguan = $presensiModel->rekap_mingguan_filter($filter_mingguan);
    } else {
        $rekap_mingguan = $presensiModel->rekap_mingguan();
    }

    $data = [
        'title' => 'Rekap Mingguan',
        'rekap_mingguan' => $rekap_mingguan
    ];

    return view('admin/rekap_presensi/rekap_mingguan', $data);
    }

    public function rekap_bulanan()
    {
        // $presensiModel = new PresensiModel();
        // $filter_bulan = $this->request->getVar('filter_bulan');
        // // $filter_tahun = $this->request->getVar('filter_tahun');
        // if ($filter_bulan || $filter_tahun){
        //     $rekap_bulanan = $presensiModel->rekap_bulanan_filter($filter_bulan , $filter_tahun);
        // }else{
        //     $rekap_bulanan = $presensiModel->rekap_bulanan();
        // }
        // $data = [
        //     'title' => 'Rekap Bulanan',
        //     // 'bulan' => $filter_bulan,
        //     // 'tahun' => $filter_tahun,
        //     'rekap_bulanan' => $rekap_bulanan
        // ];

        $presensiModel = new PresensiModel();
        $filter_bulan = $this->request->getVar('filter_bulan');

        if ($filter_bulan) {
            $rekap_bulanan = $presensiModel->rekap_bulanan_filter($filter_bulan);
        } else {
            $rekap_bulanan = $presensiModel->rekap_bulanan();
        }

        $data = [
            'title' => 'Rekap Bulanan',
            'rekap_bulanan' => $rekap_bulanan
        ];
            return view('admin/rekap_presensi/rekap_bulanan', $data);
    }
}
