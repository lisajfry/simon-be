<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


$routes->get('user', 'User::index');
$routes->match(['post', 'options'], 'add/user', 'User::create');
$routes->match(['put', 'options'], 'update/user/(:segment)', 'User::update/$1');
$routes->match(['put', 'options'], 'edit/user/(:segment)', 'User::update/$1');
$routes->match(['delete', 'options'], 'delete/user/(:segment)', 'User::delete/$1');
$routes->match(['get', 'options'], 'edit/user/(:segment)', 'User::edit/$1');
$routes->get('update/user/(:segment)', 'User::update/$1');
$routes->get('user/(:segment)', 'User::get/$1');
$routes->get('import/user', 'User::import');
$routes->options('import/user', 'User::options');
$routes->match(['post', 'options'], 'import/user', 'User::import');
$routes->match(['post', 'get'], 'user/import', 'User::import');
$routes->post('user/importExcel', 'User::import');



$routes->get('years', 'Year::index');
$routes->get('years/(:segment)', 'Year::show/$1');
$routes->match(['post', 'options'], 'add/year', 'Year::create');
$routes->put('years/(:segment)', 'Year::update/$1');
$routes->delete('years/(:segment)', 'Year::delete/$1');




$routes->get('mahasiswa', 'Mahasiswa::index');
$routes->match(['post', 'options'], 'add/mahasiswa', 'Mahasiswa::create');
$routes->match(['put', 'options'], 'update/mahasiswa/(:segment)', 'Mahasiswa::update/$1');
$routes->match(['put', 'options'], 'edit/mahasiswa/(:segment)', 'Mahasiswa::update/$1');
$routes->match(['delete', 'options'], 'delete/mahasiswa/(:segment)', 'Mahasiswa::delete/$1');
$routes->match(['get', 'options'], 'edit/mahasiswa/(:segment)', 'Mahasiswa::edit/$1');
$routes->get('update/mahasiswa/(:segment)', 'Mahasiswa::update/$1');
$routes->get('mahasiswa/(:segment)', 'Mahasiswa::get/$1');
$routes->get('import/mahasiswa', 'Mahasiswa::import');
$routes->options('import/mahasiswa', 'Mahasiswa::options');
$routes->match(['post', 'options'], 'import/mahasiswa', 'Mahasiswa::import');
$routes->match(['post', 'get'], 'mahasiswa/import', 'Mahasiswa::import');
$routes->post('mahasiswa/importExcel', 'Mahasiswa::import');

$routes->get('lulusan', 'Lulusan::index');
$routes->match(['post', 'options'], 'add/lulusan', 'Lulusan::create');
$routes->match(['put', 'options'], 'update/lulusan/(:segment)', 'Lulusan::update/$1');
$routes->match(['put', 'options'], 'edit/lulusan/(:segment)', 'Lulusan::update/$1');
$routes->match(['delete', 'options'], 'delete/lulusan/(:segment)', 'Lulusan::delete/$1');
$routes->match(['get', 'options'], 'edit/lulusan/(:segment)', 'Lulusan::edit/$1');
$routes->get('update/lulusan/(:segment)', 'Lulusan::update/$1');
$routes->get('lulusan/(:segment)', 'Lulusan::get/$1');
$routes->get('import/lulusan', 'Lulusan::import');
$routes->options('import/lulusan', 'Lulusan::options');
$routes->match(['post', 'options'], 'import/lulusan', 'Lulusan::import');
$routes->match(['post', 'get'], 'lulusan/import', 'Lulusan::import');
$routes->post('lulusan/importExcel', 'Lulusan::import');


$routes->get('dosen', 'Dosen::index');
$routes->match(['post', 'options'], 'add/dosen', 'Dosen::create');
$routes->match(['put', 'options'], 'update/dosen/(:segment)', 'Dosen::update/$1');
$routes->match(['put', 'options'], 'edit/dosen/(:segment)', 'Dosen::update/$1');
$routes->match(['delete', 'options'], 'delete/dosen/(:segment)', 'Dosen::delete/$1');
$routes->match(['get', 'options'], 'edit/dosen/(:segment)', 'Dosen::edit/$1');
$routes->get('update/dosen/(:segment)', 'Dosen::update/$1');
$routes->get('dosen/(:segment)', 'Dosen::get/$1');

