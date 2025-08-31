<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KetidakhadiranModel;
use App\Models\KepalaBagianModel;
use App\Models\PegawaiModel;
use App\Models\DivisiModel;

class VerifikasiKetidakhadiran extends BaseController
{
    protected $ketidakhadiranModel;
    protected $kepalaBagianModel;
    protected $pegawaiModel;
    protected $divisiModel;

    public function __construct()
    {
        $this->ketidakhadiranModel = new KetidakhadiranModel();
        $this->kepalaBagianModel = new KepalaBagianModel();
        $this->pegawaiModel = new PegawaiModel();
        $this->divisiModel = new DivisiModel();
        helper(['url', 'form']);
    }

    public function index()
    {
        $role = session()->get('role');
        $idPegawai = session()->get('id_pegawai');
        
        // Ambil data pegawai untuk mendapatkan divisi
        $pegawai = $this->pegawaiModel->find($idPegawai);
        $divisi = $pegawai['divisi'] ?? null;

        $data = [
            'title' => 'Verifikasi Ketidakhadiran',
            'ketidakhadiran' => $this->ketidakhadiranModel->getKetidakhadiranForVerifikasi($role, $idPegawai, $divisi),
            'role' => $role
        ];

        return view('admin/verifikasi_ketidakhadiran/index', $data);
    }

    public function detail($id)
    {
        $ketidakhadiran = $this->ketidakhadiranModel->getKetidakhadiranWithPegawai();
        $ketidakhadiran = array_filter($ketidakhadiran, function($item) use ($id) {
            return $item['id'] == $id;
        });
        $ketidakhadiran = reset($ketidakhadiran);

        if (!$ketidakhadiran) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Ketidakhadiran',
            'ketidakhadiran' => $ketidakhadiran
        ];

        return view('admin/verifikasi_ketidakhadiran/detail', $data);
    }

    public function verifikasi($id)
    {
        $status = $this->request->getPost('status');
        $catatan = $this->request->getPost('catatan');
        $role = session()->get('role');
        $idPegawai = session()->get('id_pegawai');

        $updateData = [];

        if ($role === 'kepala_bagian') {
            $updateData = [
                'status_verifikasi_kepala' => $status,
                'verifikasi_kepala_by' => $idPegawai,
                'verifikasi_kepala_at' => date('Y-m-d H:i:s'),
                'catatan_kepala' => $catatan
            ];

            // Update status pengajuan keseluruhan
            if ($status === 'approved') {
                $updateData['sttatus_pengajuan'] = 'Disetujui Kepala Bagian';
            } else {
                $updateData['sttatus_pengajuan'] = 'Ditolak';
            }

        } elseif ($role === 'direktur') {
            $updateData = [
                'status_verifikasi_direktur' => $status,
                'verifikasi_direktur_by' => $idPegawai,
                'verifikasi_direktur_at' => date('Y-m-d H:i:s'),
                'catatan_direktur' => $catatan
            ];

            // Update status pengajuan keseluruhan
            if ($status === 'approved') {
                $updateData['sttatus_pengajuan'] = 'Disetujui';
            } else {
                $updateData['sttatus_pengajuan'] = 'Ditolak';
            }

        } elseif ($role === 'admin') {
            // Admin bisa melakukan verifikasi final
            if ($this->request->getPost('verifikasi_type') === 'direktur') {
                $updateData = [
                    'status_verifikasi_direktur' => $status,
                    'verifikasi_direktur_by' => $idPegawai,
                    'verifikasi_direktur_at' => date('Y-m-d H:i:s'),
                    'catatan_direktur' => $catatan,
                    'sttatus_pengajuan' => $status === 'approved' ? 'Disetujui' : 'Ditolak'
                ];
            }
        }

        if ($this->ketidakhadiranModel->updateVerifikasi($id, $updateData)) {
            session()->setFlashdata('success', 'Verifikasi berhasil disimpan');
        } else {
            session()->setFlashdata('error', 'Gagal menyimpan verifikasi');
        }

        return redirect()->to(base_url('admin/verifikasi-ketidakhadiran'));
    }

    // Untuk mengelola kepala bagian
    public function kepalaBagian()
    {
        $data = [
            'title' => 'Kelola Kepala Bagian',
            'kepala_bagian' => $this->kepalaBagianModel->getKepalaBagianWithPegawai(),
            'pegawai' => $this->pegawaiModel->getPegawai(),
            'divisi' => $this->divisiModel->findAll()
        ];

        return view('admin/kepala_bagian/index', $data);
    }

    public function setKepalaBagian()
    {
        $idPegawai = $this->request->getPost('id_pegawai');
        $divisi = $this->request->getPost('divisi');

        if ($this->kepalaBagianModel->setKepalaBagian($idPegawai, $divisi)) {
            session()->setFlashdata('success', 'Kepala bagian berhasil ditetapkan');
        } else {
            session()->setFlashdata('error', 'Gagal menetapkan kepala bagian');
        }

        return redirect()->to(base_url('admin/kepala-bagian'));
    }

    public function removeKepalaBagian($idPegawai)
    {
        if ($this->kepalaBagianModel->removeKepalaBagian($idPegawai)) {
            session()->setFlashdata('success', 'Kepala bagian berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus kepala bagian');
        }

        return redirect()->to(base_url('admin/kepala-bagian'));
    }
}
