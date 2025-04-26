<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JabatanModel;
use App\Models\PegawaiModel;
use App\Models\UsersModel;
use App\Models\ClockInOutLocationModel;
use CodeIgniter\HTTP\ResponseInterface;

class DataPegawai extends BaseController
{
    public function __construct()
    {
        helper(['url', 'form']);
    }
    public function index()
    {
        $pegawaiModel = new PegawaiModel();

        $data = [
            'title' => 'Data Pegawai',
            'pegawai' => $pegawaiModel->findAll(),
            'pegawai' => $pegawaiModel->getPegawai(),
        ];

        return view('admin/data_pegawai/data_pegawai', $data);
    }
    public function detail($id)
    {
        $pegawaiModel = new PegawaiModel();
        $data = [
            'title' => 'Detail Pegawai',
            'pegawai' => $pegawaiModel->detailPegawai($id),
        ];

        return view('admin/data_pegawai/detail', $data);
    }

    public function create(){
        
        $jabatanModel = new JabatanModel();
        $clockInOutLocationModel = new ClockInOutLocationModel();
        $data = [
            'title' => 'Tambah data pegawai',
            'clock_in_out_location' => $clockInOutLocationModel->findAll(),
            'jabatan' => $jabatanModel->orderBy('jabatan','ASC')->findAll(),
            'validation' => \Config\Services::validation(),
        ];

        return view('admin/data_pegawai/create', $data);
    }

