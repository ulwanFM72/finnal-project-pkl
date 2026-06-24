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
        <div class="navbar-spacer"></div>
        <div class="judul-navbar">
            <h2>
                Pilih Maksimal 5 Ekstrakurikuler
                <br>
                Dan Kembangkan Potensimu!
            </h2>
            <p>Tahun Ajaran 2026 / 2027</p>
        </div>
        <a href="/logout" class="logout-link">
            <button class="btn-kembali btn-icon">
                <span class="icon">➜</span>
                <span class="text">Logout</span>
            </button>
        </a>
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
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $eskul->nama_ekskul }}</td>
                <td>{{ $eskul->nama_pembina }}</td>
                <td>
                    <button class="btn-daftar" onclick="bukaForm(
                        {{ $eskul->id_ekskul }},
                        `{{ $eskul->nama_ekskul }}`,
                        `{{ $eskul->foto ? asset('images/' . $eskul->foto) : asset('images/logosmk.jpg') }}`,
                        `{{ $eskul->jadwal ?? '-' }}`
                    )">Daftar</button>
                </td>
            </tr>
            @endforeach

        </table>
    </div>

    <div class="galeri-section">
        <div class="section-divider-b">
            <i class="ti ti-photo"></i> Galeri Ekstrakurikuler
        </div>

        <div class="slider-outer">
            <div class="slider-viewport">
                <div class="slider-track" id="eskulSliderTrack">

                    @foreach($ekstrakurikuler as $eskul)
                    <div class="eskul-slide">
                        <div class="eskul-slide-photo">
                            <img src="{{ isset($eskul->foto_kegiatan) && $eskul->foto_kegiatan ? asset('images/' . $eskul->foto_kegiatan) : asset('images/logosmk.jpg') }}">
                        </div>
                        <div class="eskul-slide-info">
                            <h3>{{ $eskul->nama_ekskul }}</h3>
                            <p><span class="info-label">Pembina </span>{{ $eskul->nama_pembina }}</p>
                            <p>
                                <span class="info-label">Jadwal </span>
                                <span style="white-space: pre-line;">{{ $eskul->jadwal ?? '-' }}</span>
                            </p>
                            <p class="info-desc">{{ $eskul->deskripsi ?? '' }}</p>
                        </div>
                    </div>
                    @endforeach

                </div>
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

</div>

<script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>