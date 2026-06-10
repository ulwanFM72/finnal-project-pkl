<html>
<head>
    <title>Kelola Eskul</title>
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
        <a href="/admin/eskul" class="active"><span class="icon">🎯</span> Eskul</a>
        <a href="/admin/pembina"><span class="icon">👨‍🏫</span> Pembina</a>
        <a href="/pendaftar"><span class="icon">📋</span> Pendaftaran</a>
    </div>
    <div class="sidebar-logout">
        <a href="/logout"><span>🚪</span> Logout</a>
    </div>
</div>

<div class="main-content">

    <div class="topbar">
        <h1>Manajemen Eskul</h1>
        <div class="admin-badge">⚙️ Administrator</div>
    </div>

    <div id="notif"></div>
    <div id="konfirmasi">
        <p id="pesanKonfirmasi"></p>
        <div class="konfirmasi-buttons">
            <button id="btnKonfirmasiYa" class="btn btn-hapus">Ya, Hapus</button>
            <button onclick="tutupKonfirmasi()" class="btn-cancel">Batal</button>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>🎯 Daftar Eskul</h2>
            <button class="btn btn-tambah" onclick="bukaFormTambah()">+ Tambah Eskul</button>
        </div>
        <div class="card-body">
            <table>
                <tr>
                    <th>#</th>
                    <th>Nama Eskul</th>
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

<!-- Modal Tambah -->
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

<!-- Modal Edit -->
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
                tutupSemua();
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
            body: JSON.stringify({ nama_ekskul: nama, id_pembina: id_pembina })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                tutupSemua();
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
                document.getElementById('overlay').style.display = 'block';
                document.getElementById('modalEdit').style.display = 'block';
                document.getElementById('editId').value      = this.getAttribute('data-id');
                document.getElementById('editNama').value    = this.getAttribute('data-nama');
                document.getElementById('editPembina').value = this.getAttribute('data-id-pembina');
            });
        });

        document.querySelectorAll('.btn-hapus').forEach(function(btn) {
            btn.addEventListener('click', function() {
                tampilKonfirmasi('Yakin ingin menghapus eskul ini?', this.getAttribute('data-id'));
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