<!DOCTYPE html>
<html lang="id">
<head>
    <title>Daftar Ekstrakurikuler</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-smkn1cijati.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="id-siswa" content="{{ session('id_siswa') ?? '' }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

<div id="notif" style="display:none;position:fixed;top:20px;right:20px;padding:12px 20px;border-radius:6px;color:white;font-size:14px;z-index:9999;box-shadow:0 2px 8px rgba(0,0,0,0.2);"></div>

<div class="login-wrapper">

    <div class="dashboard-text">
        <h2>Pilih Maksimal 5 Ekstrakurikuler <br> Dan Kembangkan Potensimu!</h2>
    </div>

    <div class="container">
        <table>
            <tr>
                <th style="width:30px;">No</th>
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
                    'Futsal'        => "Rabu Perempuan\nKamis Laki-Laki",
                    'Volly'         => "Senin Perempuan\nSelasa Laki-Laki",
                    'Karawitan'     => 'Rabu',
                    'PMR'           => 'Selasa',
                    'Rohis'         => 'Senin',
                    'Cinemak'       => 'Senin',
                ];
                $foto   = $fotoMap[$eskul->nama_ekskul] ?? 'logosmk.jpg';
                $jadwal = $jadwalMap[$eskul->nama_ekskul] ?? '-';
            @endphp
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $eskul->nama_ekskul }}</td>
                <td>{{ $eskul->nama_pembina }}</td>
                <td>
                    <button class="btn-daftar" onclick="bukaForm(
                        {{ $eskul->id_ekskul }},
                        `{{ $eskul->nama_ekskul }}`,
                        `{{ asset('images/' . $foto) }}`,
                        `{{ $jadwal }}`
                    )">Daftar</button>
                </td>
            </tr>
            @endforeach

        </table>
    </div>
    <div class="galeri-section">
    <div class="section-divider-b">
        <i class="ti ti-photo"></i> Galeri Kegiatan Ekstrakurikuler
    </div>

    <div class="slider-outer">
        <div class="slider-viewport">
            <div class="slider-track" id="eskulSliderTrack">

                @foreach($ekstrakurikuler as $eskul)
                @php
                    $fotoMap = [
                        'Futsal'        => 'kegiatan_futsal.jpeg',
                        'PMR'           => 'kegiatan_pmr.jpeg',
                        'Pramuka'       => 'kegiatan_pramuka.jpeg',
                        'Paskibra'      => 'kegiatan_paskibra.jpeg',
                        'Volly'         => 'kegiatan_volly.jpeg',
                        'Rohis'         => 'kegiatan_rohis.jpeg',
                        'Karawitan'     => 'kegiatan_karawitan.jpeg',
                        'Marching Band' => 'kegiatan_marching_band.jpeg',
                        'Cinemak'       => 'kegiatan_cinemak.jpeg',
                    ];
                    $descMap = [
                        'Futsal'        => 'Olahraga permainan tim dengan 5 pemain di lapangan tertutup. Melatih kerjasama, kecepatan, dan strategi.',
                        'PMR'           => 'Palang Merah Remaja — melatih keterampilan pertolongan pertama, donor darah, dan kepedulian sosial.',
                        'Pramuka'       => 'Gerakan pramuka membangun karakter, kepemimpinan, kemandirian, dan kecintaan terhadap alam.',
                        'Paskibra'      => 'Pasukan pengibar bendera — melatih kedisiplinan, ketangkasan baris berbaris, dan nasionalisme.',
                        'Volly'         => 'Olahraga permainan tim 6 vs 6. Melatih koordinasi gerak, reflek, stamina, dan komunikasi tim.',
                        'Rohis'         => 'Rohani Islam — wadah pengembangan spiritual, kajian agama, dan pembinaan akhlak siswa muslim.',
                        'Karawitan'     => 'Seni musik tradisional Jawa menggunakan gamelan. Melestarikan budaya lokal dan melatih kepekaan seni.',
                        'Marching Band' => 'Paduan musik dan baris berbaris. Melatih kekompakan, koordinasi, dan penampilan di berbagai acara.',
                        'Cinemak'       => 'Sinema & fotografi — melatih kreativitas dalam dunia film pendek, editing video, dan dokumentasi.',
                    ];
                    $foto   = $fotoMap[$eskul->nama_ekskul] ?? 'logosmk.jpg';
                    $jadwal = $jadwalMap[$eskul->nama_ekskul] ?? '-';
                    $desc   = $descMap[$eskul->nama_ekskul] ?? '';
                @endphp
                <div class="eskul-slide">
                    <div class="eskul-slide-photo">
                        <img src="{{ asset('images/' . $foto) }}" alt="Foto {{ $eskul->nama_ekskul }}">
                    </div>
                    <div class="eskul-slide-info">
                        <h3>{{ $eskul->nama_ekskul }}</h3>
                        <p><span class="info-label">Pembina</span>{{ $eskul->nama_pembina }}</p>
                        <p><span class="info-label">Jadwal</span>{{ $jadwal }}</p>
                        <p class="info-desc">{{ $desc }}</p>
                    </div>
                </div>
                @endforeach

            </div>
            <button class="slider-nav prev" onclick="eskulMove(-1)" aria-label="Sebelumnya">&#8249;</button>
            <button class="slider-nav next" onclick="eskulMove(1)" aria-label="Berikutnya">&#8250;</button>
        </div>
        <div class="slider-dots" id="eskulDots"></div>
    </div>

</div>

       <div class="overlay" id="overlay" onclick="tutupForm()"></div>

    <div id="formDaftar">
        <div class="form-header">
            <img id="fotoEskul" src="" alt="Logo Eskul">
            <h3>Tentukan Ekskulmu dan Jangan Salah Pilih</h3>
        </div>
        <p>Ekstrakurikuler : <span id="namaEskulText"></span></p>
        <p>Jadwal Latihan : <span id="jadwalEskulText"></span></p>
        <input type="hidden" id="idEskul">
        <input type="hidden" id="namaEskul">
        <button class="btn-selesai btn-island" onclick="selesai()">Selesai</button>
        <button class="btn-selesai btn-island" onclick="tutupForm()">Batal</button>
    </div>

    <a href="/logout" class="logout-link">
        <button class="btn-kembali btn-icon">
            <span class="icon">➜</span>
            <span class="text">Logout</span>
        </button>
    </a>

</div>

<script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>