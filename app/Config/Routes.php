<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->post('login', 'Login::login_action');
$routes->get('logout', 'Login::logout');

$routes->group('admin', ['filter' => 'adminfilter'], function($routes) {
    $routes->get('dashboard', 'Admin\Home::index');
    $routes->get('jabatan', 'Admin\Jabatan::index');
    $routes->get('jabatan/create', 'Admin\Jabatan::create');
    $routes->post('jabatan/store', 'Admin\Jabatan::store');
    $routes->get('jabatan/edit/(:segment)', 'Admin\Jabatan::edit/$1');
    $routes->post('jabatan/update/(:segment)', 'Admin\Jabatan::update/$1');
    $routes->get('jabatan/delete/(:segment)', 'Admin\Jabatan::delete/$1');

    $routes->get('divisi', 'Admin\Divisi::index');
    $routes->get('divisi/create', 'Admin\Divisi::create');
    $routes->post('divisi/store', 'Admin\Divisi::store');
    $routes->get('divisi/edit/(:segment)', 'Admin\Divisi::edit/$1');
    $routes->post('divisi/update/(:segment)', 'Admin\Divisi::update/$1');
    $routes->get('divisi/delete/(:segment)', 'Admin\Divisi::delete/$1');

    $routes->get('data_pegawai', 'Admin\DataPegawai::index');
    $routes->get('data_pegawai/create', 'Admin\DataPegawai::create');
    $routes->post('data_pegawai/store', 'Admin\DataPegawai::store');
    $routes->get('data_pegawai/edit/(:segment)', 'Admin\DataPegawai::edit/$1');
    $routes->post('data_pegawai/update/(:segment)', 'Admin\DataPegawai::update/$1');
    $routes->get('data_pegawai/detail/(:segment)', 'Admin\DataPegawai::detail/$1');
    $routes->get('data_pegawai/delete/(:segment)', 'Admin\DataPegawai::delete/$1');

    $routes->get('rekap_harian', 'Admin\RekapPresensi::rekap_harian');
    $routes->get('rekap_mingguan', 'Admin\RekapPresensi::rekap_mingguan');
    $routes->get('rekap_bulanan', 'Admin\RekapPresensi::rekap_bulanan');

    $routes->get('ketidakhadiran', 'Admin\Ketidakhadiran::index');
    $routes->get('approved_ketidakhadiran/(:segment)', 'Admin\Ketidakhadiran::approved/$1');
    $routes->get('rejected_ketidakhadiran/(:segment)', 'Admin\Ketidakhadiran::rejected/$1');

    $routes->get('role_bawahan_ke_atasan', 'Admin\RoleAtasanBawahan::index');
});

$routes->group('pegawai', ['filter' => 'pegawaifilter'], function($routes) {
    $routes->get('dashboard', 'Pegawai\Home::index');
    $routes->post('presensi_masuk', 'Pegawai\Home::presensi_masuk');
    $routes->post('presensi_masuk_aksi', 'Pegawai\Home::presensi_masuk_aksi');
    $routes->post('presensi_keluar/(:segment)', 'Pegawai\Home::presensi_keluar/$1');
    $routes->post('presensi_keluar_aksi/(:segment)', 'Pegawai\Home::presensi_keluar_aksi/$1');

    $routes->get('ubah_password', 'Login::ubahPassword');
    $routes->post('ubah_password_auth', 'Login::ubahPasswordAuth');

    $routes->get('ubah_username', 'Login::ubahUsername');
    $routes->post('ubah_username_auth', 'Login::ubahUsernameAuth');

    $routes->get('rekap_presensi', 'Pegawai\RekapPresensi::index');

    // untuk keperluan rekap ketidakhadiran
    $routes->get('ketidakhadiran', 'Pegawai\Ketidakhadiran::index');
    $routes->get('ketidakhadiran/create', 'Pegawai\Ketidakhadiran::create');
    $routes->post('ketidakhadiran/store', 'Pegawai\Ketidakhadiran::store');
    $routes->get('ketidakhadiran/edit/(:segment)', 'Pegawai\Ketidakhadiran::edit/$1');
    $routes->post('ketidakhadiran/update/(:segment)', 'Pegawai\Ketidakhadiran::update/$1');
    $routes->get('ketidakhadiran/delete/(:segment)', 'Pegawai\Ketidakhadiran::delete/$1');
});

$routes->group('kepala_bagian', ['filter' => 'kepalabagianfilter'], function($routes) {
    $routes->get('dashboard', 'KepalaBagian\Home::index');
    $routes->post('presensi_masuk', 'KepalaBagian\Home::presensi_masuk');
    $routes->post('presensi_masuk_aksi', 'KepalaBagian\Home::presensi_masuk_aksi');
    $routes->post('presensi_keluar/(:segment)', 'KepalaBagian\Home::presensi_keluar/$1');
    $routes->post('presensi_keluar_aksi/(:segment)', 'KepalaBagian\Home::presensi_keluar_aksi/$1');

    $routes->get('ubah_password', 'Login::ubahPasswordKepalaBagian');
    $routes->post('ubah_password_auth', 'Login::ubahPasswordAuthKepalaBagian');

    $routes->get('ubah_username', 'Login::ubahUsernameKepalaBagian');
    $routes->post('ubah_username_auth', 'Login::ubahUsernameAuthKepalaBagian');

    $routes->get('rekap_presensi', 'KepalaBagian\RekapPresensi::index');

    // untuk keperluan rekap ketidakhadiran
    $routes->get('ketidakhadiran', 'KepalaBagian\Ketidakhadiran::index');
    $routes->get('ketidakhadiran/create', 'KepalaBagian\Ketidakhadiran::create');
    $routes->post('ketidakhadiran/store', 'KepalaBagian\Ketidakhadiran::store');
    $routes->get('ketidakhadiran/edit/(:segment)', 'KepalaBagian\Ketidakhadiran::edit/$1');
    $routes->post('ketidakhadiran/update/(:segment)', 'KepalaBagian\Ketidakhadiran::update/$1');
    $routes->get('ketidakhadiran/delete/(:segment)', 'KepalaBagian\Ketidakhadiran::delete/$1');
});

$routes->group('direktur', ['filter' => 'direkturfilter'], function($routes) {
    $routes->get('dashboard', 'Direktur\Home::index');
    $routes->post('presensi_masuk', 'Direktur\Home::presensi_masuk');
    $routes->post('presensi_masuk_aksi', 'Direktur\Home::presensi_masuk_aksi');
    $routes->post('presensi_keluar/(:segment)', 'Direktur\Home::presensi_keluar/$1');
    $routes->post('presensi_keluar_aksi/(:segment)', 'Direktur\Home::presensi_keluar_aksi/$1');

    $routes->get('ubah_password', 'Login::ubahPasswordDirektur');
    $routes->post('ubah_password_auth', 'Login::ubahPasswordAuthDirektur');

    $routes->get('ubah_username', 'Login::ubahUsernameDirektur');
    $routes->post('ubah_username_auth', 'Login::ubahUsernameAuthDirektur');

    $routes->get('rekap_presensi', 'Direktur\RekapPresensi::index');
});