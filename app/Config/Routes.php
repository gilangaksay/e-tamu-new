<?php
use CodeIgniter\Router\RouteCollection;
/** @var RouteCollection $routes */
$routes->get('/', 'Tamu::index');
$routes->post('tamu/submit', 'Tamu::submit');
$routes->get('tamu/konfirmasi/(:num)', 'Tamu::konfirmasi/$1');
$routes->get('admin/login', 'Admin::login');
$routes->post('admin/login', 'Admin::loginProcess');
$routes->get('admin/logout', 'Admin::logout');
$routes->get('admin/dashboard', 'Admin::dashboard');
$routes->get('admin/data-tamu', 'DataTamu::index');
$routes->post('admin/data-tamu/update', 'DataTamu::update');
$routes->post('admin/data-tamu/update-status', 'DataTamu::updateStatus');
$routes->post('admin/data-tamu/delete', 'DataTamu::delete');
$routes->get('admin/laporan', 'Laporan::index');

$routes->get('admin/profile', 'AdminProfile::index');
$routes->post('admin/profile/update', 'AdminProfile::updateSelf');
$routes->post('admin/profile/create', 'AdminProfile::create');
$routes->get('admin/profile/delete/(:num)', 'AdminProfile::delete/$1');

$routes->get('admin/settings', 'Pengaturan::index');
$routes->post('admin/settings/update', 'Pengaturan::update');

$routes->get('admin/export', 'Export::index');
$routes->get('admin/export/print', 'Export::print');

$routes->get('admin/analitik', 'Analitik::index');

$routes->get('admin/pegawai', 'Pegawai::index');
$routes->post('admin/pegawai/store', 'Pegawai::store');
$routes->post('admin/pegawai/update', 'Pegawai::update');
$routes->post('admin/pegawai/delete', 'Pegawai::delete');

$routes->addRedirect('admin', 'admin/login');
