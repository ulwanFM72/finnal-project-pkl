<html>
<head>
    <title>Kelola Pembina</title>
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

    <h1>Kelola Pembina</h1>

    <button onclick="bukaFormTambah()">Tambah Pembina</button>
    <a href="/admin"><button>Kembali</button></a>
    <a href="/logout"><button>Logout</button></a>

    <br><br>

    <table border="1" cellpadding="10">
        <tr>
            <th>No</th>
            <th>Nama Pembina</th>
            <th>No HP</th>
            <th>Email</th>
            <th>Username</th>
            <th>Aksi</th>
        </tr>
       @foreach($pembina as $index => $p)
<tr>
    <td>{{ $index + 1 }}</td>
    <td>{{ $p->nama_pembina }}</td>
    <td>{{ $p->nomor_handphone }}</td>
    <td>{{ $p->email }}</td>
    <td>{{ $p->username }}</td>
    <td>
        <button class="btn-edit"
            data-id="{{ $p->id_pembina }}"
            data-nama="{{ $p->nama_pembina }}"
            data-hp="{{ $p->nomor_handphone }}"
            data-email="{{ $p->email }}">Edit</button>
        <button class="btn-hapus"
            data-id="{{ $p->id_pembina }}">Hapus</button>
    </td>
</tr>
@endforeach
    </table>
    <div id="formTambah" style="display:none;position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);
    background:white;padding:20px;border:1px solid black;border-radius:10px;box-shadow:0 0 10px gray;width:300px;">
        <h3>Tambah Pembina</h3>
        <p>Nama Pembina:<br><input type="text" id="tambahNama"></p>
        <p>No HP:<br><input type="text" id="tambahHp"></p>
        <p>Email:<br><input type="text" id="tambahEmail"></p>
        <p>Username:<br><input type="text" id="tambahUsername"></p>
        <p>Password:<br><input type="password" id="tambahPassword"></p>
        <button onclick="simpanTambah()">Simpan</button>
        <button onclick="tutupFormTambah()">Batal</button>
        <p id="pesanTambah" style="color:red;"></p>
    </div>

    <div id="formEdit" style="display:none;position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);
    background:white;padding:20px;border:1px solid black;border-radius:10px;box-shadow:0 0 10px gray;width:300px;">
        <h3>Edit Pembina</h3>
        <p>Nama Pembina:<br><input type="text" id="editNama"></p>
        <p>No HP:<br><input type="text" id="editHp"></p>
        <p>Email:<br><input type="text" id="editEmail"></p>
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

document.addEventListener('DOMContentLoaded', function() {

    document.querySelectorAll('.btn-edit').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var id    = this.getAttribute('data-id');
            var nama  = this.getAttribute('data-nama');
            var hp    = this.getAttribute('data-hp');
            var email = this.getAttribute('data-email');

            document.getElementById('formEdit').style.display = 'block';
            document.getElementById('editId').value    = id;
            document.getElementById('editNama').value  = nama;
            document.getElementById('editKelas').value = kelas;
            document.getElementById('editHp').value    = hp;
            document.getElementById('editEmail').value = email;
        });
    });

    document.querySelectorAll('.btn-hapus').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            tampilKonfirmasi('Yakin ingin menghapus pembina ini?', id);
        });
    });

    document.getElementById('btnKonfirmasiYa').addEventListener('click', function() {
        var id = hapusIdSementara;

        tutupKonfirmasi();

        if (!id) return;

        fetch('/admin/hapus-pembina-admin/' + id, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                tampilNotif('Pembina berhasil dihapus!', 'sukses');
                setTimeout(function() { location.reload(); }, 1000);
            } else {
                tampilNotif(data.message, 'gagal');
            }
        });
    });

});

function simpanTambah() {
    var data = {
        nama_lengkap:    document.getElementById('tambahNama').value,
        kelas_jurusan:   document.getElementById('tambahKelas').value,
        nomor_handphone: document.getElementById('tambahHp').value,
        username:        document.getElementById('tambahUsername').value,
        password:        document.getElementById('tambahPassword').value
    };

    fetch('/admin/tambah-pembina', {
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
            tampilNotif('Pembina berhasil ditambahkan!', 'sukses');
            setTimeout(function() { location.reload(); }, 1000);
        } else {
            tampilNotif(data.message, 'gagal');
        }
    });
}

function simpanEdit() {
    var id    = document.getElementById('editId').value;
    var nama  = document.getElementById('editNama').value;
    var kelas = document.getElementById('editKelas').value;
    var hp    = document.getElementById('editHp').value;

    fetch('/admin/edit-pembina-admin/' + id, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ 
            nama_lengkap: nama, 
            kelas_jurusan: kelas, 
            nomor_handphone: hp 
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            tutupFormEdit();
            tampilNotif('Data berhasil diperbarui!', 'sukses');
            setTimeout(function() { location.reload(); }, 1000);
        } else {
            tampilNotif(data.message, 'gagal');
        }
    });
}
</script>

</body>
</html>