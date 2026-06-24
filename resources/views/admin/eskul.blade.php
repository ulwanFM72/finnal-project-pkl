<!DOCTYPE html>
<html>
<head>
    <title>Kelola Ekstrakurikuler</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-smkn1cijati.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        .upload-area {
            border: 2px dashed #c0d8f0;
            border-radius: 8px;
            padding: 14px;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
            background: #f8fbff;
            position: relative;
        }
        .upload-area:hover { border-color: #4a90d9; background: #eef5fd; }
        .upload-area input[type=file] {
            position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
        }
        .upload-area .preview-img {
            width: 60px; height: 60px; object-fit: cover;
            border-radius: 6px; margin-bottom: 6px; display: none;
        }
        .upload-area p { font-size: 12px; color: #888; margin: 0; }
        .upload-area .upload-label { font-size: 13px; color: #4a90d9; font-weight: 600; }
        .upload-group { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        @media (max-width: 600px) { .upload-group { grid-template-columns: 1fr; } }
    </style>
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
        <a href="/logout" class="btn-icon-link">
            <span class="icon">🚪</span>
            <span class="text">Logout</span>
        </a>
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
            <button id="btnKonfirmasiYa" class="btn btn-konfirmasi-hapus">Hapus</button>
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
                    <th>No</th>
                    <th>Nama Ekstrakurikuler</th>
                    <th>Pembina</th>
                    <th>Jadwal</th>
                    <th>Logo</th>
                    <th>Foto Kegiatan</th>
                    <th>Aksi</th>
                </tr>
                @foreach($eskul as $index => $e)
                <tr>
                    <td data-label="#">{{ $index + 1 }}</td>
                    <td data-label="Eskul">{{ $e->nama_ekskul }}</td>
                    <td data-label="Pembina">{{ $e->nama_pembina }}</td>
                    <td data-label="Jadwal">{{ $e->jadwal ?? '-' }}</td>
                    <td data-label="Logo">
                        @if($e->foto)
                            <img src="{{ asset('images/' . $e->foto) }}" alt="logo"
                                 style="width:40px;height:40px;object-fit:cover;border-radius:4px;">
                        @else
                            <span style="color:#999;">-</span>
                        @endif
                    </td>
                    <td data-label="Kegiatan">
                        @if($e->foto_kegiatan)
                            <img src="{{ asset('images/' . $e->foto_kegiatan) }}" alt="kegiatan"
                                 style="width:40px;height:40px;object-fit:cover;border-radius:4px;">
                        @else
                            <span style="color:#999;">-</span>
                        @endif
                    </td>
                    <td data-label="Aksi">
                        <button class="btn btn-edit"
                            data-id="{{ $e->id_ekskul }}"
                            data-nama="{{ $e->nama_ekskul }}"
                            data-id-pembina="{{ $e->id_pembina }}"
                            data-jadwal="{{ $e->jadwal }}"
                            data-foto="{{ $e->foto }}"
                            data-foto-kegiatan="{{ $e->foto_kegiatan }}"
                            data-deskripsi="{{ $e->deskripsi }}">Edit</button>
                        <button class="btn btn-hapus" data-id="{{ $e->id_ekskul }}">Hapus</button>
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
        <h3>Tambah Ekstrakurikuler Baru</h3>
        <button class="close-btn" onclick="tutupSemua()">✕</button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Nama Ekstrakurikuler</label>
            <input type="text" id="tambahNama">
        </div>
        <div class="form-group">
            <label>Pembina</label>
            <select id="tambahPembina">
                <option value="">Pilih Pembina</option>
                @foreach($pembina as $p)
                <option value="{{ $p->id_pembina }}">{{ $p->nama_pembina }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Jadwal Latihan</label>
            <input type="text" id="tambahJadwal">
        </div>
        <div class="form-group">
            <label>Upload Foto</label>
            <div class="upload-group">
                <div>
                    <p style="font-size:12px;color:#555;margin-bottom:6px;">Logo Eskul</p>
                    <div class="upload-area" id="tambahAreaLogo">
                        <input type="file" id="tambahFoto" accept="image/*" onchange="previewFoto(this, 'tambahPreviewLogo', 'tambahLabelLogo')">
                        <img id="tambahPreviewLogo" class="preview-img">
                        <span class="upload-label" id="tambahLabelLogo">🖼️ Pilih Logo</span>
                        <p>PNG, JPG, JPEG</p>
                    </div>
                </div>
                <div>
                    <p style="font-size:12px;color:#555;margin-bottom:6px;">Foto Kegiatan</p>
                    <div class="upload-area" id="tambahAreaKegiatan">
                        <input type="file" id="tambahFotoKegiatan" accept="image/*" onchange="previewFoto(this, 'tambahPreviewKegiatan', 'tambahLabelKegiatan')">
                        <img id="tambahPreviewKegiatan" class="preview-img">
                        <span class="upload-label" id="tambahLabelKegiatan">📷 Pilih Foto</span>
                        <p>PNG, JPG, JPEG</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea id="tambahDeskripsi" rows="3"></textarea>
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
        <h3>Edit Data Ekstrakurikuler</h3>
        <button class="close-btn" onclick="tutupSemua()">✕</button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Nama Ekstrakurikuler</label>
            <input type="text" id="editNama">
        </div>
        <div class="form-group">
            <label>Pembina</label>
            <select id="editPembina">
                <option value="">Pilih Pembina</option>
                @foreach($pembina as $p)
                <option value="{{ $p->id_pembina }}">{{ $p->nama_pembina }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Jadwal Latihan</label>
            <input type="text" id="editJadwal" placeholder="Contoh: Senin & Rabu, 14.00–16.00">
        </div>
        <div class="form-group">
            <label>Upload Foto <small style="color:#999;">(kosongkan jika tidak ingin mengganti)</small></label>
            <div class="upload-group">
                <div>
                    <p style="font-size:12px;color:#555;margin-bottom:6px;">Logo Eskul</p>
                    <div class="upload-area">
                        <input type="file" id="editFoto" accept="image/*" onchange="previewFoto(this, 'editPreviewLogo', 'editLabelLogo')">
                        <img id="editPreviewLogo" class="preview-img">
                        <span class="upload-label" id="editLabelLogo">🖼️ Ganti Logo</span>
                        <p>PNG, JPG, JPEG</p>
                    </div>
                </div>
                <div>
                    <p style="font-size:12px;color:#555;margin-bottom:6px;">Foto Kegiatan</p>
                    <div class="upload-area">
                        <input type="file" id="editFotoKegiatan" accept="image/*" onchange="previewFoto(this, 'editPreviewKegiatan', 'editLabelKegiatan')">
                        <img id="editPreviewKegiatan" class="preview-img">
                        <span class="upload-label" id="editLabelKegiatan">📷 Ganti Foto</span>
                        <p>PNG, JPG, JPEG</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea id="editDeskripsi" rows="3"></textarea>
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
