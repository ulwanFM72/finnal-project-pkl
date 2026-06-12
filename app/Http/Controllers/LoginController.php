<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $username = trim($request->username);
        $password = md5(trim($request->password));

        if (empty(trim($request->username)) || empty(trim($request->password))) {
            return response()->json(['success' => false, 'message' => 'Username dan password harus diisi!']);
        }

        $user = DB::table('user')
            ->where('username', $username)
            ->where('password', $password)
            ->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Username atau password salah!']);
        }

        if ($user->id_level == 3) {
            session(['id_user' => $user->id_user]);
            session(['role'    => 'admin']);
            return response()->json(['success' => true, 'message' => 'Login berhasil!', 'redirect' => '/admin']);
        } elseif ($user->id_level == 2) {
            $pembina = DB::table('pembina')
                ->where('id_user', $user->id_user)
                ->first();

            if (!$pembina) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil!',
                    'redirect' => '/pendaftar'
                ]);
            }

            session(['id_user' => $user->id_user]);
            session(['id_pembina' => $pembina->id_pembina]);
            session(['nama_pembina' => $pembina->nama_pembina]);
            session(['role' => 'pembina']);

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil!',
                'redirect' => '/pendaftar'
            ]);
        } elseif ($user->id_level == 1) {
            $siswa = DB::table('siswa')
                ->where('id_user', $user->id_user)
                ->first();

            if (!$siswa) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil!',
                    'redirect' => '/dashboard'
                ]);
            }

            session(['id_user' => $user->id_user]);
            session(['id_siswa' => $siswa->id_siswa]);
            session(['role' => 'siswa']);

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil!',
                'redirect' => '/dashboard'
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Role tidak dikenali!']);
    }

    public function logout()
    {
        session()->flush();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }

    public function pendaftar(Request $request)
    {
        if (!session('id_user') || !session('id_pembina')) {
            return redirect('/');
        }

        $id_pembina = session('id_pembina');

        $eskul_pembina = DB::table('ekstrakurikuler')
            ->where('id_pembina', $id_pembina)
            ->first();

        if (!$eskul_pembina) {
            return view('pendaftar', ['grouped' => [], 'nama_eskul' => 'Tidak Ada']);
        }

        $pendaftar = DB::select("
        SELECT 
            s.id_siswa,
            s.nama_lengkap, 
            s.kelas_jurusan, 
            s.nomor_handphone,
            e.nama_ekskul,
            pd.tanggal_daftar
        FROM pendaftaran pd
        INNER JOIN siswa s ON pd.id_siswa = s.id_siswa
        INNER JOIN ekstrakurikuler e ON pd.id_ekskul = e.id_ekskul
        WHERE pd.id_ekskul = ?
        ORDER BY s.nama_lengkap
    ", [$eskul_pembina->id_ekskul]);

        $grouped = [];
        foreach ($pendaftar as $p) {
            $grouped[$p->id_siswa]['info']    = $p;
            $grouped[$p->id_siswa]['eskul'][] = $p;
        }

        $nama_eskul = $eskul_pembina->nama_ekskul;

        return view('pendaftar', compact('grouped', 'nama_eskul'));
    }

    public function daftarAkun(Request $request)
    {
        $nama     = trim($request->nama_lengkap);
        $kelas    = trim($request->kelas_jurusan);
        $hp       = trim($request->nomor_handphone);
        $username = trim($request->username);
        $password = trim($request->password);

        if (empty($nama) || empty($kelas) || empty($hp) || empty($username) || empty($password)) {
            return response()->json(['success' => false, 'message' => 'Semua kolom harus diisi!']);
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

        DB::table('siswa')->insert([
            'nama_lengkap'    => $nama,
            'kelas_jurusan'   => $kelas,
            'nomor_handphone' => $hp,
            'id_user'         => $id_user
        ]);

        return response()->json(['success' => true, 'message' => 'Akun berhasil dibuat, silakan login!']);
    }

    public function editSiswa(Request $request, $id)
    {
        if (!session('id_user') || session('role') != 'pembina') {
            return response()->json(['success' => false, 'message' => 'Akses ditolak!']);
        }

        DB::table('siswa')->where('id_siswa', $id)->update([
            'nama_lengkap'    => $request->nama_lengkap,
            'kelas_jurusan'   => $request->kelas_jurusan,
            'nomor_handphone' => $request->nomor_handphone,
        ]);

        return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui']);
    }

    public function hapusSiswa($id)
    {
        if (!session('id_user') || session('role') != 'pembina') {
            return response()->json(['success' => false, 'message' => 'Akses ditolak!']);
        }

        $siswa = DB::table('siswa')->where('id_siswa', $id)->first();

        if (!$siswa) {
            return response()->json(['success' => false, 'message' => 'Data siswa tidak ditemukan!']);
        }

        DB::table('pendaftaran')->where('id_siswa', $id)->delete();
        DB::table('siswa')->where('id_siswa', $id)->delete();
        DB::table('user')->where('id_user', $siswa->id_user)->delete();

        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
    }
}
