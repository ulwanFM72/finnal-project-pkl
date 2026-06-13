<html>
<head>
    <title>Kelola Ekstrakurikuler</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        <a href="/admin/eskul" class="active"><span class="icon">🎯</span> Ekstrakurikuler</a>
        <a href="/admin/pembina"><span class="icon">👨‍🏫</span> Pembina</a>
        <a href="/admin/pendaftaran"><span class="icon">📋</span> Pendaftaran</a>
        <a href="/admin/anggota"><span class="icon">👥</span> Anggota</a>
    </div>
    <div class="sidebar-logout">
        <a href="/logout"><span>🚪</span> Logout</a>
    </div>
</div>

<div class="main-content">

    <div class="topbar">
        <h1>Manajemen Ekstrakurikuler</h1>
    </div>

    <div id="notif"></div>
    <div id="konfirmasi">
        <p id="pesanKonfirmasi"></p>
        <div class="konfirmasi-buttons">
            <button id="btnKonfirmasiYa" class="btn btn-konfirmasi-hapus">Ya, Hapus</button>
            <button onclick="tutupKonfirmasi()" class="btn-cancel">Batal</button>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>Daftar Ekstrakurikuler</h2>
            <button class="btn btn-tambah" onclick="bukaFormTambah()">+ Tambah Ekstrakurikuler</button>
        </div>
        <div class="card-body">
            <table>
                <tr>
                    <th>#</th>
                    <th>Nama Ekstrakurikuler</th>
                    <th>Pembina</th>
                    <th>Aksi</th>
                </tr>
                @foreach($eskul as $index => $e)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $e->nama_ekskul }}</td>
                    <td>{{ $e->nama_pembina }}</td>
                    <td>
                        <button class="btn btn-edit"
                            data-id="{{ $e->id_ekskul }}"
                            data-nama="{{ $e->nama_ekskul }}"
                            data-id-pembina="{{ $e->id_pembina }}">Edit</button>
                        <button class="btn btn-hapus"
                            data-id="{{ $e->id_ekskul }}">Hapus</button>
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
        <h3>Tambah Eskul Baru</h3>
        <button class="close-btn" onclick="tutupSemua()">✕</button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Nama Eskul</label>
            <input type="text" id="tambahNama" placeholder="Masukkan nama eskul">
        </div>
        <div class="form-group">
            <label>Pembina</label>
            <select id="tambahPembina">
                <option value="">-- Pilih Pembina --</option>
                @foreach($pembina as $p)
                <option value="{{ $p->id_pembina }}">{{ $p->nama_pembina }}</option>
                @endforeach
            </select>
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
        <h3>Edit Data Eskul</h3>
        <button class="close-btn" onclick="tutupSemua()">✕</button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Nama Eskul</label>
            <input type="text" id="editNama">
        </div>
        <div class="form-group">
            <label>Pembina</label>
            <select id="editPembina">
                <option value="">-- Pilih Pembina --</option>
                @foreach($pembina as $p)
                <option value="{{ $p->id_pembina }}">{{ $p->nama_pembina }}</option>
                @endforeach
            </select>
        </div>
        <input type="hidden" id="editId">
    </div>
    <div class="modal-footer">
        <button class="btn-cancel" onclick="tutupSemua()">Batal</button>
        <button class="btn-save" onclick="simpanEdit()">Simpan</button>
    </div>
</div>

<script src="{{ asset('js/admin/eskul.js') }}"></script>

</body>
</html>