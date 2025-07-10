<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DivisiModel;
use CodeIgniter\HTTP\ResponseInterface;

class Divisi extends BaseController
{
    public function index()
    {
        $divisiModel = new DivisiModel();
        $data = [
            'title' => 'Data Divisi',
            'divisi' => $divisiModel->findAll(),
        ];

        return view('admin/divisi/divisi', $data);
    }

     public function create(){
        $data = [
            'title' => 'Tambah Divisi',
            'validation' => \Config\Services::validation(),
        ];

        return view('admin/divisi/create', $data);
    }

     public function store(){
        $rules = [
            'divisi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Divisi Harus Diisi'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            $data = [
                'title' => 'Tambah Divisi',
                'validation' => \Config\Services::validation(),
            ];

            echo view ('/admin/divisi/create',$data);
        }else{
            $divisiModel = new DivisiModel();
            $divisiModel->insert([
                'divisi' => $this->request->getPost('divisi'),
            ]);

            session ()->setFlashdata('success', 'Data Divisi Berhasil Ditambahkan');

            return redirect()->to(base_url('/admin/divisi'));
            

        }
    }

    public function edit($id){
        $divisiModel = new DivisiModel();
        $data = [
            'title' => 'Edit Divisi',
            'divisi' => $divisiModel->find($id),
            'validation' => \Config\Services::validation(),
        ];

        return view('admin/divisi/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'divisi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Divisi Harus Diisi'
                ]
            ]
        ];

        $divisiModel = new DivisiModel();
        if (!$this->validate($rules)) {
            $data = [
                'title' => 'Edit Divisi',
                'divisi' => $divisiModel->find($id),
                'validation' => \Config\Services::validation(),
            ];

            echo view ('/admin/divisi/edit',$data);
        }else{
            $divisiModel = new DivisiModel();
            $divisiModel->update($id,[
                'divisi' => $this->request->getPost('divisi'),
            ]);

            session ()->setFlashdata('success', 'Data Divisi Berhasil di Update');

            return redirect()->to(base_url('/admin/divisi'));
            

        }
    }

    public function delete($id){
        $divisiModel = new DivisiModel();

        $divisi = $divisiModel->find($id);
        if($divisi){
            $divisiModel->delete($id);
            session()->setFlashdata('success', 'Data Divisi Berhasil Dihapus');
            return redirect()->to(base_url('/admin/divisi'));
       }
    }
}
