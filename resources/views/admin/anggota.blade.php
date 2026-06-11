<html>
<head>
    <title>Anggota Eskul</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        .tab-eskul {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 20px;
        }

        .tab-eskul a {
            padding: 8px 18px;
            border-radius: 20px;
            font-size: 13px;
            text-decoration: none;
            background: white;
            color: #555;
            border: 1px solid #ddd;
            transition: all 0.2s;
        }

        .tab-eskul a:hover {
            background: #f0f2f5;
        }

        .tab-eskul a.active {
            background: #1e2130;
            color: white;
            border-color: #1e2130;
        }

        .eskul-info {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 4px;
        }

        .eskul-info .jumlah-badge {
            background: #e3f2fd;
            color: #1565c0;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }

        .eskul-info .pembina-badge {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 12px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">
        <h2>⚙️ Dashboard Admin</h2>
        <p>Sistem Ekstrakulikuler</p>
    </div>
    <div class="sidebar-menu">
        <p class="menu-label">MENU</p>
        <a href="/admin"><span class="icon">🏠</span> Ringkasan</a>
        <a href="/admin/siswa"><span class="icon">👤</span> Pengguna</a>
        <a href="/admin/eskul"><span class="icon">🎯</span> Ekstrakulikuler</a>
        <a href="/admin/pembina"><span class="icon">👨‍🏫</span> Pembina</a>
        <a href="/admin/pendaftaran"><span class="icon">📋</span> Pendaftaran</a>
        <a href="/admin/anggota" class="active"><span class="icon">👥</span> Anggota</a>
    </div>
    <div class="sidebar-logout">
        <a href="/logout"><span>🚪</span> Logout</a>
    </div>
</div>

<div class="main-content">

    <div class="topbar">
        <h1>Daftar Anggota Ekstrakulikuler</h1>
    </div>

    <div id="notif"></div>
    <div id="konfirmasi">
        <p id="pesanKonfirmasi"></p>
        <div class="konfirmasi-buttons">
            <button id="btnKonfirmasiYa" class="btn btn-hapus">Ya, Hapus</button>
            <button onclick="tutupKonfirmasi()" class="btn-cancel">Batal</button>
        </div>
    </div>

    <div class="tab-eskul">
        @foreach($eskul as $e)
        <a href="/admin/anggota?eskul={{ $e->id_ekskul }}"
            class="{{ $e->id_ekskul == $id_ekskul_aktif ? 'active' : '' }}">
            {{ $e->nama_ekskul }}
        </a>
        @endforeach
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="eskul-info">
                    <h2>👥 Daftar Anggota — {{ $eskul_aktif->nama_ekskul }}</h2>
                    <span class="jumlah-badge">{{ count($anggota) }} siswa</span>
                    <span class="pembina-badge">Pembina: {{ $eskul_aktif->nama_pembina }}</span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Kelas / Jurusan</th>
                    <th>No HP</th>
                    <th>Tgl Daftar</th>
                    <th>Aksi</th>
                </tr>
                @forelse($anggota as $index => $a)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $a->nama_lengkap }}</td>
                    <td>{{ $a->kelas_jurusan }}</td>
                    <td>{{ $a->nomor_handphone }}</td>
                    <td>{{ $a->tanggal_daftar }}</td>
                    <td>
                        <button class="btn btn-edit"
                            data-id="{{ $a->id_siswa }}"
                            data-nama="{{ $a->nama_lengkap }}"
                            data-kelas="{{ $a->kelas_jurusan }}"
                            data-hp="{{ $a->nomor_handphone }}">Edit</button>
                        <button class="btn btn-hapus"
                            data-id-siswa="{{ $a->id_siswa }}"
                            data-id-ekskul="{{ $id_ekskul_aktif }}">Hapus</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; color:#aaa; padding:30px;">
                        Belum ada anggota di Ekstrakulikuler ini
                    </td>
                </tr>
                @endforelse
            </table>
        </div>
    </div>

</div>

<div class="overlay" id="overlay" onclick="tutupSemua()"></div>

<div class="modal" id="modalEdit">
    <div class="modal-header">
        <h3>Edit Data Anggota</h3>
        <button class="close-btn" onclick="tutupSemua()">✕</button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" id="editNama">
        </div>
        <div class="form-group">
            <label>Kelas & Jurusan</label>
            <input type="text" id="editKelas">
        </div>
        <div class="form-group">
            <label>No HP</label>
            <input type="text" id="editHp">
        </div>
        <input type="hidden" id="editId">
    </div>
    <div class="modal-footer">
        <button class="btn-cancel" onclick="tutupSemua()">Batal</button>
        <button class="btn-save" onclick="simpanEdit()">Simpan</button>
    </div>
</div>

<script>
    var hapusIdSementara   = null;
    var hapusEskulSementara = null;

    function tampilNotif(pesan, tipe) {
        var notif = document.getElementById('notif');
        notif.innerText = pesan;
        notif.style.display = 'block';
        notif.style.backgroundColor = tipe === 'sukses' ? '#28a745' : '#dc3545';
        setTimeout(function() { notif.style.display = 'none'; }, 2500);
    }

    function tampilKonfirmasi(pesan, id_siswa, id_ekskul) {
        hapusIdSementara    = id_siswa;
        hapusEskulSementara = id_ekskul;
        document.getElementById('pesanKonfirmasi').innerText = pesan;
        document.getElementById('konfirmasi').style.display = 'block';
    }

    function tutupKonfirmasi() {
        hapusIdSementara    = null;
        hapusEskulSementara = null;
        document.getElementById('konfirmasi').style.display = 'none';
    }

    function tutupSemua() {
        document.getElementById('overlay').style.display = 'none';
        document.getElementById('modalEdit').style.display = 'none';
    }

    function simpanEdit() {
        var id    = document.getElementById('editId').value;
        var nama  = document.getElementById('editNama').value;
        var kelas = document.getElementById('editKelas').value;
        var hp    = document.getElementById('editHp').value;

        fetch('/admin/edit-anggota/' + id, {
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
                document.getElementById('editKelas').value = this.getAttribute('data-kelas');
                document.getElementById('editHp').value    = this.getAttribute('data-hp');
            });
        });

        document.querySelectorAll('.btn-hapus').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var id_siswa  = this.getAttribute('data-id-siswa');
                var id_ekskul = this.getAttribute('data-id-ekskul');
                tampilKonfirmasi('Yakin ingin menghapus anggota ini dari eskul?', id_siswa, id_ekskul);
            });
        });

        document.getElementById('btnKonfirmasiYa').addEventListener('click', function() {
            var id_siswa  = hapusIdSementara;
            var id_ekskul = hapusEskulSementara;
            tutupKonfirmasi();
            if (!id_siswa || !id_ekskul) return;

            fetch('/admin/hapus-anggota/' + id_siswa + '/' + id_ekskul, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    tampilNotif('Anggota berhasil dihapus!', 'sukses');
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