<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EskulController extends Controller
{
    public function index()
    {
        if (!session('id_user')) {
            return redirect('/');
        }

        if (!session('id_siswa')) {
            return redirect('/');
        }

        $ekstrakurikuler = DB::select('
           SELECT ek.id_ekskul, ek.nama_ekskul, ek.foto, ek.foto_kegiatan, ek.jadwal, ek.deskripsi,
           p.nama_pembina
           FROM ekstrakurikuler ek
           INNER JOIN pembina p ON ek.id_pembina = p.id_pembina
           ');

        return view('dashboard', compact('ekstrakurikuler'));
    }

    public function daftar(Request $request)
    {
        $id_siswa = session('id_siswa');

        if (!$id_siswa) {
            return response()->json(['success' => false, 'message' => 'Belum login, silakan login dulu']);
        }

        $eskulAda = DB::table('ekstrakurikuler')
            ->where('id_ekskul', $request->id_ekskul)
            ->first();

        if (!$eskulAda) {
            return response()->json(['success' => false, 'message' => 'Eskul tidak ditemukan!']);
        }

        $jumlahEskul = DB::table('pendaftaran')
            ->where('id_siswa', $id_siswa)
            ->count();

        if ($jumlahEskul >= 5) {
            return response()->json(['success' => false, 'message' => 'Maksimal pendaftaran adalah 5 eskul!']);
        }

        $sudahDaftar = DB::table('pendaftaran')
            ->where('id_siswa', $id_siswa)
            ->where('id_ekskul', $request->id_ekskul)
            ->first();

        if ($sudahDaftar) {
            return response()->json(['success' => false, 'message' => 'Sudah terdaftar di eskul ini!']);
        }

        DB::table('pendaftaran')->insert([
            'id_siswa'       => $id_siswa,
            'id_ekskul'      => $request->id_ekskul,
            'tanggal_daftar' => now()->toDateString()
        ]);

        return response()->json(['success' => true, 'message' => 'Pendaftaran berhasil!']);
    }
}
