<html>
<head>
    <title>Data Pendaftar Ekstrakurikuler</title>
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
        <h1>Pendaftar Ekstrakurikuler :</h1>
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
                <th>Ekstrakurikuler</th>
                <th>Tanggal Daftar</th>
                <th>Aksi</th>
            </tr>
            
            @php $no = 1; @endphp

            @foreach($grouped as $id_siswa => $data)
                @php
                    $info       = $data['info'];
                    $eskul_list = $data['eskul'];
                    $jumlah     = count($eskul_list);
                @endphp

                @foreach($eskul_list as $index => $eskul)
                <tr>
                    @if($index === 0)
                    <td rowspan="{{ $jumlah }}">{{ $no }}</td>
                    <td rowspan="{{ $jumlah }}">{{ $info->nama_lengkap }}</td>
                    <td rowspan="{{ $jumlah }}">{{ $info->kelas_jurusan }}</td>
                    <td rowspan="{{ $jumlah }}">{{ $info->nomor_handphone }}</td>
                    @endif

                    <td>{{ $eskul->nama_ekskul }}</td>
                    <td>{{ $eskul->tanggal_daftar }}</td>

                    @if($index === 0)
                    <td rowspan="{{ $jumlah }}">
                        <button class="btn-edit" onclick="editData(
                            {{ $info->id_siswa }},
                            '{{ $info->nama_lengkap }}',
                            '{{ $info->kelas_jurusan }}',
                            '{{ $info->nomor_handphone }}'
                        )">Edit</button>
                        <button class="btn-hapus" onclick="hapusData({{ $info->id_siswa }})">Hapus</button>
                    </td>
                    @endif
                </tr>
                @endforeach

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

    <script>
    var hapusIdSementara = null;

    function tampilNotif(pesan, tipe) {
        var notif = document.getElementById('notif');
        notif.innerText = pesan;
        notif.style.display = 'block';
        notif.style.backgroundColor = tipe === 'sukses' ? '#28a745' : '#dc3545';
        setTimeout(function() {
            notif.style.display = 'none';
        }, 2500);
    }

    function tampilKonfirmasi(pesan, id) {
        hapusIdSementara = id;
        document.getElementById('pesanKonfirmasi').innerText = pesan;
        document.getElementById('konfirmasi').style.display = 'block';
    }

    function tutupKonfirmasi() {
        hapusIdSementara = null;
        document.getElementById('konfirmasi').style.display = 'none';
    }

    function editData(id, nama, kelas, hp) {
        document.getElementById('formEdit').style.display = 'block';
        document.getElementById('editId').value   = id;
        document.getElementById('editNama').value  = nama;
        document.getElementById('editKelas').value = kelas;
        document.getElementById('editHp').value    = hp;
    }

    function tutupEdit() {
        document.getElementById('formEdit').style.display = 'none';
    }

    function simpanEdit() {
        var id    = document.getElementById('editId').value;
        var nama  = document.getElementById('editNama').value;
        var kelas = document.getElementById('editKelas').value;
        var hp    = document.getElementById('editHp').value;

        fetch('/edit-siswa/' + id, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ nama_lengkap: nama, kelas_jurusan: kelas, nomor_handphone: hp })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                tutupEdit();
                tampilNotif('Data berhasil diperbarui!', 'sukses');
                setTimeout(function() { location.reload(); }, 1000);
            } else {
                tampilNotif(data.message, 'gagal');
            }
        });
    }

    function hapusData(id_siswa) {
        tampilKonfirmasi('Yakin ingin menghapus semua pendaftaran siswa ini?', id_siswa);
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('btnKonfirmasiYa').addEventListener('click', function() {
            var id = hapusIdSementara;
            tutupKonfirmasi();

            if (!id) return;

            fetch('/hapus-siswa/' + id, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    tampilNotif('Data berhasil dihapus!', 'sukses');
                    setTimeout(function() { location.reload(); }, 1000);
                } else {
                    tampilNotif(data.message, 'gagal');
                }
            });
        });
    });
</script>

</body>
</html>