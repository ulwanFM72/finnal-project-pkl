<html>
<head>
    <title>Data Pendaftar Ekstrakurikuler</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/pendaftar.css') }}">
</head>
<body>

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
        function editData(id, nama, kelas, hp) {
            document.getElementById('formEdit').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('editId').value   = id;
            document.getElementById('editNama').value  = nama;
            document.getElementById('editKelas').value = kelas;
            document.getElementById('editHp').value    = hp;
        }

        function tutupEdit() {
            document.getElementById('formEdit').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
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
                alert(data.message);
                if (data.success) location.reload();
            });
        }

        function hapusData(id_siswa) {
            if (!confirm('Yakin ingin menghapus semua pendaftaran siswa ini?')) return;

            fetch('/hapus-siswa/' + id_siswa, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                if (data.success) location.reload();
            });
        }
    </script>

</body>
</html>