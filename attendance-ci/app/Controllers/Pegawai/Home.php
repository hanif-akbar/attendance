<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ClockInOutLocationModel;
use App\Models\PegawaiModel;
use App\Models\PresensiModel;

class Home extends BaseController
{
    public function index()
    {
        $clockInOutLocationModel = new ClockInOutLocationModel();
        $pegawaiModel = new PegawaiModel();
        $presensiModel = new PresensiModel();
        $idPegawai = session()->get('id_pegawai');
        $pegawai = $pegawaiModel->where('id',$idPegawai)->first();
        $data =[
            'title' => 'Dashboard',
            'clockInOut' => $clockInOutLocationModel->where('id',$pegawai['clock_in_out_location'])->first(),
            'checkPresensi' => $presensiModel->where('id_pegawai',$idPegawai)->where('tanggal_masuk',date('Y-m-d'))->countAllResults(),
            'ambilPresensiMasuk' => $presensiModel->where('id_pegawai',$idPegawai)->where('tanggal_masuk',date('Y-m-d'))->first(),
        ];
        // dd ($data);
        
        return view('pegawai/home',$data);
    }
    public function presensi_masuk()
    {
        $presensiModel = new PresensiModel();
    
        // Validasi data
        $data = [
            'id_pegawai' => $this->request->getPost('id_pegawai'),
            'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
            'jam_masuk' => $this->request->getPost('jam_masuk'),
            'latitude_masuk' => $this->request->getPost('latitude_masuk'),
            'longitude_masuk' => $this->request->getPost('longitude_masuk')
        ];
    
        // Debug
        // dd($data);
    
        if (!empty($data['latitude_masuk']) && !empty($data['longitude_masuk'])) {
            $presensiModel->insert($data);
            return redirect()->to('/pegawai/dashboard')->with('success', 'Presensi berhasil');
        }
    
        return redirect()->to('/pegawai/dashboard')->with('error', 'Gagal melakukan presensi. Lokasi tidak ditemukan');
    }
//     public function presensi_keluar() 
// {
//     $presensiModel = new PresensiModel();
//     $idPegawai = session()->get('id_pegawai');
    
//     // Get today's attendance record
//     $presensi = $presensiModel->where([
//         'id_pegawai' => $idPegawai,
//         'tanggal_masuk' => date('Y-m-d')
//     ])->first();

//     if (!$presensi) {
//         return redirect()->to('/pegawai/dashboard')->with('error', 'Anda belum melakukan presensi masuk');
//     }

//     // Update data
//     $data = [
//         'tanggal_keluar' => date('Y-m-d'),
//         'jam_keluar' => date('H:i:s'),
//         'latitude_keluar' => $this->request->getPost('latitude_keluar'),
//         'longitude_keluar' => $this->request->getPost('longitude_keluar')
//     ];

//     // Debug
//     // dd($data);

//     if (!empty($data['latitude_keluar']) && !empty($data['longitude_keluar'])) {
//         $presensiModel->update($presensi['id'], $data);
//         return redirect()->to('/pegawai/dashboard')->with('success', 'Presensi keluar berhasil');
//     }

//     return redirect()->to('/pegawai/dashboard')->with('error', 'Gagal melakukan presensi keluar. Lokasi tidak ditemukan');
// }
    
}
