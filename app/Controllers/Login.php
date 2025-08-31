<?php

namespace App\Controllers;

use App\Models\LoginModel;
use App\Models\UsersModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Login extends BaseController
{
    protected $usersModel;

    public function __construct()
    {
        $this->usersModel = new UsersModel();
    }

    public function index()
    {
        $data = [
            'validation' => \Config\Services::validation(),
        ];
        return view('login', $data);
    }
    public function login_action()
    {
        // dd($this->request->getPost('username'));
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];
        
        if (!$this->validate($rules)) {
            $data['validation'] = $this->validator;
            return view('login', $data);
        }else {
            $session = session();
            $loginModel = new LoginModel();

            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $checkusername = $loginModel->getUserWithNama($username);
            
            if($checkusername){
                $password_db = $checkusername['password'];
                $verfiy_password = password_verify($password, $password_db);
                if($verfiy_password){

                    $session_data = [
                        'username' => $checkusername['username'],
                        'nama' => $checkusername['nama'], // Add the 'nama' field to session data
                        'logged_in' => TRUE,
                        'role' => $checkusername['role'],
                        'id_pegawai' => $checkusername['id_pegawai'],
                        'user_id' => $checkusername['id'], // Pastikan ini sesuai dengan kolom ID di tabel users
                    ];
                    $session->set($session_data);
                    switch($checkusername['role']){
                        case "Admin" : 
                            return redirect()->to('admin/dashboard');
                        case "Pegawai" : 
                            return redirect()->to('pegawai/dashboard');
                        case "Kepala Bagian" :
                            return redirect()->to('kepala_bagian/dashboard');
                        case "Direktur" :
                            return redirect()->to('direktur/dashboard');
                        default:
                            $session->setFlashdata('error', 'Role tidak ditemukan');
                            return redirect()->to('/');    
                    }
                }else {
                    $session->setFlashdata('error', 'Password salah, sialkan coba lagi');
                    return redirect()->to('/');    
                }
            }else {
                $session->setFlashdata('error', 'Username salah, silahkan coba lagi');
                return redirect()->to('/');
            }
        }
    }
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }
    public function ubahPassword()
    {
        // Cek apakah user sudah login dan memiliki role Pegawai
        if (!session()->get('logged_in') || (session()->get('role') !== 'Pegawai')) {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Ubah Password'
        ];

        return view('pegawai/ubah_password', $data);
    }

    // Method untuk memproses ubah password
    public function ubahPasswordAuth()
    {
        // Cek apakah user sudah login dan memiliki role Pegawai
        if (!session()->get('logged_in') || (session()->get('role') !== 'Pegawai')) {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        // Validasi input
        $rules = [
            'old_password' => [
                'label' => 'Password Lama',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password lama harus diisi'
                ]
            ],
            'new_password' => [
                'label' => 'Password Baru',
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Password baru harus diisi',
                    'min_length' => 'Password baru minimal 8 karakter'
                ]
            ],
            'confirm_password' => [
                'label' => 'Konfirmasi Password',
                'rules' => 'required|matches[new_password]',
                'errors' => [
                    'required' => 'Konfirmasi password harus diisi',
                    'matches' => 'Konfirmasi password tidak cocok dengan password baru'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        // Ambil data dari form
        $old_password = $this->request->getPost('old_password');
        $new_password = $this->request->getPost('new_password');

        // Ambil user ID dari session
        $user_id = session()->get('user_id');
        
        // Cari user berdasarkan ID
        $user = $this->usersModel->find($user_id);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        // Verifikasi password lama
        if (!password_verify($old_password, $user['password'])) {
            return redirect()->back()->with('error', 'Password lama salah');
        }

        // Hash password baru
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update password di database
        $update_data = [
            'password' => $hashed_password
        ];

        if ($this->usersModel->update($user_id, $update_data)) {
            session()->setFlashdata('success', 'Password berhasil diubah');
            return redirect()->to('pegawai/dashboard')->with('success', 'Password berhasil diubah');
        } else {
            return redirect()->back()->with('error', 'Gagal mengubah password');
        }
    }

     public function ubahUsername()
    {
        // Cek apakah user sudah login dan memiliki role Pegawai
        if (!session()->get('logged_in') || session()->get('role') !== 'Pegawai') {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Ubah Username'
        ];

        return view('pegawai/ubah_username', $data);
    }

    // Method untuk memproses ubah username
    public function ubahUsernameAuth()
    {
        // Cek apakah user sudah login dan memiliki role Pegawai
        if (!session()->get('logged_in') || session()->get('role') !== 'Pegawai') {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        // Validasi input
        $rules = [
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password harus diisi untuk konfirmasi'
                ]
            ],
            'new_username' => [
                'label' => 'Username Baru',
                'rules' => 'required|min_length[3]|max_length[50]|regex_match[/^[a-zA-Z0-9._-]+$/]|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username baru harus diisi',
                    'min_length' => 'Username minimal 3 karakter',
                    'max_length' => 'Username maksimal 50 karakter',
                    'regex_match' => 'Username hanya boleh menggunakan huruf, angka, titik, underscore, dan dash',
                    'is_unique' => 'Username sudah digunakan oleh user lain, silakan pilih username yang berbeda'
                ]
            ],
            'confirm_username' => [
                'label' => 'Konfirmasi Username',
                'rules' => 'required|matches[new_username]',
                'errors' => [
                    'required' => 'Konfirmasi username harus diisi',
                    'matches' => 'Konfirmasi username tidak cocok dengan username baru'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        // Ambil data dari form
        $password = $this->request->getPost('password');
        $new_username = $this->request->getPost('new_username');
        $current_username = session()->get('username');

        // Cek apakah username baru sama dengan username lama
        if ($new_username === $current_username) {
            return redirect()->back()->with('error', 'Username baru tidak boleh sama dengan username saat ini');
        }

        // Ambil user ID dari session
        $user_id = session()->get('user_id');
        
        // Cari user berdasarkan ID
        $user = $this->usersModel->find($user_id);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        // Verifikasi password
        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah');
        }

        // Double check username uniqueness (untuk keamanan ekstra)
        $existingUser = $this->usersModel->where('username', $new_username)
                                         ->where('id !=', $user_id)
                                         ->first();
        
        if ($existingUser) {
            return redirect()->back()->with('error', 'Username sudah digunakan oleh user lain');
        }

        // Update username di database
        $update_data = [
            'username' => $new_username
        ];

        if ($this->usersModel->update($user_id, $update_data)) {
            // Update session dengan username baru
            session()->set('username', $new_username);
            
            session()->setFlashdata('success', 'Username berhasil diubah menjadi: ' . $new_username);
            return redirect()->to('pegawai/dashboard')->with('success', 'Username berhasil diubah');
        } else {
            return redirect()->back()->with('error', 'Gagal mengubah username');
        }
    }

    public function ubahPasswordKepalaBagian()
    {
        // Cek apakah user sudah login dan memiliki role Kepala Bagian
        if (!session()->get('logged_in') || (session()->get('role') !== 'Kepala Bagian')) {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Ubah Password'
        ];

        return view('kepalaBagian/ubah_password', $data);
    }

    public function ubahPasswordAuthKepalaBagian()
    {
        // Cek apakah user sudah login dan memiliki role Kepala Bagian
        if (!session()->get('logged_in') || (session()->get('role') !== 'Kepala Bagian')) {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        // Validasi input
        $rules = [
            'old_password' => [
                'label' => 'Password Lama',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password lama harus diisi'
                ]
            ],
            'new_password' => [
                'label' => 'Password Baru',
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Password baru harus diisi',
                    'min_length' => 'Password baru minimal 8 karakter'
                ]
            ],
            'confirm_password' => [
                'label' => 'Konfirmasi Password',
                'rules' => 'required|matches[new_password]',
                'errors' => [
                    'required' => 'Konfirmasi password harus diisi',
                    'matches' => 'Konfirmasi password tidak cocok dengan password baru'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        // Ambil data dari form
        $old_password = $this->request->getPost('old_password');
        $new_password = $this->request->getPost('new_password');

        // Ambil user ID dari session
        $user_id = session()->get('user_id');
        
        // Cari user berdasarkan ID
        $user = $this->usersModel->find($user_id);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        // Verifikasi password lama
        if (!password_verify($old_password, $user['password'])) {
            return redirect()->back()->with('error', 'Password lama salah');
        }

        // Hash password baru
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update password di database
        $update_data = [
            'password' => $hashed_password
        ];

        if ($this->usersModel->update($user_id, $update_data)) {
            session()->setFlashdata('success', 'Password berhasil diubah');
            return redirect()->to('kepala_bagian/dashboard')->with('success', 'Password berhasil diubah');
        } else {
            return redirect()->back()->with('error', 'Gagal mengubah password');
        }
    }

    public function ubahUsernameKepalaBagian()
    {
        // Cek apakah user sudah login dan memiliki role Kepala Bagian
        if (!session()->get('logged_in') || session()->get('role') !== 'Kepala Bagian') {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Ubah Username'
        ];

        return view('kepalaBagian/ubah_username', $data);
    }

    public function ubahUsernameAuthKepalaBagian()
    {
        // Cek apakah user sudah login dan memiliki role Kepala Bagian
        if (!session()->get('logged_in') || session()->get('role') !== 'Kepala Bagian') {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        // Validasi input
        $rules = [
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password harus diisi untuk konfirmasi'
                ]
            ],
            'new_username' => [
                'label' => 'Username Baru',
                'rules' => 'required|min_length[3]|max_length[50]|regex_match[/^[a-zA-Z0-9._-]+$/]|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username baru harus diisi',
                    'min_length' => 'Username minimal 3 karakter',
                    'max_length' => 'Username maksimal 50 karakter',
                    'regex_match' => 'Username hanya boleh menggunakan huruf, angka, titik, underscore, dan dash',
                    'is_unique' => 'Username sudah digunakan oleh user lain, silakan pilih username yang berbeda'
                ]
            ],
            'confirm_username' => [
                'label' => 'Konfirmasi Username',
                'rules' => 'required|matches[new_username]',
                'errors' => [
                    'required' => 'Konfirmasi username harus diisi',
                    'matches' => 'Konfirmasi username tidak cocok dengan username baru'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        // Ambil data dari form
        $password = $this->request->getPost('password');
        $new_username = $this->request->getPost('new_username');
        $current_username = session()->get('username');

        // Cek apakah username baru sama dengan username lama
        if ($new_username === $current_username) {
            return redirect()->back()->with('error', 'Username baru tidak boleh sama dengan username saat ini');
        }

        // Ambil user ID dari session
        $user_id = session()->get('user_id');
        
        // Cari user berdasarkan ID
        $user = $this->usersModel->find($user_id);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        // Verifikasi password
        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah');
        }

        // Double check username uniqueness (untuk keamanan ekstra)
        $existingUser = $this->usersModel->where('username', $new_username)
                                         ->where('id !=', $user_id)
                                         ->first();
        
        if ($existingUser) {
            return redirect()->back()->with('error', 'Username sudah digunakan oleh user lain');
        }

        // Update username di database
        $update_data = [
            'username' => $new_username
        ];

        if ($this->usersModel->update($user_id, $update_data)) {
            // Update session dengan username baru
            session()->set('username', $new_username);
            
            session()->setFlashdata('success', 'Username berhasil diubah menjadi: ' . $new_username);
            return redirect()->to('kepala_bagian/dashboard')->with('success', 'Username berhasil diubah');
        } else {
            return redirect()->back()->with('error', 'Gagal mengubah username');
        }
    }

    public function ubahPasswordDirektur()
    {
        // Cek apakah user sudah login dan memiliki role Direktur
        if (!session()->get('logged_in') || (session()->get('role') !== 'Direktur')) {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Ubah Password'
        ];

        return view('direktur/ubah_password', $data);
    }

    public function ubahPasswordAuthDirektur()
    {
        // Cek apakah user sudah login dan memiliki role Direktur
        if (!session()->get('logged_in') || (session()->get('role') !== 'Direktur')) {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        // Validasi input
        $rules = [
            'old_password' => [
                'label' => 'Password Lama',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password lama harus diisi'
                ]
            ],
            'new_password' => [
                'label' => 'Password Baru',
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Password baru harus diisi',
                    'min_length' => 'Password baru minimal 8 karakter'
                ]
            ],
            'confirm_password' => [
                'label' => 'Konfirmasi Password',
                'rules' => 'required|matches[new_password]',
                'errors' => [
                    'required' => 'Konfirmasi password harus diisi',
                    'matches' => 'Konfirmasi password tidak cocok dengan password baru'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        // Ambil data dari form
        $old_password = $this->request->getPost('old_password');
        $new_password = $this->request->getPost('new_password');

        // Ambil user ID dari session
        $user_id = session()->get('user_id');
        
        // Cari user berdasarkan ID
        $user = $this->usersModel->find($user_id);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        // Verifikasi password lama
        if (!password_verify($old_password, $user['password'])) {
            return redirect()->back()->with('error', 'Password lama salah');
        }

        // Hash password baru
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update password di database
        $update_data = [
            'password' => $hashed_password
        ];

        if ($this->usersModel->update($user_id, $update_data)) {
            session()->setFlashdata('success', 'Password berhasil diubah');
            return redirect()->to('direktur/dashboard')->with('success', 'Password berhasil diubah');
        } else {
            return redirect()->back()->with('error', 'Gagal mengubah password');
        }
    }

    public function ubahUsernameDirektur()
    {
        // Cek apakah user sudah login dan memiliki role Direktur
        if (!session()->get('logged_in') || session()->get('role') !== 'Direktur') {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $data = [
            'title' => 'Ubah Username'
        ];

        return view('direktur/ubah_username', $data);
    }

    public function ubahUsernameAuthDirektur()
    {
        // Cek apakah user sudah login dan memiliki role Direktur
        if (!session()->get('logged_in') || session()->get('role') !== 'Direktur') {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        // Validasi input
        $rules = [
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password harus diisi untuk konfirmasi'
                ]
            ],
            'new_username' => [
                'label' => 'Username Baru',
                'rules' => 'required|min_length[3]|max_length[50]|regex_match[/^[a-zA-Z0-9._-]+$/]|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username baru harus diisi',
                    'min_length' => 'Username minimal 3 karakter',
                    'max_length' => 'Username maksimal 50 karakter',
                    'regex_match' => 'Username hanya boleh menggunakan huruf, angka, titik, underscore, dan dash',
                    'is_unique' => 'Username sudah digunakan oleh user lain, silakan pilih username yang berbeda'
                ]
            ],
            'confirm_username' => [
                'label' => 'Konfirmasi Username',
                'rules' => 'required|matches[new_username]',
                'errors' => [
                    'required' => 'Konfirmasi username harus diisi',
                    'matches' => 'Konfirmasi username tidak cocok dengan username baru'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        // Ambil data dari form
        $password = $this->request->getPost('password');
        $new_username = $this->request->getPost('new_username');
        $current_username = session()->get('username');

        // Cek apakah username baru sama dengan username lama
        if ($new_username === $current_username) {
            return redirect()->back()->with('error', 'Username baru tidak boleh sama dengan username saat ini');
        }

        // Ambil user ID dari session
        $user_id = session()->get('user_id');
        
        // Cari user berdasarkan ID
        $user = $this->usersModel->find($user_id);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        // Verifikasi password
        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah');
        }

        // Double check username uniqueness (untuk keamanan ekstra)
        $existingUser = $this->usersModel->where('username', $new_username)
                                         ->where('id !=', $user_id)
                                         ->first();
        
        if ($existingUser) {
            return redirect()->back()->with('error', 'Username sudah digunakan oleh user lain');
        }

        // Update username di database
        $update_data = [
            'username' => $new_username
        ];

        if ($this->usersModel->update($user_id, $update_data)) {
            // Update session dengan username baru
            session()->set('username', $new_username);
            
            session()->setFlashdata('success', 'Username berhasil diubah menjadi: ' . $new_username);
            return redirect()->to('direktur/dashboard')->with('success', 'Username berhasil diubah');
        } else {
            return redirect()->back()->with('error', 'Gagal mengubah username');
        }
    }

}


