<?php

namespace App\Controllers\KepalaBagian;

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
            'title' => 'Dashboard Presensi',
            'clockInOut' => $clockInOutLocationModel->where('id',$pegawai['clock_in_out_location'])->first(),
            'checkPresensi' => $presensiModel->where('id_pegawai',$idPegawai)->where('tanggal_masuk',date('Y-m-d'))->countAllResults(),
            'checkPresensiKeluar' => $presensiModel->where('id_pegawai',$idPegawai)->where('tanggal_masuk',date('Y-m-d'))->where('tanggal_keluar !=', null)->countAllResults(),
            'ambilPresensiMasuk' => $presensiModel->where('id_pegawai',$idPegawai)->where('tanggal_masuk',date('Y-m-d'))->first(),
        ];
        // dd ($data);

        return view('kepalaBagian/home',$data);
    }

     public function presensi_masuk()
    {       
        $latitude_masuk = $this->request->getPost('latitude_masuk');
        $longitude_masuk = $this->request->getPost('longitude_masuk');

        $data = [
            'title'=> 'Ambil Foto',
            'tanggal_masuk' => date('Y-m-d'),
            'jam_masuk' =>  $this->request->getPost('jam_masuk'),
            'id_pegawai' => $this->request->getPost('id_pegawai'),
            'latitude_masuk' => $latitude_masuk,
            'longitude_masuk' => $longitude_masuk
        ];

        // dd($data);

        return view ('kepalaBagian/ambil_foto', $data);

        // Debug
        // dd($data);
    
        
    }

    public function presensi_masuk_aksi()
    {
        $request = \Config\Services::request();
        $id_pegawai = $request->getPost('id_pegawai');
        $tanggal_masuk = $request->getPost('tanggal_masuk');
        $jam_masuk = $request->getPost('jam_masuk');
        $foto_masuk = $request->getPost('foto_masuk');
        $latitude_masuk = $request->getPost('latitude_masuk');
        $longitude_masuk = $request->getPost('longitude_masuk');

        $foto_masuk = str_replace('data:image/jpeg;base64,', '', $foto_masuk);
        $foto_masuk = base64_decode($foto_masuk);

        // Definisikan path uploads
        $upload_path = FCPATH . 'uploads/';
        // Gunakan path absolut
        $nama_foto = $id_pegawai.'_'.time().'.jpg';
        $foto_dir = $upload_path . $nama_foto;
        file_put_contents($foto_dir, $foto_masuk);

        $presensiModel = new PresensiModel();
        $presensiModel->insert([
            'id_pegawai' => $id_pegawai,
            'tanggal_masuk' => $tanggal_masuk,
            'jam_masuk' => $jam_masuk,
            'foto_masuk' => $nama_foto,
            'latitude_masuk' => $latitude_masuk,
            'longitude_masuk' => $longitude_masuk
        ]);

        session()->setFlashdata('success', 'Presensi masuk berhasil');

        return redirect()->to('/kepala_bagian/dashboard');

    }

    public function presensi_keluar($id)
    {       
        $latitude_keluar = $this->request->getPost('latitude_keluar');
        $longitude_keluar = $this->request->getPost('longitude_keluar');

        $data = [
            'title'=> 'Ambil Foto',
            'tanggal_keluar' => date('Y-m-d'),
            'jam_keluar' =>  $this->request->getPost('jam_keluar'),
            'id_presensi' => $id,
            'latitude_keluar' => $latitude_keluar,
            'longitude_keluar' => $longitude_keluar
        ];

        // dd($data);

        return view ('kepalaBagian/ambil_foto_keluar', $data);
    
        // Debug
        // dd($data);
    
        
    }

    public function presensi_keluar_aksi($id)
    {
        $request = \Config\Services::request();

        $tanggal_keluar = $request->getPost('tanggal_keluar');
        $jam_keluar = $request->getPost('jam_keluar');
        $foto_keluar = $request->getPost('foto_keluar');
        $latitude_keluar = $request->getPost('latitude_keluar');
        $longitude_keluar = $request->getPost('longitude_keluar');

        $foto_keluar = str_replace('data:image/jpeg;base64,', '', $foto_keluar);
        $foto_keluar = base64_decode($foto_keluar);

        // Definisikan path uploads
        $upload_path = FCPATH . 'uploads/';
        // Gunakan path absolut
        $nama_foto = $id.'_'.time().'.jpg';
        $foto_dir = $upload_path . $nama_foto;
        file_put_contents($foto_dir, $foto_keluar);

        $presensiModel = new PresensiModel();
        $presensiModel->update($id,[
            'tanggal_keluar' => $tanggal_keluar,
            'jam_keluar' => $jam_keluar,
            'foto_keluar' => $nama_foto,
            'latitude_keluar' => $latitude_keluar,
            'longitude_keluar' => $longitude_keluar
        ]);

        session()->setFlashdata('success', 'Presensi keluar berhasil');

        return redirect()->to('/kepala_bagian/dashboard');

    }
}
