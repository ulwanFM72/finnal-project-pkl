<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EskulController;
use App\Http\Controllers\AdminController;

Route::get('/', [LoginController::class, 'index']);

Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/dashboard', [EskulController::class, 'index']);

Route::post('/daftar-eskul', [EskulController::class, 'daftar']);
Route::get('/pendaftar', [LoginController::class, 'pendaftar']);

Route::get('/daftar-akun', function () {
  return view('daftarakun');
});

Route::post('/daftar-akun', [LoginController::class, 'daftarAkun']);
Route::post('/edit-siswa/{id}', [LoginController::class, 'editSiswa']);
Route::post('/hapus-siswa/{id}', [LoginController::class, 'hapusSiswa']);

Route::middleware('cek.admin')->group(function () {
  Route::get('/admin', [AdminController::class, 'index']);

  Route::get('/admin/pembina', [AdminController::class, 'pembina']);
  Route::post('/admin/tambah-pembina', [AdminController::class, 'tambahPembina']);
  Route::post('/admin/edit-pembina/{id}', [AdminController::class, 'editPembina']);
  Route::post('/admin/hapus-pembina/{id}', [AdminController::class, 'hapusPembina']);

  Route::get('/admin/siswa', [AdminController::class, 'siswa']);
  Route::post('/admin/tambah-siswa', [AdminController::class, 'tambahSiswa']);
  Route::post('/admin/edit-siswa-admin/{id}', [AdminController::class, 'editSiswa']);
  Route::post('/admin/hapus-siswa-admin/{id}', [AdminController::class, 'hapusSiswa']);

  Route::get('/admin/eskul', [AdminController::class, 'eskul']);
  Route::post('/admin/tambah-eskul', [AdminController::class, 'tambahEskul']);
  Route::post('/admin/edit-eskul/{id}', [AdminController::class, 'editEskul']);
  Route::post('/admin/hapus-eskul/{id}', [AdminController::class, 'hapusEskul']);

  Route::get('/admin/pendaftaran', [AdminController::class, 'pendaftaran']);
  Route::post('/admin/hapus-pendaftaran/{id}', [AdminController::class, 'hapusPendaftaran']);

  Route::get('/admin/anggota', [AdminController::class, 'anggota']);
  Route::post('/admin/hapus-anggota/{id_siswa}/{id_ekskul}', [AdminController::class, 'hapusAnggota'])->where(['id_siswa' => '[0-9]+', 'id_ekskul' => '[0-9]+']);
  Route::post('/admin/edit-anggota/{id}', [AdminController::class, 'editAnggota']);
});
