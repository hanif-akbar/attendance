<?php

namespace App\Controllers\KepalaBagian;

use App\Controllers\BaseController;
use App\Models\KetidakhadiranModel;
use CodeIgniter\HTTP\ResponseInterface;

class Ketidakhadiran extends BaseController
{
    public function __construct()
    {
        helper(['url', 'form']);
    }
    public function index()
    {
        $ketidahadiranModel = new KetidakhadiranModel();
        $id_pegawai = session()->get('id_pegawai');
        $data = [
            'title' => 'Ketidakhadiran',
            'ketidakhadiran' => $ketidahadiranModel->where('id_pegawai', $id_pegawai)->findAll()
        ];

        return view('kepalaBagian/ketidakhadiran/data_ketidakhadiran', $data);
    }

    public function create(){
        $data = [
            'title' => 'Ajukan Ketidakhadiran',
            'validation' => \Config\Services::validation(),
        ];

        return view('kepalaBagian/ketidakhadiran/create_ketidakhadiran', $data);
    }

    public function store()
    {
        $rules = [
            'keterangan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Keterangan Wajib Diisi'
                ],
            ],
            'tanggal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Wajib Diisi'
                ],
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi Wajib Diisi'
                ],
            ],
            'file' => [
                'rules' => 'is_image[file]|mime_in[file,image/jpg,image/jpeg,image/png]|max_size[file,1048]',
                'errors' => [
                    'max_size' => 'Ukuran File lebih dari 1MB',
                    'is_image' => 'Yang Anda Pilih Bukan dalam Format Gambar',
                    'mime_in' => 'File Harus JPG, JPEG, PNG',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $ketidahadiranModel = new KetidakhadiranModel();

            $data = [
                'title' => 'Tambah Pengajuan Ketidakhadiran',
                'validation' => \Config\Services::validation(),
            ];

            echo view ('kepalaBagian/ketidakhadiran/create_ketidakhadiran',$data);
        }else{
            $ketidahadiranModel = new KetidakhadiranModel();

            $file = $this->request->getFile('file');
            if ($file->getError() == 4) {
                $nama_file = '';
            } else {
                $nama_file = $file->getRandomName();
                $file->move('ketidakhadiran', $nama_file);
            }

            $ketidahadiranModel->insert([
                'id_pegawai' => $this->request->getPost('id_pegawai'),
                'keterangan' => $this->request->getPost('keterangan'),
                'tanggal' => $this->request->getPost('tanggal'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'sttatus_pengajuan' => 'Pending',
                'file' => $nama_file,
            ]);
            
            
            session ()->setFlashdata('success', 'Pengajuan Berhasil Ditambahkan');

            return redirect()->to(base_url('/kepala_bagian/ketidakhadiran'));
        }
    }
    public function edit($id){
        $ketidahadiranModel = new KetidakhadiranModel();
        $data = [
            'title' => 'Edit Data Ketidakhadiran',
            'ketidakhadiran' => $ketidahadiranModel->find($id),
            'validation' => \Config\Services::validation(),
        ];

        return view('kepalaBagian/ketidakhadiran/edit_ketidakhadiran', $data);
    }


    public function update($id){
        $ketidahadiranModel = new KetidakhadiranModel();
        $rules = [
           'keterangan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Keterangan Wajib Diisi'
                ],
            ],
            'tanggal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Wajib Diisi'
                ],
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi Wajib Diisi'
                ],
            ],
            'file' => [
                'rules' => 'is_image[file]|mime_in[file,image/jpg,image/jpeg,image/png]|max_size[file,1048]',
                'errors' => [
                    'max_size' => 'Ukuran File lebih dari 1MB',
                    'is_image' => 'Yang Anda Pilih Bukan dalam Format Gambar',
                    'mime_in' => 'File Harus JPG, JPEG, PNG',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $ketidahadiranModel = new KetidakhadiranModel();

            $data = [
                'title' => 'Tambah Pengajuan Ketidakhadiran',
                'validation' => \Config\Services::validation(),
            ];

            echo view ('/kepalaBagian/ketidakhadiran/create_ketidakhadiran',$data);
        }else{
            $ketidahadiranModel = new KetidakhadiranModel();

            $file = $this->request->getFile('file');

            if ($file->getError() == 4) {
                $nama_file = $this->request->getPost('file_lama');
            } else {
                $nama_file = $file->getRandomName();
                $file->move('ketidakhadiran', $nama_file);
            }

            $ketidahadiranModel->update($id,[
                'keterangan' => $this->request->getPost('keterangan'),
                'tanggal' => $this->request->getPost('tanggal'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'file' => $nama_file,
            ]);
            
            session ()->setFlashdata('success', 'Data Ketidakhadiran Berhasil di Update');

            return redirect()->to(base_url('/kepala_bagian/ketidakhadiran'));


        }
    }

    public function delete($id){
        $ketidahadiranModel = new KetidakhadiranModel();
        $ketidakhadiran = $ketidahadiranModel->find($id);
        if($ketidakhadiran){
            $ketidahadiranModel->where('id_pegawai', $id)->delete();
            $ketidahadiranModel->delete($id);

            session()->setFlashdata('success', 'Data Ketidakhadiran Berhasil Dihapus');
            return redirect()->to(base_url('/kepala_bagian/ketidakhadiran'));
       }
    }
}