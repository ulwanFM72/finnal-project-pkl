<!DOCTYPE html>
<html>
<head>
    <title>Kelola Siswa</title>
     <link rel="icon" type="image/png" href="{{ asset('images/logo-smkn1cijati.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">
        <h2>⚙️ Dashboard Admin</h2>
        <p>Sistem Ekstrakurikuler</p>
    </div>
    <div class="sidebar-menu">
        <p class="menu-label">MENU</p>
        <a href="/admin"><span class="icon">🏠</span> Ringkasan</a>
        <a href="/admin/siswa" class="active"><span class="icon">👤</span> Siswa</a>
        <a href="/admin/eskul"><span class="icon">🎯</span> Ekstrakurikuler</a>
        <a href="/admin/pembina"><span class="icon">👨‍🏫</span> Pembina</a>
        <a href="/admin/pendaftaran"><span class="icon">📋</span> Pendaftaran</a>
        <a href="/admin/anggota"><span class="icon">👥</span> Anggota</a>
    </div>
    <div class="sidebar-logout">
        <a href="/logout" class="btn-icon-link">
        <span class="icon">🚪</span>
        <span class="text">Logout</span>
         </a>
    </div>
</div>

<div class="main-content">

    <div class="topbar">
        <h1>Manajemen Siswa</h1>
    </div>

    <div id="notif"></div>
    <div id="konfirmasi">
        <p id="pesanKonfirmasi"></p>
        <div class="konfirmasi-buttons">
            <button id="btnKonfirmasiYa" class="btn-konfirmasi-hapus">Hapus</button>
            <button onclick="tutupKonfirmasi()" class="btn-cancel">Batal</button>
        </div>
    </div>

    <div class="card">
      <div class="card-header">
       <h2>👤 Daftar Siswa</h2>
        <div style="display:flex; gap:8px;">
           <button class="btn btn-tambah" onclick="bukaFormTambah()">+ Tambah Siswa</button>
           <button class="btn btn-cetak" onclick="cetakPDF()">🖨️ Cetak PDF</button>
           <button class="btn btn-cetak" onclick="cetakPNG()">🖼️ Cetak PNG</button>
          </div>
        </div>
        <div class="card-body">
            <table>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Kelas & Jurusan</th>
                    <th>Nomor Handphone</th>
                    <th>Username</th>
                    <th>Aksi</th>
                </tr>
                @foreach($siswa as $index => $s)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $s->nama_lengkap }}</td>
                    <td>{{ $s->kelas_jurusan }}</td>
                    <td>{{ $s->nomor_handphone }}</td>
                    <td>{{ $s->username }}</td>
                    <td>
                        <button class="btn btn-edit"
                            data-id="{{ $s->id_siswa }}"
                            data-nama="{{ $s->nama_lengkap }}"
                            data-kelas="{{ $s->kelas_jurusan }}"
                            data-hp="{{ $s->nomor_handphone }}">Edit</button>
                        <button class="btn btn-hapus"
                            data-id="{{ $s->id_siswa }}">Hapus</button>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>

</div>

<div class="overlay" id="overlay" onclick="tutupSemua()"></div>

<div class="modal" id="modalTambah">
    <div class="modal-header">
        <h3>Tambah Siswa Baru</h3>
        <button class="close-btn" onclick="tutupSemua()">✕</button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" id="tambahNama" placeholder="Masukkan nama lengkap">
        </div>
       <div class="form-group">
    <label>Kelas & Jurusan</label>
         <select id="tambahKelas">
        <option value="">Pilih Kelas & Jurusan</option>
        <option value="X RPL-A">X RPL - A</option>
        <option value="X RPL-B">X RPL - B</option>
        <option value="X RPL-C">X RPL - C</option>
        <option value="X BD-A">X BD - A</option>
        <option value="X BD-B">X BD - B</option>
        <option value="X TKR-A">X TKR - A</option>
        <option value="X TKR-B">X TKR - B</option>
        <option value="X APHP-A">X APHP - A</option>
        <option value="X APHP-B">X APHP - B</option>
          </select>
        </div>
        <div class="form-group">
            <label>Nomor Handphone</label>
            <input type="text" id="tambahHp" placeholder="Minimal 10 digit">
        </div>
        <div class="form-group">
            <label>Username</label>
            <input type="text" id="tambahUsername" placeholder="Minimal 4 karakter">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" id="tambahPassword" placeholder="Minimal 6 karakter">
        </div>
        <p class="pesan-error" id="pesanTambah"></p>
    </div>
    <div class="modal-footer">
        <button class="btn-cancel" onclick="tutupSemua()">Batal</button>
        <button class="btn-save" onclick="simpanTambah()">Simpan</button>
    </div>
</div>

<div class="modal" id="modalEdit">
    <div class="modal-header">
        <h3>Edit Data Siswa</h3>
        <button class="close-btn" onclick="tutupSemua()">✕</button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" id="editNama">
        </div>
        <div class="form-group">
            <label>Kelas & Jurusan</label>
            <select id="editKelas">          {{-- ← ganti dari kelas_jurusan ke editKelas --}}
                <option value="">Pilih Kelas & Jurusan</option>
                <option value="X RPL-A">X RPL - A</option>
                <option value="X RPL-B">X RPL - B</option>
                <option value="X RPL-C">X RPL - C</option>
                <option value="X BD-A">X BD - A</option>
                <option value="X BD-B">X BD - B</option>
                <option value="X TKR-A">X TKR - A</option>
                <option value="X TKR-B">X TKR - B</option>
                <option value="X APHP-A">X APHP - A</option>
                <option value="X APHP-B">X APHP - B</option>
            </select>
        </div>
        <div class="form-group">
            <label>Nomor Handphone</label>
            <input type="text" id="editHp">
        </div>
        <input type="hidden" id="editId">
    </div>
    <div class="modal-footer">
        <button class="btn-cancel" onclick="tutupSemua()">Batal</button>
        <button class="btn-save" onclick="simpanEdit()">Simpan</button>
    </div>
</div>

<script src="{{ asset('js/admin/siswa.js') }}"></script>
<script src="{{ asset('js/cetak.js') }}"></script>

</body>
</html>