<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KetidakhadiranModel;
use CodeIgniter\HTTP\ResponseInterface;

class Ketidakhadiran extends BaseController
{
    public function index()
    {
        $ketidakhadiranModel = new KetidakhadiranModel();
        $data = [
            'title' => 'Data Ketidakhadiran',
            'ketidakhadiran' => $ketidakhadiranModel->findAll(),
        ];

        return view('admin/ketidakhadiran/data_ketidakhadiran', $data);
    }
    
    public function approved($id){
        $ketidahadiranModel = new KetidakhadiranModel();

            $ketidahadiranModel = new KetidakhadiranModel();

            $file = $this->request->getFile('file');


            $ketidahadiranModel->update($id,[
                'sttatus_pengajuan' => 'Disetujui',
            ]);

            session ()->setFlashdata('success', 'Pengajuan berhasil di approve.');

            return redirect()->to(base_url('/admin/ketidakhadiran'));
    }

    public function rejected($id){
        $ketidahadiranModel = new KetidakhadiranModel();

        $ketidahadiranModel->update($id, [
            'sttatus_pengajuan' => 'Ditolak',
        ]);

        session()->setFlashdata('success', 'Pengajuan berhasil ditolak.');

        return redirect()->to(base_url('/admin/ketidakhadiran'));
    }
}
