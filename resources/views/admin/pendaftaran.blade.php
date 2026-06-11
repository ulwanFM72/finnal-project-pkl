<html>
<head>
    <title>Data Pendaftaran</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
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
        <a href="/admin/pendaftaran" class="active"><span class="icon">📋</span> Pendaftaran</a>
        <a href="/admin/anggota"><span class="icon">👥</span> Anggota</a>
    </div>
    <div class="sidebar-logout">
        <a href="/logout"><span>🚪</span> Logout</a>
    </div>
</div>

<div class="main-content">

    <div class="topbar">
        <h1>Semua Pendaftaran</h1>
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
            <h2>✅ Semua Pendaftaran</h2>
        </div>
        <div class="card-body">
            <table>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>No HP</th>
                    <th>Ekstrakulikuler</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
                @foreach($pendaftaran as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->nama_lengkap }}</td>
                    <td>{{ $p->kelas_jurusan }}</td>
                    <td>{{ $p->nomor_handphone }}</td>
                    <td>
                        @foreach(explode(', ', $p->daftar_eskul) as $eskul)
                            <span class="badge badge-siswa">{{ $eskul }}</span>
                        @endforeach
                    </td>
                    <td>{{ $p->tanggal_daftar }}</td>
                    <td>
                        <button class="btn btn-hapus"
                            data-id="{{ $p->id_siswa }}">Hapus</button>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
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

    document.addEventListener('DOMContentLoaded', function() {

       document.querySelectorAll('.btn-hapus').forEach(function(btn) {
          btn.addEventListener('click', function() {
        tampilKonfirmasi('Yakin ingin menghapus pendaftaran siswa ini?', this.getAttribute('data-id'));
           });
          });

         document.getElementById('btnKonfirmasiYa').addEventListener('click', function() {
           var id = hapusIdSementara;
             tutupKonfirmasi();
             if (!id) return;

              fetch('/admin/hapus-pendaftaran/' + id, {
                method: 'POST',
                headers: {
                 'Content-Type': 'application/json',
                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                       }
                     })
                .then(res => res.json())
                .then(data => {
                  if (data.success) {
            tampilNotif('Pendaftaran berhasil dihapus!', 'sukses');
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