$routes->get('dosenNIDK', 'DosenNIDK::index');
$routes->match(['post', 'options'], 'add/dosenNIDK', 'DosenNIDK::create');
$routes->match(['put', 'options'], 'update/dosenNIDK/(:segment)', 'DosenNIDK::update/$1');
$routes->match(['put', 'options'], 'edit/d osenNIDK/(:segment)', 'DosenNIDK::update/$1');
$routes->match(['delete', 'options'], 'delete/dosenNIDK/(:segment)', 'DosenNIDK::delete/$1');
$routes->match(['get', 'options'], 'edit/dosenNIDK/(:segment)', 'DosenNIDK::edit/$1');
$routes->get('update/dosenNIK/(:segment)', 'DosenNIDK::update/$1');
$routes->get('dosenNIDK/(:segment)', 'DosenNIDK::get/$1');

$routes->get('iku1', 'Iku1::index');
$routes->match(['post', 'options'], 'add/iku1', 'Iku1::create');
$routes->match(['put', 'options'], 'update/iku1/(:segment)', 'Iku1::update/$1');
$routes->match(['put', 'options'], 'edit/iku1/(:segment)', 'Iku1::update/$1');
$routes->match(['delete', 'options'], 'delete/iku1/(:segment)', 'Iku1::delete/$1');
$routes->match(['get', 'options'], 'edit/iku1/(:segment)', 'Iku1::edit/$1');
$routes->get('update/iku1/(:segment)', 'Iku1::update/$1');
$routes->get('iku1/(:segment)', 'Iku1::get/$1');
$routes->get('import/iku1', 'Iku1::import');
$routes->options('import/iku1', 'Iku1::options');
$routes->match(['post', 'options'], 'import/iku1', 'Iku1::import');
$routes->match(['post', 'get'], 'iku1/import', 'Iku1::import');
$routes->post('iku1/importExcel', 'Iku1::import');
$routes->get('iku1/rekap', 'Iku1::rekap');


$routes->get('iku2kegiatan', 'Iku2kegiatan::index');
$routes->match(['post', 'options'], 'add/iku2kegiatan', 'Iku2kegiatan::create');
$routes->match(['put', 'options'], 'update/iku2kegiatan/(:segment)', 'Iku2kegiatan::update/$1');
$routes->match(['put', 'options'], 'edit/iku2kegiatan/(:segment)', 'Iku2kegiatan::update/$1');
$routes->match(['delete', 'options'], 'delete/iku2kegiatan/(:segment)', 'Iku2kegiatan::delete/$1');
$routes->match(['get', 'options'], 'edit/iku2kegiatan/(:segment)', 'Iku2kegiatan::edit/$1');
$routes->get('update/iku2kegiatan/(:segment)', 'Iku2kegiatan::update/$1');
$routes->post('update/iku2kegiatan/(:segment)', 'Iku2kegiatan::update/$1');
$routes->get('iku2kegiatan/(:segment)', 'Iku2kegiatan::get/$1');


$routes->get('iku2inbound', 'Iku2inbound::index');
$routes->match(['post', 'options'], 'add/iku2inbound', 'Iku2inbound::create');
$routes->match(['put', 'options'], 'update/iku2inbound/(:segment)', 'Iku2inbound::update/$1');
$routes->match(['delete', 'options'], 'delete/iku2inbound/(:segment)', 'Iku2inbound::delete/$1');
$routes->get('iku2inbound/(:segment)', 'Iku2inbound::get/$1');
$routes->get('upload/success', 'Iku2inbound::success');
$routes->get('uploads/(:any)', 'Iku2inbound::download/$1');
$routes->match(['put', 'options'], 'edit/iku2inbound/(:segment)', 'Iku2inbound::edit/$1');
$routes->get('update/iku2inbound/(:segment)', 'Iku2inbound::update/$1');
$routes->post('update/iku2inbound/(:segment)', 'Iku2inbound::update/$1');
$routes->get('iku2inbound/(:segment)', 'Iku2inbound::get/$1');