    public function store()
    {
        $rules = [
            'nip' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'ID Pegawai Wajib Diisi'
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Wajib Diisi'
                ],
            ],
            'jenis_kelamin' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis Kelamin Wajib Diisi'
                ],
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat Wajib Diisi'
                ],
            ],
            'no_handphone' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No Handphone Wajib Diisi'
                ],
            ],
            'jabatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jabatan Wajib Diisi'
                ],
            ],
            'foto' => [
                'rules' => 'uploaded[foto]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,5048]',
                'errors' => [
                    'required' => 'Foto Wajib diUploade',
                    'max_size' => 'Ukuran Foto lebih dari 5MB',
                    'is_image' => 'Yang Anda Pilih Bukan Foto',
                    'mime_in' => 'Foto Harus JPG, JPEG, PNG',
                ]
            ],
            'tanggal_lahir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Lahir Wajib Diisi'
                ],
            ],
            'tanggal_masuk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Masuk Wajib Diisi'
                ],
            ],
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status Kepegawaian Wajib Diisi'
                ],
            ],
            'username' => [
                'rules' => 'required|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username wajib diisi',
                    'is_unique' => 'Username sudah terdaftar'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password wajib diisi'
                ]
            ],
            'konfirmasi_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi Password wajib diisi',
                    'matches' => 'Konfirmasi Password tidak sama'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $jabatanModel = new JabatanModel();
            $clockInOutLocationModel = new ClockInOutLocationModel();
  
            $data = [
                'title' => 'Tambah data pegawai',
                'clock_in_out_location' => $clockInOutLocationModel->findAll(),
                'jabatan' => $jabatanModel->orderBy('jabatan','ASC')->findAll(),
                'validation' => \Config\Services::validation(),
            ];
            
            echo view ('/admin/data_pegawai/create',$data);
        }else{
            $pegawaiModel = new PegawaiModel();

            $foto = $this->request->getFile('foto');
            if ($foto->getError() == 4) {
                $nama_foto = '';
            } else {
                $nama_foto = $foto->getRandomName();
                $foto->move('profile', $nama_foto);
            }

            $pegawaiModel->insert([
                'jabatan' => $this->request->getPost('jabatan'),
                'nip' => $this->request->getPost('nip'),
                'nama' => $this->request->getPost('nama'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                'alamat' => $this->request->getPost('alamat'),
                'no_handphone' => $this->request->getPost('no_handphone'),
                'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
                'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
                'clock_in_out_location' => $this->request->getPost('clock_in_out_location'),
                'foto' => $nama_foto,
            ]);
            
            $is_pegawai = $pegawaiModel->insertID();
            $usersModel = new UsersModel();   
            $usersModel->insert([
                'id_pegawai' => $is_pegawai,
                'username' => $this->request->getPost('username'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'status' => $this->request->getPost('status'),
                'role' => $this->request->getPost('role'),
            ]);
            
            session ()->setFlashdata('success', 'Data Pegawai Berhasil Ditambahkan');

            return redirect()->to(base_url('/admin/data_pegawai'));
            

        }
    }

    public function edit($id){
        $jabatanModel = new JabatanModel();
        $clockInOutLocationModel = new ClockInOutLocationModel();
        $pegawaiModel = new PegawaiModel();
        $data = [
            'title' => 'Edit Data Pegawai',
            'pegawai' => $pegawaiModel->detailPegawai($id),
            'clock_in_out_location' => $clockInOutLocationModel->findAll(),
            'jabatan' => $jabatanModel->orderBy('jabatan','ASC')->findAll(),
            'validation' => \Config\Services::validation(),
        ];
        // dd($data['jabatan']);

        return view('admin/data_pegawai/edit', $data);
    }


    public function update($id)
    {
        $rules = [
            'nip' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'ID Pegawai Wajib Diisi'
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Wajib Diisi'
                ],
            ],
            'jenis_kelamin' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis Kelamin Wajib Diisi'
                ],
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat Wajib Diisi'
                ],
            ],
            'no_handphone' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No Handphone Wajib Diisi'
                ],
            ],
            'jabatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jabatan Wajib Diisi'
                ],
            ],
            'foto' => [
                'rules' => 'is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,5048]',
                'errors' => [
                    'max_size' => 'Ukuran Foto lebih dari 5MB',
                    'is_image' => 'Yang Anda Pilih Bukan Foto',
                    'mime_in' => 'Foto Harus JPG, JPEG, PNG',
                ]
            ],
            'tanggal_lahir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Lahir Wajib Diisi'
                ],
            ],
            'tanggal_masuk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Masuk Wajib Diisi'
                ],
            ],
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status Kepegawaian Wajib Diisi'
                ],
            ],
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Username wajib diisi'
                ]
            ],
            'konfirmasi_password' => [
                'rules' => 'matches[password]',
                'errors' => [
                    'matches' => 'Konfirmasi Password tidak sama'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $jabatanModel = new JabatanModel();
            $pegawaiModel = new PegawaiModel();
            $clockInOutLocationModel = new ClockInOutLocationModel();
            $data = [
                'title' => 'Edit Data Pegawai',
                'pegawai' => $pegawaiModel->detailPegawai($id),
                'clock_in_out_location' => $clockInOutLocationModel->findAll(),
                'jabatan' => $jabatanModel->orderBy('jabatan','ASC')->findAll(),
                'validation' => \Config\Services::validation(),
            ];
            
            echo view ('/admin/data_pegawai/edit',$data);
        }else{
            $pegawaiModel = new PegawaiModel();
            $clockInOutLocationModel = new ClockInOutLocationModel();
            $usersModel = new UsersModel();

            $foto = $this->request->getFile('foto');

            if ($foto->getError() == 4) {
                $nama_foto = $this->request->getPost('foto_lama');
            } else {
                $nama_foto = $foto->getRandomName();
                $foto->move('profile', $nama_foto);
            }

            $pegawaiModel->update($id,[
                'jabatan' => $this->request->getPost('jabatan'),
                'nip' => $this->request->getPost('nip'),
                'nama' => $this->request->getPost('nama'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                'alamat' => $this->request->getPost('alamat'),
                'no_handphone' => $this->request->getPost('no_handphone'),
                'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
                'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
                'clock_in_out_location' => $this->request->getPost('clock_in_out_location'),
                'foto' => $nama_foto,
            ]);

            if($this->request->getPost('password') == '') {
                $password = $this->request->getPost('password_lama');
            }else{
                $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            }
            
            $usersModel
                ->where('id_pegawai',$id)
                ->set(
                    ['username' => $this->request->getPost('username'),
                    'password' => $password,
                    'status' => $this->request->getPost('status'),
                    'role' => $this->request->getPost('role'),
                    ]
                    )
                ->update();
            
            session ()->setFlashdata('success', 'Data Pegawai Berhasil di Update');

            return redirect()->to(base_url('/admin/data_pegawai'));
            

        }
    }

    public function delete($id){
        $pegawaiModel = new PegawaiModel();
        $userModel = new UsersModel();
        $jabatan = $pegawaiModel->find($id);
        if($jabatan){
            $userModel->where('id_pegawai', $id)->delete();
            $pegawaiModel->delete($id);

            session()->setFlashdata('success', 'Data Pegawai Berhasil Dihapus');
            return redirect()->to(base_url('/admin/data_pegawai'));
       }
    }
}
