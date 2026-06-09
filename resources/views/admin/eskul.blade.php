<html>
<head>
    <title>Kelola Eskul</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

    <h1>Kelola Eskul</h1>

    <button onclick="bukaFormTambah()">Tambah Eskul</button>
    <a href="/admin"><button>Kembali</button></a>
    <a href="/logout"><button>Logout</button></a>

    <br><br>

    <table border="1" cellpadding="10">
        <tr>
            <th>No</th>
            <th>Nama Eskul</th>
            <th>Nama Pembina</th>
            <th>Aksi</th>
        </tr>
        @foreach($eskul as $index => $e)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $e->nama_ekskul }}</td>
            <td>{{ $e->nama_pembina }}</td>
            <td>
                <button class="btn-edit"
                    data-id="{{ $e->id_ekskul }}"
                    data-nama="{{ $e->nama_ekskul }}"
                    data-id-pembina="{{ $e->id_pembina }}">Edit</button>
                <button class="btn-hapus"
                    data-id="{{ $e->id_ekskul }}">Hapus</button>
            </td>
        </tr>
        @endforeach
    </table>

    <!-- Form Tambah Eskul -->
    <div id="formTambah" style="display:none;position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);
    background:white;padding:20px;border:1px solid black;border-radius:10px;box-shadow:0 0 10px gray;width:300px;">
        <h3>Tambah Eskul</h3>
        <p>Nama Eskul:<br><input type="text" id="tambahNama"></p>
        <p>Pembina:<br>
            <select id="tambahPembina" style="width:100%;padding:6px;">
                <option value="">-- Pilih Pembina --</option>
                @foreach($pembina as $p)
                <option value="{{ $p->id_pembina }}">{{ $p->nama_pembina }}</option>
                @endforeach
            </select>
        </p>
        <button onclick="simpanTambah()">Simpan</button>
        <button onclick="tutupFormTambah()">Batal</button>
        <p id="pesanTambah" style="color:red;"></p>
    </div>

    <!-- Form Edit Eskul -->
    <div id="formEdit" style="display:none;position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);
    background:white;padding:20px;border:1px solid black;border-radius:10px;box-shadow:0 0 10px gray;width:300px;">
        <h3>Edit Eskul</h3>
        <p>Nama Eskul:<br><input type="text" id="editNama"></p>
        <p>Pembina:<br>
            <select id="editPembina" style="width:100%;padding:6px;">
                <option value="">-- Pilih Pembina --</option>
                @foreach($pembina as $p)
                <option value="{{ $p->id_pembina }}">{{ $p->nama_pembina }}</option>
                @endforeach
            </select>
        </p>
        <input type="hidden" id="editId">
        <button onclick="simpanEdit()">Simpan</button>
        <button onclick="tutupFormEdit()">Batal</button>
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

        function bukaFormTambah() {
            document.getElementById('formTambah').style.display = 'block';
        }

        function tutupFormTambah() {
            document.getElementById('formTambah').style.display = 'none';
        }

        function tutupFormEdit() {
            document.getElementById('formEdit').style.display = 'none';
        }

        function simpanTambah() {
            var data = {
                nama_ekskul: document.getElementById('tambahNama').value,
                id_pembina:  document.getElementById('tambahPembina').value
            };

            fetch('/admin/tambah-eskul', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    tutupFormTambah();
                    tampilNotif('Eskul berhasil ditambahkan!', 'sukses');
                    setTimeout(function() { location.reload(); }, 1000);
                } else {
                    document.getElementById('pesanTambah').innerText = data.message;
                }
            });
        }

        function simpanEdit() {
            var id         = document.getElementById('editId').value;
            var nama       = document.getElementById('editNama').value;
            var id_pembina = document.getElementById('editPembina').value;

            fetch('/admin/edit-eskul/' + id, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ 
                    nama_ekskul: nama, 
                    id_pembina: id_pembina 
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    tutupFormEdit();
                    tampilNotif('Eskul berhasil diperbarui!', 'sukses');
                    setTimeout(function() { location.reload(); }, 1000);
                } else {
                    tampilNotif(data.message, 'gagal');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.btn-edit').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var id         = this.getAttribute('data-id');
                    var nama       = this.getAttribute('data-nama');
                    var id_pembina = this.getAttribute('data-id-pembina');

                    document.getElementById('formEdit').style.display = 'block';
                    document.getElementById('editId').value   = id;
                    document.getElementById('editNama').value = nama;

                    // set dropdown pembina sesuai pembina eskul ini
                    document.getElementById('editPembina').value = id_pembina;
                });
            });

            document.querySelectorAll('.btn-hapus').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var id = this.getAttribute('data-id');
                    tampilKonfirmasi('Yakin ingin menghapus eskul ini?', id);
                });
            });

            document.getElementById('btnKonfirmasiYa').addEventListener('click', function() {
                var id = hapusIdSementara;
                tutupKonfirmasi();

                if (!id) return;

                fetch('/admin/hapus-eskul/' + id, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        tampilNotif('Eskul berhasil dihapus!', 'sukses');
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