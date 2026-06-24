<!DOCTYPE html>
<html>
<head>
    <title>Kelola Pembina</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-smkn1cijati.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
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
        <a href="/admin/siswa"><span class="icon">👤</span> Siswa</a>
        <a href="/admin/eskul"><span class="icon">🎯</span> Ekstrakurikuler</a>
        <a href="/admin/pembina" class="active"><span class="icon">👨‍🏫</span> Pembina</a>
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
        <h1>Manajemen Pembina</h1>
    </div>

    <div id="notif"></div>
    <div id="konfirmasi">
        <p id="pesanKonfirmasi"></p>
        <div class="konfirmasi-buttons">
           <button id="btnKonfirmasiYa" class="btn btn-konfirmasi-hapus">Hapus</button>
            <button onclick="tutupKonfirmasi()" class="btn-cancel">Batal</button>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>👨‍🏫 Daftar Pembina</h2>
            <button class="btn btn-tambah" onclick="bukaFormTambah()">+ Tambah Pembina</button>
        </div>
        <div class="card-body">
            <table>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Nomor Handphone</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
                @foreach($pembina as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->nama_pembina }}</td>
                    <td>{{ $p->nomor_handphone }}</td>
                    <td>{{ $p->email }}</td>
                    <td>
                        <button class="btn btn-edit"
                            data-id="{{ $p->id_pembina }}"
                            data-nama="{{ $p->nama_pembina }}"
                            data-hp="{{ $p->nomor_handphone }}"
                            data-email="{{ $p->email }}">Edit</button>
                        <button class="btn btn-hapus"
                            data-id="{{ $p->id_pembina }}">Hapus</button>
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
        <h3>Tambah Pembina Baru</h3>
        <button class="close-btn" onclick="tutupSemua()">✕</button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Nama Pembina</label>
            <input type="text" id="tambahNama" placeholder="Masukkan nama pembina">
        </div>
        <div class="form-group">
            <label>Nomor Handphone</label>
            <input type="text" id="tambahHp" placeholder="Minimal 10 digit">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="text" id="tambahEmail" placeholder="Masukkan email">
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
        <h3>Edit Data Pembina</h3>
        <button class="close-btn" onclick="tutupSemua()">✕</button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Nama Pembina</label>
            <input type="text" id="editNama">
        </div>
        <div class="form-group">
            <label>Nomor Handphone</label>
            <input type="text" id="editHp">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="text" id="editEmail">
        </div>
        <input type="hidden" id="editId">
    </div>
    <div class="modal-footer">
        <button class="btn-cancel" onclick="tutupSemua()">Batal</button>
        <button class="btn-save" onclick="simpanEdit()">Simpan</button>
    </div>
</div>

<script src="{{ asset('js/admin/pembina.js') }}"></script>

</body>
</html>