<head>
    <title>Daftar Ekstrakurikuler</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>

   <div class="login-wrapper">
    <div class="dashboard-text">
      <h2>Pilih Maksimal 5 Ekskul, Kembangkan Potensimu!</h2>
    </div>

    <div class="container">
    <table>
        <tr>
            <th>Nama Ekstrakurikuler</th>
            <th>Nama Pembina</th>
            <th>Pendaftaran</th>
        </tr>

        @foreach($ekstrakurikuler as $eskul)
        <tr>
            <td>{{ $eskul->nama_ekskul }}</td>
            <td>{{ $eskul->nama_pembina }}</td>
            <td>
                <button class="btn-daftar" onclick="bukaForm({{ $eskul->id_ekskul }}, `{{ $eskul->nama_ekskul }}`)">
                    Daftar
                </button>
            </td>
        </tr>
        @endforeach
    </table>
  </div>
 
    <div class="overlay" id="overlay" onclick="tutupForm()"></div>

    <div id="formDaftar">
        <h3>Tentukan Eskulmu dan Jangan Salah Pilih</h3>
        <p>Ekstrakurikuler: <span id="namaEskulText"></span></p>
        <input type="hidden" id="idEskul">
        <input type="hidden" id="namaEskul">
           <button class="btn-selesai" onclick="selesai()">Selesai</button>
        <button class="btn-batal" onclick="tutupForm()">Batal</button>
    </div>

    <a href="/logout">
        <button class="btn-kembali">Logout</button>
    </a>
    </div>

    <script>
        function bukaForm(idEskul, namaEskul) {
            document.getElementById('formDaftar').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('idEskul').value = idEskul;
            document.getElementById('namaEskul').value = namaEskul;
            document.getElementById('namaEskulText').innerText = namaEskul;
        }

        function tutupForm() {
            document.getElementById('formDaftar').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        function selesai() {
            var id_ekskul = document.getElementById('idEskul').value;

            @if(session('id_siswa'))
                fetch('/daftar-eskul', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ id_ekskul: id_ekskul })
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) tutupForm();
                })
                .catch(err => {
                    alert('Terjadi kesalahan: ' + err);
                });
            @else
                alert('Silakan login dulu sebelum mendaftar!');
                window.location.href = '/';
            @endif
        }
    </script>

</body>
</html>