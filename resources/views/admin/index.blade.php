<html>
<head>
    <title>Dashboard Admin</title>
</head>
<body>
    <h1>Dashboard Admin</h1>

    <p>Total Siswa: {{ $totalSiswa }}</p>
    <p>Total Pembina: {{ $totalPembina }}</p>
    <p>Total Eskul: {{ $totalEskul }}</p>
    <p>Total Pendaftar: {{ $totalDaftar }}</p>

    <br>
    <a href="/admin/siswa"><button>Kelola Siswa</button></a>
    <a href="/admin/pembina"><button>Kelola Pembina</button></a>
    <a href="/logout"><button>Logout</button></a>
</body>
</html>