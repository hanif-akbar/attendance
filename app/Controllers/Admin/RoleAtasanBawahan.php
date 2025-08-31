<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class RoleAtasanBawahan extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Role Bawahan ke Atasan',
        ];

        return view('admin/roling/role', $data);
    }
}
