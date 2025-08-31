<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PresensiModel;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class RekapPresensi extends BaseController
{
    public function rekap_harian()
    {
        $presensiModel = new PresensiModel();
        $filter_tanggal = $this->request->getVar('filter_tanggal');
        if ($filter_tanggal){
            if (isset($_GET['export_excel_harian'])){
                $rekap_harian = $presensiModel->rekap_harian_filter($filter_tanggal);
                $spreadsheet = new Spreadsheet();
                $activeWorksheet = $spreadsheet->getActiveSheet();
                // $activeWorksheet->setCellValue('A1', 'Hello World !');

                $spreadsheet->getActiveSheet()->mergeCells('A1:C1');
                $spreadsheet->getActiveSheet()->mergeCells('A3:B3');
                $spreadsheet->getActiveSheet()->mergeCells('A3:E3');

                $activeWorksheet->setCellValue('A1', 'REKAP PRESENSI MINGGUAN');
                $activeWorksheet->setCellValue('A3', 'MINGGU KE');
                $activeWorksheet->setCellValue('C3', $filter_tanggal);
                $activeWorksheet->setCellValue('A4', 'NO');
                $activeWorksheet->setCellValue('B4', 'ID');
                $activeWorksheet->setCellValue('C4', 'NAMA PEGAWAI');
                $activeWorksheet->setCellValue('D4', 'TANGGAL MASUK');
                $activeWorksheet->setCellValue('E4', 'JAM MASUK');
                $activeWorksheet->setCellValue('F4', 'KOORDINAT MASUK');
                $activeWorksheet->setCellValue('G4', 'FOTO MASUK');
                $activeWorksheet->setCellValue('H4', 'TANGGAL KELUAR');
                $activeWorksheet->setCellValue('I4', 'JAM KELUAR');
                $activeWorksheet->setCellValue('J4', 'KOORDINAT KELUAR');
                $activeWorksheet->setCellValue('K4', 'FOTO KELUAR');
                $activeWorksheet->setCellValue('L4', 'TOTAL JAM KERJA');
                $activeWorksheet->setCellValue('M4', 'TOTAL TERLAMBAT');

                $rows = 5;
                $no = 1;
                foreach ($rekap_harian as $rekap) {
                    //Menghitung Total Jam Kerja
                    $timestamp_jam_masuk = strtotime($rekap['tanggal_masuk']. $rekap['jam_masuk']);
                    $timestamp_jam_keluar = strtotime($rekap['tanggal_keluar']. $rekap['jam_keluar']);

                    $selisih = $timestamp_jam_keluar - $timestamp_jam_masuk;
                    $jam = floor($selisih / 3600);
                    $selisih -= $jam * 3600;
                    $menit = floor($selisih / 60);

                    // Menghitug Total Keterlambatan
                    $jam_masuk_real = strtotime($rekap['jam_masuk']);
                    $jam_masuk_kantor = strtotime($rekap['jam_masuk_office']);
                    $selisih_keterlambatan = $jam_masuk_real - $jam_masuk_kantor;
                    $jam_terlambat = floor($selisih_keterlambatan / 3600);
                    $selisih_keterlambatan -= $jam_terlambat * 3600;
                    $menit_terlambat = floor($selisih_keterlambatan / 60);

                    // Menulis data ke spreadsheet
                    $activeWorksheet->setCellValue('A'.$rows, $no++);
                    $activeWorksheet->setCellValue('B'.$rows, $rekap['nip']);
                    $activeWorksheet->setCellValue('C'.$rows, $rekap['nama']);
                    $activeWorksheet->setCellValue('D'.$rows, $rekap['tanggal_masuk']);
                    $activeWorksheet->setCellValue('E'.$rows, $rekap['jam_masuk']);
                    $activeWorksheet->setCellValue('F'.$rows, $rekap['latitude_masuk'] . ', ' . $rekap['longitude_masuk']);
                    // Tambahkan gambar untuk foto masuk
                    if (!empty($rekap['foto_masuk'])) {
                        $fotoPath = FCPATH . 'uploads/' . $rekap['foto_masuk'];
                        if (file_exists($fotoPath)) {
                            $drawing = new Drawing();
                            $drawing->setName('Foto Masuk ' . $no);
                            $drawing->setDescription('Foto Masuk');
                            $drawing->setPath($fotoPath);
                            $drawing->setCoordinates('G'.$rows); 
                            $drawing->setWidth(60);
                            $drawing->setHeight(60);
                            $drawing->setWorksheet($activeWorksheet);
                            
                            // Sesuaikan tinggi baris untuk menampung gambar
                            $activeWorksheet->getRowDimension($rows)->setRowHeight(60);
                        } else {
                            $activeWorksheet->setCellValue('G'.$rows, 'Foto tidak ditemukan');
                        }
                    }
                    // $activeWorksheet->setCellValue('G'.$rows, $rekap['foto_masuk']);
                    $activeWorksheet->setCellValue('H'.$rows, $rekap['tanggal_keluar']);
                    $activeWorksheet->setCellValue('I'.$rows, $rekap['jam_keluar']);
                    $activeWorksheet->setCellValue('J'.$rows, $rekap['latitude_keluar'] . ', ' . $rekap['longitude_keluar']);
                    // Tambahkan gambar untuk foto keluar
                    if (!empty($rekap['foto_keluar'])) {
                        $fotoPath = FCPATH . 'uploads/' . $rekap['foto_keluar'];
                        if (file_exists($fotoPath)) {
                            $drawing = new Drawing();
                            $drawing->setName('Foto Keluar ' . $no);
                            $drawing->setDescription('Foto Keluar');
                            $drawing->setPath($fotoPath);
                            $drawing->setCoordinates('K'.$rows); 
                            $drawing->setWidth(60);
                            $drawing->setHeight(60);
                            $drawing->setOffsetX(5);
                            $drawing->setWorksheet($activeWorksheet);
                        } else {
                            $activeWorksheet->setCellValue('K'.$rows, 'Foto tidak ditemukan');
                        }
                    }
                    // $activeWorksheet->setCellValue('K'.$rows, $rekap['foto_keluar']);
                    $activeWorksheet->setCellValue('L'.$rows, $jam.' Jam '. $menit.' Menit');
                    $activeWorksheet->setCellValue('M'.$rows, $jam_terlambat.' Jam '. $menit_terlambat.' Menit');
                    $rows++;
                }

                // redirect output to client browser
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="rekap_presensi_harian.xlsx"');
                header('Cache-Control: max-age=0');

                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
                // dd(1234);
            }else {
                $rekap_harian = $presensiModel->rekap_harian_filter($filter_tanggal);
            }
        }else{
            $rekap_harian = $presensiModel->rekap_harian();
        }
        $data = [
            'title' => 'Rekap Harian',
            'rekap_harian' => $rekap_harian
        ];
        return view('admin/rekap_presensi/rekap_harian', $data);
    }

    public function rekap_mingguan(){
        $presensiModel = new PresensiModel();
        $filter_mingguan = $this->request->getVar('filter_mingguan');

        if ($filter_mingguan) {
            if (isset($_GET['export_excel_mingguan'])){
                $rekap_mingguan = $presensiModel->rekap_mingguan_filter($filter_mingguan);
                $spreadsheet = new Spreadsheet();
                $activeWorksheet = $spreadsheet->getActiveSheet();
                // $activeWorksheet->setCellValue('A1', 'Hello World !');

                $spreadsheet->getActiveSheet()->mergeCells('A1:C1');
                $spreadsheet->getActiveSheet()->mergeCells('A3:B3');
                $spreadsheet->getActiveSheet()->mergeCells('A3:E3');

                $activeWorksheet->setCellValue('A1', 'REKAP PRESENSI MINGGUAN');
                $activeWorksheet->setCellValue('A3', 'MINGGU KE');
                $activeWorksheet->setCellValue('C3', $filter_mingguan);
                $activeWorksheet->setCellValue('A4', 'NO');
                $activeWorksheet->setCellValue('B4', 'ID');
                $activeWorksheet->setCellValue('C4', 'NAMA PEGAWAI');
                $activeWorksheet->setCellValue('D4', 'TANGGAL MASUK');
                $activeWorksheet->setCellValue('E4', 'JAM MASUK');
                $activeWorksheet->setCellValue('F4', 'KOORDINAT MASUK');
                $activeWorksheet->setCellValue('G4', 'FOTO MASUK');
                $activeWorksheet->setCellValue('H4', 'TANGGAL KELUAR');
                $activeWorksheet->setCellValue('I4', 'JAM KELUAR');
                $activeWorksheet->setCellValue('J4', 'KOORDINAT KELUAR');
                $activeWorksheet->setCellValue('K4', 'FOTO KELUAR');
                $activeWorksheet->setCellValue('L4', 'TOTAL JAM KERJA');
                $activeWorksheet->setCellValue('M4', 'TOTAL TERLAMBAT');

                $rows = 5;
                $no = 1;
                foreach ($rekap_mingguan as $rekap) {
                    //Menghitung Total Jam Kerja
                    $timestamp_jam_masuk = strtotime($rekap['tanggal_masuk']. $rekap['jam_masuk']);
                    $timestamp_jam_keluar = strtotime($rekap['tanggal_keluar']. $rekap['jam_keluar']);

                    $selisih = $timestamp_jam_keluar - $timestamp_jam_masuk;
                    $jam = floor($selisih / 3600);
                    $selisih -= $jam * 3600;
                    $menit = floor($selisih / 60);

                    // Menghitug Total Keterlambatan
                    $jam_masuk_real = strtotime($rekap['jam_masuk']);
                    $jam_masuk_kantor = strtotime($rekap['jam_masuk_office']);
                    $selisih_keterlambatan = $jam_masuk_real - $jam_masuk_kantor;
                    $jam_terlambat = floor($selisih_keterlambatan / 3600);
                    $selisih_keterlambatan -= $jam_terlambat * 3600;
                    $menit_terlambat = floor($selisih_keterlambatan / 60);

                    // Menulis data ke spreadsheet
                    $activeWorksheet->setCellValue('A'.$rows, $no++);
                    $activeWorksheet->setCellValue('B'.$rows, $rekap['nip']);
                    $activeWorksheet->setCellValue('C'.$rows, $rekap['nama']);
                    $activeWorksheet->setCellValue('D'.$rows, $rekap['tanggal_masuk']);
                    $activeWorksheet->setCellValue('E'.$rows, $rekap['jam_masuk']);
                    $activeWorksheet->setCellValue('F'.$rows, $rekap['latitude_masuk'] . ', ' . $rekap['longitude_masuk']);
                    // Tambahkan gambar untuk foto masuk
                    if (!empty($rekap['foto_masuk'])) {
                        $fotoPath = FCPATH . 'uploads/' . $rekap['foto_masuk'];
                        if (file_exists($fotoPath)) {
                            $drawing = new Drawing();
                            $drawing->setName('Foto Masuk ' . $no);
                            $drawing->setDescription('Foto Masuk');
                            $drawing->setPath($fotoPath);
                            $drawing->setCoordinates('G'.$rows); 
                            $drawing->setWidth(60);
                            $drawing->setHeight(60);
                            $drawing->setWorksheet($activeWorksheet);
                            
                            // Sesuaikan tinggi baris untuk menampung gambar
                            $activeWorksheet->getRowDimension($rows)->setRowHeight(60);
                        } else {
                            $activeWorksheet->setCellValue('G'.$rows, 'Foto tidak ditemukan');
                        }
                    }
                    // $activeWorksheet->setCellValue('G'.$rows, $rekap['foto_masuk']);
                    $activeWorksheet->setCellValue('H'.$rows, $rekap['tanggal_keluar']);
                    $activeWorksheet->setCellValue('I'.$rows, $rekap['jam_keluar']);
                    $activeWorksheet->setCellValue('J'.$rows, $rekap['latitude_keluar'] . ', ' . $rekap['longitude_keluar']);
                    // Tambahkan gambar untuk foto keluar
                    if (!empty($rekap['foto_keluar'])) {
                        $fotoPath = FCPATH . 'uploads/' . $rekap['foto_keluar'];
                        if (file_exists($fotoPath)) {
                            $drawing = new Drawing();
                            $drawing->setName('Foto Keluar ' . $no);
                            $drawing->setDescription('Foto Keluar');
                            $drawing->setPath($fotoPath);
                            $drawing->setCoordinates('K'.$rows); 
                            $drawing->setWidth(60);
                            $drawing->setHeight(60);
                            $drawing->setOffsetX(5);
                            $drawing->setWorksheet($activeWorksheet);
                        } else {
                            $activeWorksheet->setCellValue('K'.$rows, 'Foto tidak ditemukan');
                        }
                    }
                    // $activeWorksheet->setCellValue('K'.$rows, $rekap['foto_keluar']);
                    $activeWorksheet->setCellValue('L'.$rows, $jam.' Jam '. $menit.' Menit');
                    $activeWorksheet->setCellValue('M'.$rows, $jam_terlambat.' Jam '. $menit_terlambat.' Menit');
                    $rows++;
                }

                // redirect output to client browser
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="rekap_presensi_mingguan.xlsx"');
                header('Cache-Control: max-age=0');

                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
                // dd(1234);
            }else {
                $rekap_mingguan = $presensiModel->rekap_mingguan_filter($filter_mingguan);
            }
        } else {
            $rekap_mingguan = $presensiModel->rekap_mingguan();
        }

        $data = [
            'title' => 'Rekap Mingguan',
            'rekap_mingguan' => $rekap_mingguan
        ];

        return view('admin/rekap_presensi/rekap_mingguan', $data);
    }

    public function rekap_bulanan()
    {
        // $presensiModel = new PresensiModel();
        // $filter_bulan = $this->request->getVar('filter_bulan');
        // $filter_tahun = $this->request->getVar('filter_tahun');
        // if ($filter_bulan || $filter_tahun){
        //     $rekap_bulanan = $presensiModel->rekap_bulanan_filter($filter_bulan , $filter_tahun);
        // }else{
        //     $rekap_bulanan = $presensiModel->rekap_bulanan();
        // }
        // $data = [
        //     'title' => 'Rekap Bulanan',
        //     'bulan' => $filter_bulan,
        //     'tahun' => $filter_tahun,
        //     'rekap_bulanan' => $rekap_bulanan
        // ];
        
        $presensiModel = new PresensiModel();
        $filter_bulan = $this->request->getVar('filter_bulan');
        
        if ($filter_bulan) {
            if (isset($_GET['export_excel_bulanan'])){
            // Jika ada filter bulan, ambil data rekap bulanan berdasarkan filter
            $rekap_bulanan = $presensiModel->rekap_bulanan_filter($filter_bulan);
            $spreadsheet = new Spreadsheet();
            $activeWorksheet = $spreadsheet->getActiveSheet();
            // $activeWorksheet->setCellValue('A1', 'Hello World !');

            $spreadsheet->getActiveSheet()->mergeCells('A1:C1');
            $spreadsheet->getActiveSheet()->mergeCells('A3:B3');
            $spreadsheet->getActiveSheet()->mergeCells('A3:E3');

            $activeWorksheet->setCellValue('A1', 'REKAP PRESENSI MINGGUAN');
            $activeWorksheet->setCellValue('A3', 'MINGGU KE');
            $activeWorksheet->setCellValue('C3', $filter_bulan);
            $activeWorksheet->setCellValue('A4', 'NO');
            $activeWorksheet->setCellValue('B4', 'ID');
            $activeWorksheet->setCellValue('C4', 'NAMA PEGAWAI');
            $activeWorksheet->setCellValue('D4', 'TANGGAL MASUK');
            $activeWorksheet->setCellValue('E4', 'JAM MASUK');
            $activeWorksheet->setCellValue('F4', 'KOORDINAT MASUK');
            $activeWorksheet->setCellValue('G4', 'FOTO MASUK');
            $activeWorksheet->setCellValue('H4', 'TANGGAL KELUAR');
            $activeWorksheet->setCellValue('I4', 'JAM KELUAR');
            $activeWorksheet->setCellValue('J4', 'KOORDINAT KELUAR');
            $activeWorksheet->setCellValue('K4', 'FOTO KELUAR');
            $activeWorksheet->setCellValue('L4', 'TOTAL JAM KERJA');
            $activeWorksheet->setCellValue('M4', 'TOTAL TERLAMBAT');
            

            $rows = 5;
            $no = 1;
            foreach ($rekap_bulanan as $rekap) {
                //Menghitung Total Jam Kerja
                $timestamp_jam_masuk = strtotime($rekap['tanggal_masuk']. $rekap['jam_masuk']);
                $timestamp_jam_keluar = strtotime($rekap['tanggal_keluar']. $rekap['jam_keluar']);

                $selisih = $timestamp_jam_keluar - $timestamp_jam_masuk;
                $jam = floor($selisih / 3600);
                $selisih -= $jam * 3600;
                $menit = floor($selisih / 60);

                // Menghitug Total Keterlambatan
                $jam_masuk_real = strtotime($rekap['jam_masuk']);
                $jam_masuk_kantor = strtotime($rekap['jam_masuk_office']);
                $selisih_keterlambatan = $jam_masuk_real - $jam_masuk_kantor;
                $jam_terlambat = floor($selisih_keterlambatan / 3600);
                $selisih_keterlambatan -= $jam_terlambat * 3600;
                $menit_terlambat = floor($selisih_keterlambatan / 60);

                // Menulis data ke spreadsheet
                $activeWorksheet->setCellValue('A'.$rows, $no++);
                $activeWorksheet->setCellValue('B'.$rows, $rekap['nip']);
                $activeWorksheet->setCellValue('C'.$rows, $rekap['nama']);
                $activeWorksheet->setCellValue('D'.$rows, $rekap['tanggal_masuk']);
                $activeWorksheet->setCellValue('E'.$rows, $rekap['jam_masuk']);
                $activeWorksheet->setCellValue('F'.$rows, $rekap['latitude_masuk'] . ', ' . $rekap['longitude_masuk']);
                // Tambahkan gambar untuk foto masuk
                if (!empty($rekap['foto_masuk'])) {
                    // $fotoPath = base_url('uploads/' . $rekap['foto_keluar']);
                    $fotoPath = FCPATH . 'uploads/' . $rekap['foto_masuk'];
                    if (file_exists($fotoPath)) {
                        $drawing = new Drawing();
                        $drawing->setName('Foto Masuk ' . $no);
                        $drawing->setDescription('Foto Masuk');
                        $drawing->setPath($fotoPath);
                        $drawing->setCoordinates('G'.$rows); 
                        $drawing->setWidth(60);
                        $drawing->setHeight(60);
                        $drawing->setWorksheet($activeWorksheet);
                        
                        // Sesuaikan tinggi baris untuk menampung gambar
                        $activeWorksheet->getRowDimension($rows)->setRowHeight(60);
                    } else {
                        $activeWorksheet->setCellValue('G'.$rows, 'Foto tidak ditemukan');
                    }
                }
                // $activeWorksheet->setCellValue('G'.$rows, $rekap['foto_masuk']);
                $activeWorksheet->setCellValue('H'.$rows, $rekap['tanggal_keluar']);
                $activeWorksheet->setCellValue('I'.$rows, $rekap['jam_keluar']);
                $activeWorksheet->setCellValue('J'.$rows, $rekap['latitude_keluar'] . ', ' . $rekap['longitude_keluar']);
                // Tambahkan gambar untuk foto keluar
                if (!empty($rekap['foto_keluar'])) {
                    // $fotoPath = base_url('uploads/' . $rekap['foto_keluar']);
                    $fotoPath = FCPATH . 'uploads/' . $rekap['foto_keluar'];
                    if (file_exists($fotoPath)) {
                        $drawing = new Drawing();
                        $drawing->setName('Foto Keluar ' . $no);
                        $drawing->setDescription('Foto Keluar');
                        $drawing->setPath($fotoPath);
                        $drawing->setCoordinates('K'.$rows); 
                        $drawing->setWidth(60);
                        $drawing->setHeight(60);
                        $drawing->setOffsetX(5);
                        $drawing->setWorksheet($activeWorksheet);
                    } else {
                        $activeWorksheet->setCellValue('K'.$rows, 'Foto tidak ditemukan');
                    }
                }
                // $activeWorksheet->setCellValue('K'.$rows, $rekap['foto_keluar']);
                $activeWorksheet->setCellValue('L'.$rows, $jam.' Jam '. $menit.' Menit');
                $activeWorksheet->setCellValue('M'.$rows, $jam_terlambat.' Jam '. $menit_terlambat.' Menit');
                $rows++;
            }

            // redirect output to client browser
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="rekap_presensi_bulanan.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            // dd(1234);
            }else {
                $rekap_bulanan = $presensiModel->rekap_bulanan_filter($filter_bulan);
            }
        } else {
            $rekap_bulanan = $presensiModel->rekap_bulanan();
        }
        
        $data = [
            'title' => 'Rekap Bulanan',
            'rekap_bulanan' => $rekap_bulanan
        ];
        return view('admin/rekap_presensi/rekap_bulanan', $data);
    }
}
