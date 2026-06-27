<!DOCTYPE html>
<html>
<head>
    <title>Data Pendaftar Ekstrakurikuler</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-smkn1cijati.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/pendaftar.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div id="notif" style="display:none;position:fixed;top:20px;right:20px;padding:12px 20px;border-radius:6px;color:white;font-size:14px;z-index:9999;box-shadow:0 2px 8px rgba(0,0,0,0.2);"></div>

<div id="konfirmasi" style="display:none;position:fixed;top:20px;right:20px;background:white;padding:16px 20px;border-radius:6px;box-shadow:0 2px 12px rgba(0,0,0,0.2);z-index:9999;font-size:14px;color:#333;">
    <p id="pesanKonfirmasi" style="margin-bottom:10px;"></p>
    <button id="btnKonfirmasiYa" style="padding:5px 14px;background:#dc3545;color:white;border:none;border-radius:4px;cursor:pointer;margin-right:6px;font-size:13px;">Hapus</button>
    <button onclick="tutupKonfirmasi()" style="padding:5px 14px;background:#e0e0e0;color:#555;border:none;border-radius:4px;cursor:pointer;font-size:13px;">Batal</button>
</div>

<div class="header-bar">
    <h1>Pendaftar Ekstrakurikuler : {{ $nama_eskul }}</h1>
</div>

<div class="dropdown-wrapper">
    <button class="btn-dropdown" onclick="toggleDropdown()">☰ Menu</button>
    <div class="dropdown-menu" id="dropdownMenu">
        <div class="dropdown-search">
            <input type="text" id="searchInput" placeholder="Cari nama, kelas, no hp..." oninput="filterTabel()">
        </div>
        <div class="dropdown-divider"></div>
        <button class="dropdown-item" onclick="cetakPDF(); tutupDropdown()">🖨️ Cetak PDF</button>
        <button class="dropdown-item" onclick="cetakPNG(); tutupDropdown()">🖼️ Cetak PNG</button>
    </div>
</div>

@if(session('nama_pembina'))
    <button class="logout-link-fixed-pembina" onclick="window.location.href='/logout'" title="Logout">
        <i class="fa-solid fa-arrow-right-from-bracket"></i>
    </button>
@endif

<div class="container">
    <table>
        <tr>
            <th>No</th>
            <th>Nama Lengkap</th>
            <th>Kelas & Jurusan</th>
            <th>Nomor Handphone</th>
            <th>Tanggal Daftar</th>
            <th>Aksi</th>
        </tr>

        @if(count($grouped) == 0)
        <tr>
            <td colspan="6" style="text-align:center;color:#999;padding:20px;">
                Belum ada pendaftar.
            </td>
        </tr>
        @endif

        @php $no = 1; @endphp

        @foreach($grouped as $id_siswa => $data)
            @php
                $info       = $data['info'];
                $eskul_list = $data['eskul'];
                $jumlah     = count($eskul_list);
            @endphp
            <tr>
                <td>{{ $no }}</td>
                <td>{{ $info->nama_lengkap }}</td>
                <td>{{ $info->kelas_jurusan }}</td>
                <td>{{ $info->nomor_handphone }}</td>
                <td>{{ $info->tanggal_daftar }}</td>
                <td>
                    <button class="btn-edit" onclick="editData(
                        {{ $info->id_siswa }},
                        '{{ $info->nama_lengkap }}',
                        '{{ $info->kelas_jurusan }}',
                        '{{ $info->nomor_handphone }}'
                    )">Edit</button>
                    <button class="btn-hapus" onclick="hapusData({{ $info->id_siswa }})">Hapus</button>
                </td>
            </tr>
            @php $no++; @endphp
        @endforeach
    </table>
</div>

<div class="overlay" id="overlay" onclick="tutupEdit()"></div>

<div id="formEdit">
    <h3>Edit Data Siswa</h3>
    <p>Nama Lengkap:<br><input type="text" id="editNama"></p>
    <p>Kelas & Jurusan:<br>
        <select id="editKelas" style="width:100%;padding:7px 10px;margin-top:4px;border:1px solid #ddd;border-radius:4px;font-size:13px;outline:none;">
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
    </p>
    <p>Nomor Handphone:<br><input type="text" id="editHp"></p>
    <input type="hidden" id="editId">
    <button class="btn-simpan" onclick="simpanEdit()">Simpan</button>
    <button class="btn-batal" onclick="tutupEdit()">Batal</button>
</div>

<script src="{{ asset('js/pendaftar.js') }}"></script>
<script src="{{ asset('js/cetak.js') }}"></script>

</body>
</html>