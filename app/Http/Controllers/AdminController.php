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

    $totalSiswa   = DB::table('siswa')->count();
    $totalPembina = DB::table('pembina')->count();
    $totalEskul   = DB::table('ekstrakurikuler')->count();
    $totalDaftar  = DB::table('pendaftaran')->count();

    $pendaftaranTerbaru = DB::select("
        SELECT s.nama_lengkap, s.kelas_jurusan, e.nama_ekskul, pd.tanggal_daftar
        FROM pendaftaran pd
        INNER JOIN siswa s ON pd.id_siswa = s.id_siswa
        INNER JOIN ekstrakurikuler e ON pd.id_ekskul = e.id_ekskul
        ORDER BY pd.tanggal_daftar DESC
        LIMIT 10
    ");

    return view('admin.index', compact(
      'totalSiswa',
      'totalPembina',
      'totalEskul',
      'totalDaftar',
      'pendaftaranTerbaru'
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
      return response()->json(['success' => false, 'message' => 'Session habis!']);
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

    if (strlen($hp) < 10 || strlen($hp) > 13) {
      return response()->json(['success' => false, 'message' => 'Nomor HP harus 10-13 digit!']);
    }

    if (strlen($username) < 4) {
      return response()->json(['success' => false, 'message' => 'Username minimal 4 karakter!']);
    }

    if (strlen($password) < 6) {
      return response()->json(['success' => false, 'message' => 'Password minimal 6 karakter!']);
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
      return response()->json(['success' => false, 'message' => 'Session habis, silakan login ulang!']);
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
      return response()->json(['success' => false, 'message' => 'Session habis!']);
    }

    $pembina = DB::table('pembina')->where('id_pembina', $id)->first();

    if (!$pembina) {
      return response()->json(['success' => false, 'message' => 'Data pembina tidak ditemukan!']);
    }

    DB::table('ekstrakurikuler')
      ->where('id_pembina', $id)
      ->update(['id_pembina' => null]);

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
      return response()->json(['success' => false, 'message' => 'Session habis!']);
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

    if (strlen($hp) < 10 || strlen($hp) > 13) {
      return response()->json(['success' => false, 'message' => 'Nomor HP harus 10-13 digit!']);
    }

    if (strlen($username) < 4) {
      return response()->json(['success' => false, 'message' => 'Username minimal 4 karakter!']);
    }

    if (strlen($password) < 6) {
      return response()->json(['success' => false, 'message' => 'Password minimal 6 karakter!']);
    }

    $cek = DB::table('user')->where('username', $username)->first();
    if ($cek) {
      return response()->json(['success' => false, 'message' => 'Username sudah digunakan!']);
    }

    $id_user = DB::table('user')->insertGetId([
      'username' => $username,
      'password' => md5($password),
      'id_level' => 2
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
      return response()->json(['success' => false, 'message' => 'Session habis, silakan login ulang!']);
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
      return response()->json(['success' => false, 'message' => 'Session habis!']);
    }

    $siswa = DB::table('siswa')->where('id_siswa', $id)->first();

    if (!$siswa) {
      return response()->json(['success' => false, 'message' => 'Data siswa tidak ditemukan!']);
    }

    DB::table('pendaftaran')->where('id_siswa', $id)->delete();
    DB::table('siswa')->where('id_siswa', $id)->delete();
    DB::table('user')->where('id_user', $siswa->id_user)->delete();

    return response()->json(['success' => true, 'message' => 'Siswa berhasil dihapus!']);
  }

  public function eskul()
  {
    if (!$this->cekAdmin()) {
      return redirect('/');
    }

    $eskul = DB::table('ekstrakurikuler as e')
      ->join('pembina as p', 'e.id_pembina', '=', 'p.id_pembina')
      ->select('e.*', 'p.nama_pembina')
      ->get();

    $pembina = DB::table('pembina')->get();

    return view('admin.eskul', compact('eskul', 'pembina'));
  }

  public function tambahEskul(Request $request)
  {
    if (!$this->cekAdmin()) {
      return response()->json(['success' => false, 'message' => 'Session habis, silakan login ulang!']);
    }

    $nama       = trim($request->nama_ekskul);
    $id_pembina = $request->id_pembina;

    if (empty($nama) || empty($id_pembina)) {
      return response()->json(['success' => false, 'message' => 'Semua field harus diisi!']);
    }

    $cek = DB::table('ekstrakurikuler')->where('nama_ekskul', $nama)->first();
    if ($cek) {
      return response()->json(['success' => false, 'message' => 'Nama eskul sudah ada!']);
    }

    DB::table('ekstrakurikuler')->insert([
      'nama_ekskul' => $nama,
      'id_pembina'  => $id_pembina
    ]);

    return response()->json(['success' => true, 'message' => 'Eskul berhasil ditambahkan!']);
  }

  public function editEskul(Request $request, $id)
  {
    if (!$this->cekAdmin()) {
      return response()->json(['success' => false, 'message' => 'Session habis, silakan login ulang!']);
    }

    DB::table('ekstrakurikuler')->where('id_ekskul', $id)->update([
      'nama_ekskul' => $request->nama_ekskul,
      'id_pembina'  => $request->id_pembina
    ]);

    return response()->json(['success' => true, 'message' => 'Eskul berhasil diperbarui!']);
  }

  public function hapusEskul($id)
  {
    if (!$this->cekAdmin()) {
      return response()->json(['success' => false, 'message' => 'Session habis, silakan login ulang!']);
    }

    DB::table('pendaftaran')->where('id_ekskul', $id)->delete();
    DB::table('ekstrakurikuler')->where('id_ekskul', $id)->delete();

    return response()->json(['success' => true, 'message' => 'Eskul berhasil dihapus!']);
  }

  public function pendaftaran()
  {
    if (!$this->cekAdmin()) {
      return redirect('/');
    }

    $pendaftaran = DB::select("
        SELECT 
            s.id_siswa,
            s.nama_lengkap,
            s.kelas_jurusan,
            s.nomor_handphone,
            GROUP_CONCAT(e.nama_ekskul ORDER BY e.nama_ekskul SEPARATOR ', ') as daftar_eskul,
            MIN(pd.tanggal_daftar) as tanggal_daftar
        FROM pendaftaran pd
        INNER JOIN siswa s ON pd.id_siswa = s.id_siswa
        INNER JOIN ekstrakurikuler e ON pd.id_ekskul = e.id_ekskul
        GROUP BY s.id_siswa, s.nama_lengkap, s.kelas_jurusan, s.nomor_handphone
        ORDER BY s.nama_lengkap
    ");

    return view('admin.pendaftaran', compact('pendaftaran'));
  }

  public function hapusPendaftaran($id)
  {
    if (!$this->cekAdmin()) {
      return response()->json(['success' => false, 'message' => 'Session habis!']);
    }

    DB::table('pendaftaran')->where('id_siswa', $id)->delete();

    return response()->json(['success' => true, 'message' => 'Pendaftaran berhasil dihapus!']);
  }

  public function anggota(Request $request)
  {
    if (!$this->cekAdmin()) {
      return redirect('/');
    }

    // Ambil semua eskul untuk tab
    $eskul = DB::table('ekstrakurikuler')
      ->join('pembina', 'ekstrakurikuler.id_pembina', '=', 'pembina.id_pembina')
      ->select('ekstrakurikuler.*', 'pembina.nama_pembina')
      ->orderBy('nama_ekskul')
      ->get();

    // Ambil eskul yang dipilih, default eskul pertama
    $id_ekskul_aktif = $request->get('eskul', $eskul->first()->id_ekskul);

    // Ambil eskul aktif
    $eskul_aktif = DB::table('ekstrakurikuler')
      ->join('pembina', 'ekstrakurikuler.id_pembina', '=', 'pembina.id_pembina')
      ->select('ekstrakurikuler.*', 'pembina.nama_pembina')
      ->where('ekstrakurikuler.id_ekskul', $id_ekskul_aktif)
      ->first();

    // Ambil anggota eskul yang dipilih
    $anggota = DB::select("
        SELECT s.id_siswa, s.nama_lengkap, s.kelas_jurusan, 
               s.nomor_handphone, pd.tanggal_daftar
        FROM pendaftaran pd
        INNER JOIN siswa s ON pd.id_siswa = s.id_siswa
        WHERE pd.id_ekskul = ?
        ORDER BY s.nama_lengkap
    ", [$id_ekskul_aktif]);

    return view('admin.anggota', compact('eskul', 'eskul_aktif', 'anggota', 'id_ekskul_aktif'));
  }

  public function hapusAnggota($id_siswa, $id_ekskul)
  {
    if (!$this->cekAdmin()) {
      return response()->json(['success' => false, 'message' => 'Session habis!']);
    }

    DB::table('pendaftaran')
      ->where('id_siswa', $id_siswa)
      ->where('id_ekskul', $id_ekskul)
      ->delete();

    return response()->json(['success' => true, 'message' => 'Anggota berhasil dihapus!']);
  }

  public function editAnggota(Request $request, $id)
  {
    if (!$this->cekAdmin()) {
      return response()->json(['success' => false, 'message' => 'Session habis!']);
    }

    DB::table('siswa')->where('id_siswa', $id)->update([
      'nama_lengkap'    => $request->nama_lengkap,
      'kelas_jurusan'   => $request->kelas_jurusan,
      'nomor_handphone' => $request->nomor_handphone,
    ]);

    return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui!']);
  }
}
