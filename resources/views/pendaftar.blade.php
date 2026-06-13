<html>
<head>
    <title>Data Pendaftar Ekstrakurikuler</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/pendaftar.css') }}">
</head>
<body>

<div id="notif" style="
    display:none;
    position:fixed;
    top:20px;
    right:20px;
    padding:12px 20px;
    border-radius:6px;
    color:white;
    font-size:14px;
    z-index:9999;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
"></div>

<div id="konfirmasi" style="
    display:none;
    position:fixed;
    top:20px;
    right:20px;
    background:white;
    padding:16px 20px;
    border-radius:6px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.2);
    z-index:9999;
    font-size:14px;
    color:#333;
">
    <p id="pesanKonfirmasi" style="margin-bottom:10px;"></p>
    <button id="btnKonfirmasiYa" style="
        padding:5px 14px;
        background:#dc3545;
        color:white;
        border:none;
        border-radius:4px;
        cursor:pointer;
        margin-right:6px;
        font-size:13px;
    ">Ya, Hapus</button>
    <button onclick="tutupKonfirmasi()" style="
        padding:5px 14px;
        background:#e0e0e0;
        color:#555;
        border:none;
        border-radius:4px;
        cursor:pointer;
        font-size:13px;
    ">Batal</button>
</div>

    <div class="header-bar">
        <h1>Pendaftar Ekstrakurikuler : {{ $nama_eskul }}</h1>
        @if(session('nama_pembina'))
            <a href="/logout"><button class="btn-logout">Logout</button></a>
        @endif
    </div>

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
                <td colspan="6" style="text-align:center; color:#999; padding:20px;">
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
        <p>Kelas & Jurusan:<br><input type="text" id="editKelas"></p>
        <p>Nomor Handphone:<br><input type="text" id="editHp"></p>
        <input type="hidden" id="editId">
        <button class="btn-simpan" onclick="simpanEdit()">Simpan</button>
        <button class="btn-batal" onclick="tutupEdit()">Batal</button>
    </div>

    <script src="{{ asset('js/pendaftar.js') }}"></script>

</body>
</html>