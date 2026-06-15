<!DOCTYPE html>
<html lang="id">
<head>
    <title>Daftar Ekstrakurikuler</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="id-siswa" content="{{ session('id_siswa') ?? '' }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
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

   <div class="login-wrapper">
    <div class="dashboard-text">
      <h2>Pilih Maksimal 5 Ekstrakurikuler Dan Kembangkan Potensimu!</h2>
    </div>

    <div class="container">
      <table>
        <tr>
          <th>Nama Ekstrakurikuler</th>
          <th>Nama Pembina</th>
          <th>Pendaftaran</th>
        </tr>

        @foreach($ekstrakurikuler as $eskul)
@php
    $fotoMap = [
        'Futsal'        => 'Logo_futsal.jpeg',
        'PMR'           => 'Logo_pmr.jpeg',
        'Pramuka'       => 'Logo_pramuka.jpeg',
        'Paskibra'      => 'Logo_paskibra.jpeg',
        'Volly'         => 'Logo_volly.jpeg',
        'Rohis'         => 'Logo_rohis.jpeg',
        'Karawitan'     => 'Logo_karawitan.png',
        'Marching Band' => 'Logo_marching_band.jpeg',
        'Cinemak'       => 'Logo_cinemak.jpeg',
    ];

    $jadwalMap = [
        'Pramuka'       => 'Jumat',
        'Marching Band' => 'Sabtu',
        'Paskibra'      => 'Sabtu',
        'Futsal'        => 'Rabu : Perempuan Kamis : Laki-Laki',
        'Volly'         => 'Senin : Perempuan Selasa : Laki-Laki',
        'Karawitan'     => 'Rabu',
        'PMR'           => 'Selasa',
        'Rohis'         => 'Senin',
        'Cinemak'       => 'Senin',
    ];

    $foto   = $fotoMap[$eskul->nama_ekskul] ?? 'logosmk.jpg';
    $jadwal = $jadwalMap[$eskul->nama_ekskul] ?? '-';
@endphp
<tr>
    <td>{{ $eskul->nama_ekskul }}</td>
    <td>{{ $eskul->nama_pembina }}</td>
    <td>
        <button class="btn-daftar" onclick="bukaForm(
            {{ $eskul->id_ekskul }},
            `{{ $eskul->nama_ekskul }}`,
            `{{ asset('images/' . $foto) }}`,
            `{{ $jadwal }}`
        )">
            Daftar
        </button>
    </td>
</tr>
@endforeach
      </table>
    </div>

    <div class="overlay" id="overlay" onclick="tutupForm()"></div>

   <div id="formDaftar">
    <div class="form-header">
        <img id="fotoEskul" src="" alt="Logo Eskul">
        <h3>Tentukan Eskulmu dan Jangan Salah Pilih</h3>
    </div>
    <p>Ekstrakurikuler: <span id="namaEskulText"></span></p>
    <p>Jadwal Latihan: <span id="jadwalEskulText"></span></p>
    <input type="hidden" id="idEskul">
    <input type="hidden" id="namaEskul">
    <button class="btn-selesai" onclick="selesai()">Selesai</button>
    <button class="btn-batal" onclick="tutupForm()">Batal</button>
</div>

    <a href="/logout">
      <button class="btn-kembali">Logout</button>
    </a>
   </div>

    <script src="{{ asset('js/dashboard.js') }}"></script>

</body>
</html>