$routes->get('iku2prestasi', 'Iku2prestasi::index');
$routes->match(['post', 'options'], 'add/iku2prestasi', 'Iku2prestasi::create');
$routes->match(['put', 'options'], 'update/iku2prestasi/(:segment)', 'Iku2prestasi::update/$1');
$routes->match(['put', 'options'], 'edit/iku2prestasi/(:segment)', 'Iku2prestasi::update/$1');
$routes->match(['delete', 'options'], 'delete/iku2prestasi/(:segment)', 'Iku2prestasi::delete/$1');
$routes->match(['get', 'options'], 'edit/iku2prestasi/(:segment)', 'Iku2prestasi::edit/$1');
$routes->get('update/iku2prestasi/(:segment)', 'Iku2prestasi::update/$1');
$routes->post('update/iku2prestasi/(:segment)', 'Iku2prestasi::update/$1');
$routes->get('iku2prestasi/(:segment)', 'Iku2prestasi::get/$1');
$routes->get('upload/success', 'Iku3prestasi::success');
$routes->get('uploads/(:any)', 'Iku3prestasi::download/$1');


$routes->get('iku3tridharma', 'Iku3tridharma::index');
$routes->match(['post', 'options'], 'add/iku3tridharma', 'Iku3tridharma::create');
$routes->match(['put', 'options'], 'update/iku3tridharma/(:segment)', 'Iku3tridharma::update/$1');
$routes->match(['delete', 'options'], 'delete/iku3tridharma/(:segment)', 'Iku3tridharma::delete/$1');
$routes->get('iku3tridharma/(:segment)', 'Iku3tridharma::get/$1');
$routes->get('upload/success', 'Iku3tridharma::success');
$routes->get('uploads/(:any)', 'Iku3tridharma::download/$1');
$routes->match(['put', 'options'], 'edit/iku3tridharma/(:segment)', 'Iku3tridharma::edit/$1');
$routes->get('update/iku3tridharma/(:segment)', 'Iku3tridharma::update/$1');
$routes->post('update/iku3tridharma/(:segment)', 'Iku3tridharma::update/$1');
$routes->get('iku3tridharma/(:segment)', 'Iku3tridharma::get/$1');


$routes->get('iku3praktisi', 'Iku3praktisi::index');
$routes->match(['post', 'options'], 'add/iku3praktisi', 'Iku3praktisi::create');
$routes->match(['put', 'options'], 'update/iku3praktisi/(:segment)', 'Iku3praktisi::update/$1');
$routes->match(['put', 'options'], 'edit/iku3praktisi/(:segment)', 'Iku3praktisi::update/$1');
$routes->match(['delete', 'options'], 'delete/iku3praktisi/(:segment)', 'Iku3praktisi::delete/$1');
$routes->match(['get', 'options'], 'edit/iku3praktisi/(:segment)', 'Iku3praktisi::edit/$1');
$routes->get('update/iku3praktisi/(:segment)', 'Iku3praktisi::update/$1');
$routes->get('iku3praktisi/(:segment)', 'Iku3praktisi::get/$1');
$routes->get('upload/success', 'Iku3praktisi::success');
$routes->get('uploads/(:any)', 'Iku3praktisi::download/$1');
$routes->match(['put', 'options'], 'edit/iku3praktisi/(:segment)', 'Iku3praktisi::edit/$1');
$routes->get('update/iku3praktisi/(:segment)', 'Iku3praktisi::update/$1');
$routes->post('update/iku3praktisi/(:segment)', 'Iku3praktisi::update/$1');
$routes->get('iku3praktisi/(:segment)', 'Iku3praktisi::get/$1');


$routes->get('iku4', 'Iku4::index');
$routes->post('iku4', 'Iku4::create');
$routes->match(['post', 'options'], 'add/iku4', 'Iku4::create');
$routes->match(['put', 'options'], 'update/iku4/(:segment)', 'Iku4::update/$1');
$routes->match(['put', 'options'], 'edit/iku4/(:segment)', 'Iku4::update/$1');
$routes->match(['delete', 'options'], 'delete/iku4/(:segment)', 'Iku4::delete/$1');
$routes->match(['get', 'options'], 'edit/iku4/(:segment)', 'Iku4::edit/$1');
$routes->get('update/iku4/(:segment)', 'Iku4::update/$1');
$routes->get('iku4/(:segment)', 'Iku4::get/$1');
$routes->get('import/iku4', 'Iku4::import');
$routes->options('import/iku4', 'Iku4::options');
$routes->match(['post', 'options'], 'import/iku4', 'Iku4::import');
$routes->match(['post', 'get'], 'iku4/import', 'Iku4::import');
$routes->post('iku1/importExcel', 'Iku4::import');
$routes->get('iku4/rekap', 'Iku4::rekap');


