<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::Home');
$routes->get('login', 'Admin::login');
$routes->get('autentikasi', 'Admin::autentikasi');
$routes->post('autentikasi', 'Admin::autentikasi');
$routes->get('dashboard', 'Admin::dashboard');
$routes->get('logout', 'Admin::logout');
$routes->get('daftar-guru', 'Admin::daftar_guru');
$routes->post('simpan-data-guru', 'Admin::simpan_data_guru');
$routes->post('update-data-guru/(:any)', 'Admin::update_data_guru/$1');
$routes->get('hapus-data-guru/(:any)', 'Admin::hapus_data_guru/$1');
$routes->get('daftar-ujian', 'Admin::daftar_ujian');
$routes->get('daftar-ujian/(:any)', 'Admin::daftar_ujian/$1');

$routes->post('simpan-data-ujian', 'Admin::simpan_data_ujian');

$routes->post('update-data-ujian/(:any)', 'Admin::update_data_ujian/$1');

$routes->get('hapus-data-ujian/(:any)', 'Admin::hapus_data_ujian/$1');

$routes->get('tambah-data-soal/(:any)', 'Admin::tambah_data_soal/$1');

$routes->post('simpan-data-soal', 'Admin::simpan_data_soal');

$routes->post('update-data-soal/(:num)', 'Admin::update_data_soal/$1');

$routes->get('hapus-data-soal/(:num)', 'Admin::hapus_data_soal/$1');

$routes->get('ragam-ujian/mulai/(:any)', 'Home::mulai_ujian/$1');

$routes->post('ragam-ujian/simpan-jawaban', 'Home::simpan_jawaban');

$routes->get('ragam-ujian/konfirmasi/(:any)', 'Home::konfirmasi_peserta/$1');
$routes->post('ragam-ujian/validasi-peserta', 'Home::validasi_peserta');
$routes->post('ragam-ujian/ruang', 'Home::ruang_ujian');
$routes->get('ragam-ujian/hasil/(:any)', 'Home::hasil_ujian/$1');

// Modul Manajemen Kelas
$routes->get('admin/daftar-kelas', 'Admin::daftar_kelas');
$routes->post('admin/simpan-data-kelas', 'Admin::simpan_data_kelas');
$routes->post('admin/update-data-kelas/(:any)', 'Admin::update_data_kelas/$1');
$routes->get('admin/hapus-data-kelas/(:any)', 'Admin::hapus_data_kelas/$1');

// Modul Manajemen Siswa
$routes->get('admin/daftar-siswa', 'Admin::daftar_siswa');
$routes->post('admin/simpan-data-siswa', 'Admin::simpan_data_siswa');
$routes->post('admin/update-data-siswa/(:any)', 'Admin::update_data_siswa/$1');
$routes->get('admin/hapus-data-siswa/(:any)', 'Admin::hapus_data_siswa/$1');
$routes->post('admin/import-siswa', 'Admin::import_siswa');

// Modul Manajemen Hasil
$routes->get('admin/daftar-hasil-ujian', 'Admin::daftar_hasil_ujian');
$routes->get('admin/hapus-data-hasil/(:any)', 'Admin::hapus_data_hasil/$1');

$routes->post('ragam-ujian/validasi', 'Home::validasi_peserta');