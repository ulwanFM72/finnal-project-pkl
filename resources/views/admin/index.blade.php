<html>
<head>
    <title>Dashboard Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">
        <h2>⚙️ Dashboard Admin</h2>
        <p>Sistem Eskul</p>
    </div>
    <div class="sidebar-menu">
        <p class="menu-label">MENU</p>
        <a href="/admin" class="active"><span class="icon">🏠</span> Ringkasan</a>
        <a href="/admin/siswa"><span class="icon">👤</span> Pengguna</a>
        <a href="/admin/eskul"><span class="icon">🎯</span> Eskul</a>
        <a href="/admin/pembina"><span class="icon">👨‍🏫</span> Pembina</a>
        <a href="/pendaftar"><span class="icon">📋</span> Pendaftaran</a>
    </div>
    <div class="sidebar-logout">
        <a href="/logout"><span>🚪</span> Logout</a>
    </div>
</div>

<div class="main-content">

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">👤</div>
            <div class="stat-info">
                <p>Total Siswa</p>
                <h3>{{ $totalSiswa }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">🎯</div>
            <div class="stat-info">
                <p>Total Eskul</p>
                <h3>{{ $totalEskul }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">👨‍🏫</div>
            <div class="stat-info">
                <p>Total Pembina</p>
                <h3>{{ $totalPembina }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">📋</div>
            <div class="stat-info">
                <p>Total Pendaftaran</p>
                <h3>{{ $totalDaftar }}</h3>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>✅ Pendaftaran Terbaru</h2>
        </div>
        <div class="card-body">
            <table>
                <tr>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Eskul</th>
                    <th>Tanggal</th>
                </tr>
                @foreach($pendaftaranTerbaru as $p)
                <tr>
                    <td>{{ $p->nama_lengkap }}</td>
                    <td>{{ $p->kelas_jurusan }}</td>
                    <td>{{ $p->nama_ekskul }}</td>
                    <td>{{ $p->tanggal_daftar }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>

</div>

</body>
</html>