<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
  private function cekAdmin()
  {
    if (!session('id_user') || session('role') != 'admin') {
      return false;
    }
    return true;
  }
  public function index()
  {
    if (!$this->cekAdmin()) {
      return redirect('/');
    }

    $totalSiswa    = DB::table('siswa')->count();
    $totalPembina  = DB::table('pembina')->count();
    $totalEskul    = DB::table('ekstrakurikuler')->count();
    $totalDaftar   = DB::table('pendaftaran')->count();

    return view('admin.index', compact(
      'totalSiswa',
      'totalPembina',
      'totalEskul',
      'totalDaftar'
    ));
  }

  public function pembina()
  {
    if (!$this->cekAdmin()) {
      return redirect('/');
    }

    $pembina = DB::table('pembina')
      ->join('user', 'pembina.id_user', '=', 'user.id_user')
      ->select('pembina.*', 'user.username')
      ->get();

    return view('admin.pembina', compact('pembina'));
  }

  public function tambahPembina(Request $request)
  {
    if (!$this->cekAdmin()) {
      return redirect('/');
    }

    $nama     = trim($request->nama_pembina);
    $hp       = trim($request->nomor_handphone);
    $email    = trim($request->email);
    $username = trim($request->username);
    $password = trim($request->password);

    if (empty($nama) || empty($hp) || empty($username) || empty($password)) {
      return response()->json(['success' => false, 'message' => 'Semua field harus diisi!']);
    }

    if (!preg_match('/^[a-zA-Z\s]+$/', $nama)) {
      return response()->json(['success' => false, 'message' => 'Nama hanya boleh berisi huruf!']);
    }

    if (!preg_match('/^[0-9]+$/', $hp)) {
      return response()->json(['success' => false, 'message' => 'Nomor HP hanya boleh berisi angka!']);
    }

    $cek = DB::table('user')->where('username', $username)->first();
    if ($cek) {
      return response()->json(['success' => false, 'message' => 'Username sudah digunakan!']);
    }

    $id_user = DB::table('user')->insertGetId([
      'username' => $username,
      'password' => md5($password),
      'id_level' => 1
    ]);

    $id_user = DB::table('user')->insertGetId([
      'username' => $username,
      'password' => md5($password),
      'id_level' => 2
    ]);

    DB::table('pembina')->insert([
      'nama_pembina'    => $nama,
      'nomor_handphone' => $hp,
      'email'           => $email,
      'id_user'         => $id_user
    ]);

    return response()->json(['success' => true, 'message' => 'Pembina berhasil ditambahkan!']);
  }

  public function editPembina(Request $request, $id)
  {
    if (!$this->cekAdmin()) {
      return redirect('/');
    }

    DB::table('pembina')->where('id_pembina', $id)->update([
      'nama_pembina'    => $request->nama_pembina,
      'nomor_handphone' => $request->nomor_handphone,
      'email'           => $request->email,
    ]);

    return response()->json(['success' => true, 'message' => 'Data pembina berhasil diperbarui!']);
  }

  public function hapusPembina($id)
  {
    if (!$this->cekAdmin()) {
      return redirect('/');
    }

    $pembina = DB::table('pembina')->where('id_pembina', $id)->first();

    DB::table('pembina')->where('id_pembina', $id)->delete();

    DB::table('user')->where('id_user', $pembina->id_user)->delete();

    return response()->json(['success' => true, 'message' => 'Pembina berhasil dihapus!']);
  }

  public function siswa()
  {
    if (!$this->cekAdmin()) {
      return redirect('/');
    }

    $siswa = DB::table('siswa')
      ->join('user', 'siswa.id_user', '=', 'user.id_user')
      ->select('siswa.*', 'user.username')
      ->get();

    return view('admin.siswa', compact('siswa'));
  }

  public function tambahSiswa(Request $request)
  {
    if (!$this->cekAdmin()) {
      return redirect('/');
    }

    $nama     = trim($request->nama_lengkap);
    $kelas    = trim($request->kelas_jurusan);
    $hp       = trim($request->nomor_handphone);
    $username = trim($request->username);
    $password = trim($request->password);

    if (empty($nama) || empty($kelas) || empty($hp) || empty($username) || empty($password)) {
      return response()->json(['success' => false, 'message' => 'Semua field harus diisi!']);
    }

    if (!preg_match('/^[a-zA-Z\s]+$/', $nama)) {
      return response()->json(['success' => false, 'message' => 'Nama hanya boleh berisi huruf!']);
    }

    if (!preg_match('/^[0-9]+$/', $hp)) {
      return response()->json(['success' => false, 'message' => 'Nomor HP hanya boleh berisi angka!']);
    }

    $cek = DB::table('user')->where('username', $username)->first();
    if ($cek) {
      return response()->json(['success' => false, 'message' => 'Username sudah digunakan!']);
    }

    $id_user = DB::table('user')->insertGetId([
      'username' => $username,
      'password' => md5($password),
      'id_level' => 1
    ]);

    DB::table('siswa')->insert([
      'nama_lengkap'    => $nama,
      'kelas_jurusan'   => $kelas,
      'nomor_handphone' => $hp,
      'id_user'         => $id_user
    ]);

    return response()->json(['success' => true, 'message' => 'Siswa berhasil ditambahkan!']);
  }

  public function editSiswa(Request $request, $id)
  {
    if (!$this->cekAdmin()) {
      return redirect('/');
    }

    DB::table('siswa')->where('id_siswa', $id)->update([
      'nama_lengkap'    => $request->nama_lengkap,
      'kelas_jurusan'   => $request->kelas_jurusan,
      'nomor_handphone' => $request->nomor_handphone,
    ]);

    return response()->json(['success' => true, 'message' => 'Data siswa berhasil diperbarui!']);
  }

  public function hapusSiswa($id)
  {
    if (!$this->cekAdmin()) {
      return redirect('/');
    }

    $siswa = DB::table('siswa')->where('id_siswa', $id)->first();
    DB::table('pendaftaran')->where('id_siswa', $id)->delete();
    DB::table('siswa')->where('id_siswa', $id)->delete();
    DB::table('user')->where('id_user', $siswa->id_user)->delete();

    return response()->json(['success' => true, 'message' => 'Siswa berhasil dihapus!']);
  }
}
