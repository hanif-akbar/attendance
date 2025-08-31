<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->post('login', 'Login::login_action');
$routes->get('logout', 'Login::logout');

$routes->get('admin/dashboard', 'Admin\Home::index', ['filter' => 'adminfilter']);
$routes->get('admin/jabatan', 'Admin\Jabatan::index', ['filter' => 'adminfilter']);
$routes->get('admin/jabatan/create', 'Admin\Jabatan::create', ['filter' => 'adminfilter']);
$routes->post('admin/jabatan/store', 'Admin\Jabatan::store', ['filter' => 'adminfilter']);
$routes->get('admin/jabatan/edit/(:segment)', 'Admin\Jabatan::edit/$1', ['filter' => 'adminfilter']);
$routes->post('admin/jabatan/update/(:segment)', 'Admin\Jabatan::update/$1', ['filter' => 'adminfilter']);
$routes->get('admin/jabatan/delete/(:segment)', 'Admin\Jabatan::delete/$1', ['filter' => 'adminfilter']);

$routes->get('admin/divisi', 'Admin\Divisi::index', ['filter' => 'adminfilter']);
$routes->get('admin/divisi/create', 'Admin\Divisi::create', ['filter' => 'adminfilter']);
$routes->post('admin/divisi/store', 'Admin\Divisi::store', ['filter' => 'adminfilter']);
$routes->get('admin/divisi/edit/(:segment)', 'Admin\Divisi::edit/$1', ['filter' => 'adminfilter']);
$routes->post('admin/divisi/update/(:segment)', 'Admin\Divisi::update/$1', ['filter' => 'adminfilter']);
$routes->get('admin/divisi/delete/(:segment)', 'Admin\Divisi::delete/$1', ['filter' => 'adminfilter']);

$routes->get('admin/data_pegawai', 'Admin\DataPegawai::index', ['filter' => 'adminfilter']);
$routes->get('admin/data_pegawai/create', 'Admin\DataPegawai::create', ['filter' => 'adminfilter']);
$routes->post('admin/data_pegawai/store', 'Admin\DataPegawai::store', ['filter' => 'adminfilter']);
$routes->get('admin/data_pegawai/edit/(:segment)', 'Admin\DataPegawai::edit/$1', ['filter' => 'adminfilter']);
$routes->post('admin/data_pegawai/update/(:segment)', 'Admin\DataPegawai::update/$1', ['filter' => 'adminfilter']);
$routes->get('admin/data_pegawai/detail/(:segment)', 'Admin\DataPegawai::detail/$1', ['filter' => 'adminfilter']);
$routes->get('admin/data_pegawai/delete/(:segment)', 'Admin\DataPegawai::delete/$1', ['filter' => 'adminfilter']);

$routes->get('admin/rekap_harian', 'Admin\RekapPresensi::rekap_harian', ['filter' => 'adminfilter']);
$routes->get('admin/rekap_mingguan', 'Admin\RekapPresensi::rekap_mingguan', ['filter' => 'adminfilter']);
$routes->get('admin/rekap_bulanan', 'Admin\RekapPresensi::rekap_bulanan', ['filter' => 'adminfilter']);

$routes->get('admin/ketidakhadiran', 'Admin\Ketidakhadiran::index', ['filter' => 'adminfilter']);
$routes->get('admin/approved_ketidakhadiran/(:segment)', 'Admin\Ketidakhadiran::approved/$1', ['filter' => 'adminfilter']);
$routes->get('admin/rejected_ketidakhadiran/(:segment)', 'Admin\Ketidakhadiran::rejected/$1', ['filter' => 'adminfilter']);

// Routes untuk Verifikasi Ketidakhadiran
$routes->get('admin/verifikasi-ketidakhadiran', 'Admin\VerifikasiKetidakhadiran::index', ['filter' => 'adminfilter']);
$routes->get('admin/verifikasi-ketidakhadiran/detail/(:segment)', 'Admin\VerifikasiKetidakhadiran::detail/$1', ['filter' => 'adminfilter']);
$routes->post('admin/verifikasi-ketidakhadiran/verifikasi/(:segment)', 'Admin\VerifikasiKetidakhadiran::verifikasi/$1', ['filter' => 'adminfilter']);

