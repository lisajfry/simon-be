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
$routes->get('import/dosen', 'Dosen::import');
$routes->options('import/dosen', 'Dosen::options');
$routes->match(['post', 'options'], 'import/dosen', 'Dosen::import');
$routes->match(['post', 'get'], 'dosen/import', 'Dosen::import');
$routes->post('dosen/importExcel', 'Dosen::import');

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





$routes->get('iku3', 'Iku3::index');
$routes->match(['post', 'options'], 'add/iku3', 'Iku3::create');
$routes->match(['put', 'options'], 'update/iku3/(:segment)', 'Iku3::update/$1');
$routes->match(['put', 'options'], 'edit/iku3/(:segment)', 'Iku3::update/$1');
$routes->match(['delete', 'options'], 'delete/iku3/(:segment)', 'Iku3::delete/$1');
$routes->match(['get', 'options'], 'edit/iku3/(:segment)', 'Iku3::edit/$1');
$routes->get('update/iku3/(:segment)', 'Iku3::update/$1');
$routes->get('iku3/(:segment)', 'Iku3::get/$1');




$routes->get('iku7', 'Iku7::index');
$routes->match(['post', 'options'], 'add/iku7', 'Iku7::create');
$routes->match(['put', 'options'], 'update/iku7/(:segment)', 'Iku7::update/$1');
$routes->delete('iku7/(:num)', 'Iku7::delete/$1');