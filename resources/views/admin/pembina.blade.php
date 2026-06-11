<html>
<head>
    <title>Kelola Pembina</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">
        <h2>⚙️ Admin Panel</h2>
        <p>Sistem Eskul</p>
    </div>
    <div class="sidebar-menu">
        <p class="menu-label">MENU</p>
        <a href="/admin"><span class="icon">🏠</span> Ringkasan</a>
        <a href="/admin/siswa"><span class="icon">👤</span> Pengguna</a>
        <a href="/admin/eskul"><span class="icon">🎯</span> Eskul</a>
        <a href="/admin/pembina" class="active"><span class="icon">👨‍🏫</span> Pembina</a>
        <a href="/admin/pendaftaran"><span class="icon">📋</span> Pendaftaran</a>
        <a href="/admin/anggota"><span class="icon">👥</span> Anggota</a>
    </div>
    <div class="sidebar-logout">
        <a href="/logout"><span>🚪</span> Logout</a>
    </div>
</div>

<div class="main-content">

    <div class="topbar">
        <h1>Manajemen Pembina</h1>
        <div class="admin-badge">⚙️ Administrator</div>
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
            <h2>👨‍🏫 Daftar Pembina</h2>
            <button class="btn btn-tambah" onclick="bukaFormTambah()">+ Tambah Pembina</button>
        </div>
        <div class="card-body">
            <table>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>No HP</th>
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

<!-- Modal Tambah -->
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
            <label>No HP</label>
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

<!-- Modal Edit -->
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
            <label>No HP</label>
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

<script>
    var hapusIdSementara = null;

    function tampilNotif(pesan, tipe) {
        var notif = document.getElementById('notif');
        notif.innerText = pesan;
        notif.style.display = 'block';
        notif.style.backgroundColor = tipe === 'sukses' ? '#28a745' : '#dc3545';
        setTimeout(function() { notif.style.display = 'none'; }, 2500);
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
        document.getElementById('overlay').style.display = 'block';
        document.getElementById('modalTambah').style.display = 'block';
    }

    function tutupSemua() {
        document.getElementById('overlay').style.display = 'none';
        document.getElementById('modalTambah').style.display = 'none';
        document.getElementById('modalEdit').style.display = 'none';
    }

    function simpanTambah() {
        var data = {
            nama_pembina:    document.getElementById('tambahNama').value,
            nomor_handphone: document.getElementById('tambahHp').value,
            email:           document.getElementById('tambahEmail').value,
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
                tutupSemua();
                tampilNotif('Pembina berhasil ditambahkan!', 'sukses');
                setTimeout(function() { location.reload(); }, 1000);
            } else {
                document.getElementById('pesanTambah').innerText = data.message;
            }
        });
    }

    function simpanEdit() {
        var id    = document.getElementById('editId').value;
        var nama  = document.getElementById('editNama').value;
        var hp    = document.getElementById('editHp').value;
        var email = document.getElementById('editEmail').value;

        fetch('/admin/edit-pembina/' + id, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ nama_pembina: nama, nomor_handphone: hp, email: email })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                tutupSemua();
                tampilNotif('Data berhasil diperbarui!', 'sukses');
                setTimeout(function() { location.reload(); }, 1000);
            } else {
                tampilNotif(data.message, 'gagal');
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {

        document.querySelectorAll('.btn-edit').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.getElementById('overlay').style.display = 'block';
                document.getElementById('modalEdit').style.display = 'block';
                document.getElementById('editId').value    = this.getAttribute('data-id');
                document.getElementById('editNama').value  = this.getAttribute('data-nama');
                document.getElementById('editHp').value    = this.getAttribute('data-hp');
                document.getElementById('editEmail').value = this.getAttribute('data-email');
            });
        });

        document.querySelectorAll('.btn-hapus').forEach(function(btn) {
            btn.addEventListener('click', function() {
                tampilKonfirmasi('Yakin ingin menghapus pembina ini?', this.getAttribute('data-id'));
            });
        });

        document.getElementById('btnKonfirmasiYa').addEventListener('click', function() {
            var id = hapusIdSementara;
            tutupKonfirmasi();
            if (!id) return;

            fetch('/admin/hapus-pembina/' + id, {
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
</script>

</body>
</html>