// Routes untuk Kelola Kepala Bagian
$routes->get('admin/kepala-bagian', 'Admin\VerifikasiKetidakhadiran::kepalaBagian', ['filter' => 'adminfilter']);
$routes->post('admin/kepala-bagian/set', 'Admin\VerifikasiKetidakhadiran::setKepalaBagian', ['filter' => 'adminfilter']);
$routes->get('admin/kepala-bagian/remove/(:segment)', 'Admin\VerifikasiKetidakhadiran::removeKepalaBagian/$1', ['filter' => 'adminfilter']);

// Routes untuk Kepala Bagian
$routes->get('kepala-bagian/verifikasi-ketidakhadiran', 'Admin\VerifikasiKetidakhadiran::index', ['filter' => 'kepalabagianfilter']);
$routes->get('kepala-bagian/verifikasi-ketidakhadiran/detail/(:segment)', 'Admin\VerifikasiKetidakhadiran::detail/$1', ['filter' => 'kepalabagianfilter']);
$routes->post('kepala-bagian/verifikasi-ketidakhadiran/verifikasi/(:segment)', 'Admin\VerifikasiKetidakhadiran::verifikasi/$1', ['filter' => 'kepalabagianfilter']);

// Routes untuk Direktur  
$routes->get('direktur/verifikasi-ketidakhadiran', 'Admin\VerifikasiKetidakhadiran::index', ['filter' => 'direkturfilter']);
$routes->get('direktur/verifikasi-ketidakhadiran/detail/(:segment)', 'Admin\VerifikasiKetidakhadiran::detail/$1', ['filter' => 'direkturfilter']);
$routes->post('direktur/verifikasi-ketidakhadiran/verifikasi/(:segment)', 'Admin\VerifikasiKetidakhadiran::verifikasi/$1', ['filter' => 'direkturfilter']);

$routes->get('pegawai/dashboard', 'Pegawai\Home::index',['filter' => 'pegawaifilter']);
$routes->post('pegawai/presensi_masuk', 'Pegawai\Home::presensi_masuk',['filter' => 'pegawaifilter']);
$routes->post('pegawai/presensi_masuk_aksi', 'Pegawai\Home::presensi_masuk_aksi',['filter' => 'pegawaifilter']);
$routes->post('pegawai/presensi_keluar/(:segment)', 'Pegawai\Home::presensi_keluar/$1',['filter' => 'pegawaifilter']);
$routes->post('pegawai/presensi_keluar_aksi/(:segment)', 'Pegawai\Home::presensi_keluar_aksi/$1',['filter' => 'pegawaifilter']);

$routes->get('pegawai/ubah_password', 'Login::ubahPassword', ['filter' => 'pegawaifilter']);
$routes->post('pegawai/ubah_password_auth', 'Login::ubahPasswordAuth', ['filter' => 'pegawaifilter']);

$routes->get('pegawai/ubah_username', 'Login::ubahUsername', ['filter' => 'pegawaifilter']);
$routes->post('pegawai/ubah_username_auth', 'Login::ubahUsernameAuth', ['filter' => 'pegawaifilter']);

$routes->get('pegawai/rekap_presensi', 'Pegawai\RekapPresensi::index', ['filter' => 'pegawaifilter']);

// untuk keperluan rekap ketidakhadiran
$routes->get('pegawai/ketidakhadiran', 'Pegawai\Ketidakhadiran::index', ['filter' => 'pegawaifilter']);
$routes->get('pegawai/ketidakhadiran/create', 'Pegawai\Ketidakhadiran::create', ['filter' => 'pegawaifilter']);
$routes->post('pegawai/ketidakhadiran/store', 'Pegawai\Ketidakhadiran::store', ['filter' => 'pegawaifilter']);
$routes->get('pegawai/ketidakhadiran/edit/(:segment)', 'Pegawai\Ketidakhadiran::edit/$1', ['filter' => 'pegawaifilter']);
$routes->post('pegawai/ketidakhadiran/update/(:segment)', 'Pegawai\Ketidakhadiran::update/$1', ['filter' => 'pegawaifilter']);
$routes->get('pegawai/ketidakhadiran/delete/(:segment)', 'Pegawai\Ketidakhadiran::delete/$1', ['filter' => 'pegawaifilter']);