$routes->get('dosenpraktisi', 'Dosenpraktisi::index');
$routes->match(['post', 'options'], 'add/dosenpraktisi', 'Dosenpraktisi::create');
$routes->match(['put', 'options'], 'update/dosenpraktisi/(:segment)', 'Dosenpraktisi::update/$1');
$routes->match(['put', 'options'], 'edit/dosenpraktisi/(:segment)', 'Dosenpraktisi::update/$1');
$routes->match(['delete', 'options'], 'delete/dosenpraktisi/(:segment)', 'Dosenpraktisi::delete/$1');
$routes->match(['get', 'options'], 'edit/dosenpraktisi/(:segment)', 'Dosenpraktisi::edit/$1');
$routes->get('update/dosenpraktisi/(:segment)', 'Dosenpraktisi::update/$1');
$routes->get('dosenpraktisi/(:segment)', 'Dosenpraktisi::get/$1');
$routes->get('import/dosenpraktisi', 'Dosenpraktisi::import');
$routes->options('import/dosenpraktisi', 'Dosenpraktisi::options');
$routes->match(['post', 'options'], 'import/dosenpraktisi', 'Dosenpraktisi::import');
$routes->match(['post', 'get'], 'dosenpraktisi/import', 'Dosenpraktisi::import');
$routes->post('dosenpraktisi/importExcel', 'Dosenpraktisi::import');




$routes->get('iku5', 'IKU5::index');
$routes->post('iku5', 'IKU5::create');
$routes->put('iku5/(:segment)', 'IKU5::update/$1');
$routes->delete('iku5/(:segment)', 'IKU5::delete/$1');
$routes->get('iku5/(:segment)', 'IKU5::show/$1');
$routes->get('upload/success', 'IKU5::success');
$routes->get('uploads/(:any)', 'IKU5::download/$1');


$routes->get('iku6', 'Iku6::index');
$routes->match(['post', 'options'], 'add/iku6', 'Iku6::create');
$routes->match(['put', 'options'], 'update/iku6/(:segment)', 'Iku6::update/$1');
$routes->match(['delete', 'options'], 'delete/iku6/(:segment)', 'Iku6::delete/$1');
$routes->get('iku6/(:segment)', 'Iku6::get/$1');
$routes->get('upload/success', 'Iku6::success');
$routes->get('uploads/(:any)', 'Iku6::download/$1');
$routes->match(['put', 'options'], 'edit/iku6/(:segment)', 'Iku6::edit/$1');
$routes->get('update/iku6/(:segment)', 'Iku6::update/$1');
$routes->get('iku6/(:segment)', 'Iku6::get/$1');




$routes->get('iku7', 'Iku7::index');
$routes->match(['post', 'options'], 'add/iku7', 'Iku7::create');
$routes->match(['put', 'options'], 'update/iku7/(:segment)', 'Iku7::update/$1');
$routes->match(['delete', 'options'], 'delete/iku7/(:segment)', 'Iku7::delete/$1');
$routes->get('iku7/(:segment)', 'Iku7::get/$1');
$routes->get('upload/success', 'Iku7::success');
$routes->get('uploads/(:any)', 'Iku7::download/$1');
$routes->match(['put', 'options'], 'edit/iku7/(:segment)', 'Iku7::edit/$1');
$routes->get('update/iku7/(:segment)', 'Iku7::update/$1');
$routes->get('iku7/(:segment)', 'Iku7::get/$1');



$routes->get('rekap', 'Rekap::index');
$routes->match(['post', 'options'], 'add/rekap', 'Rekap::create');
$routes->match(['put', 'options'], 'update/rekap/(:segment)', 'Rekap::update/$1');
$routes->match(['delete', 'options'], 'delete/rekap/(:segment)', 'Rekap::delete/$1');