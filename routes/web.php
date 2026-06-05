<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EskulController;

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
