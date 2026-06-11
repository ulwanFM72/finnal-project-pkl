<html>
<head>
    <title>Dashboard Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-brand">
        <h2>⚙️ Admin Panel</h2>
        <p>Sistem Eskul</p>
    </div>
    <div class="sidebar-menu">
        <p class="menu-label">MENU</p>
        <a href="/admin" class="active"><span class="icon">🏠</span> Ringkasan</a>
        <a href="/admin/siswa"><span class="icon">👤</span> Pengguna</a>
        <a href="/admin/eskul"><span class="icon">🎯</span> Eskul</a>
        <a href="/admin/pembina"><span class="icon">👨‍🏫</span> Pembina</a>
        <a href="/admin/pendaftaran"><span class="icon">📋</span> Pendaftaran</a>
        <a href="/admin/anggota"><span class="icon">👥</span> Anggota</a>
    </div>
    <div class="sidebar-logout">
        <a href="/logout"><span>🚪</span> Logout</a>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">

    <div class="topbar">
        <h1>Ringkasan</h1>
        <div class="admin-badge">⚙️ Administrator</div>
    </div>

    <!-- Stats -->
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

    <!-- Tabel Pendaftaran Terbaru -->
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