<?php

namespace App\Controllers;

use App\Models\LoginModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Login extends BaseController
{
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
            $checkusername = $loginModel->where('username', $username)->first();
            
            if($checkusername){
                $password_db = $checkusername['password'];
                $verfiy_password = password_verify($password, $password_db);
                if($verfiy_password){

                    $session_data = [
                        'username' => $checkusername['username'],
                        'logged_in' => TRUE,
                        'role' => $checkusername['role'],
                        'id_pegawai' => $checkusername['id_pegawai']
                    ];
                    $session->set($session_data);
                    switch($checkusername['role']){
                        case "Admin" : 
                            return redirect()->to('admin/dashboard');
                        case "Pegawai" : 
                            return redirect()->to('pegawai/dashboard');
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
}
