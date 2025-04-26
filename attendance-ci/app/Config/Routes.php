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

$routes->get('admin/data_pegawai', 'Admin\DataPegawai::index', ['filter' => 'adminfilter']);
$routes->get('admin/data_pegawai/create', 'Admin\DataPegawai::create', ['filter' => 'adminfilter']);
$routes->post('admin/data_pegawai/store', 'Admin\DataPegawai::store', ['filter' => 'adminfilter']);
$routes->get('admin/data_pegawai/edit/(:segment)', 'Admin\DataPegawai::edit/$1', ['filter' => 'adminfilter']);
$routes->post('admin/data_pegawai/update/(:segment)', 'Admin\DataPegawai::update/$1', ['filter' => 'adminfilter']);
$routes->get('admin/data_pegawai/detail/(:segment)', 'Admin\DataPegawai::detail/$1', ['filter' => 'adminfilter']);
$routes->get('admin/data_pegawai/delete/(:segment)', 'Admin\DataPegawai::delete/$1', ['filter' => 'adminfilter']);

$routes->get('pegawai/dashboard', 'Pegawai\Home::index',['filter' => 'pegawaifilter']);
$routes->post('pegawai/presensi_masuk', 'Pegawai\Home::presensi_masuk',['filter' => 'pegawaifilter']);
