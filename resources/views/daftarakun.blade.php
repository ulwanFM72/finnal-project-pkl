<html>
<head>
    <title>Daftar Akun</title>
   <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/daftarakun.css') }}">
</head>
<body>

    <div class="register-container">

        <h1>Daftar Akun Siswa</h1>

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" id="nama_lengkap" 
             placeholder="Masukkan nama lengkap"
                oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
        </div>

        <div class="form-group">
            <label>Kelas & Jurusan</label>
            <input type="text" id="kelas_jurusan" 
             placeholder="Masukkan kelas dan jurusan">
        </div>

        <div class="form-group">
            <label>Nomor Handphone</label>
            <input type="text" id="nomor_handphone" 
             placeholder="08xxxxxxxxxx"
                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
        </div>

        <div class="form-group">
            <label>Username</label>
            <input type="text" id="username" 
                placeholder="Minimal 4 karakter">
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" id="password" 
                placeholder="Minimal 6 karakter">
        </div>

        <button class="btn-daftar" onclick="daftar()">Daftar</button>
        <p class="pesan" id="pesan"></p>
        <a href="/"><button type="button" class="btn-kembali">Kembali</button></a>
    </div>

    <script>
        function daftar() {
            var nama     = document.getElementById('nama_lengkap').value.trim();
            var kelas    = document.getElementById('kelas_jurusan').value.trim();
            var hp       = document.getElementById('nomor_handphone').value.trim();
            var username = document.getElementById('username').value.trim();
            var password = document.getElementById('password').value.trim();

            if (!nama || !kelas || !hp || !username || !password) {
                document.getElementById('pesan').style.color = 'red';
                document.getElementById('pesan').innerText = 'Semua field harus diisi!';
                return;
            }

            if (!/^[a-zA-Z\s]+$/.test(nama)) {
                document.getElementById('pesan').style.color = 'red';
                document.getElementById('pesan').innerText = 'Nama hanya boleh berisi huruf!';
                return;
            }

            if (hp.length < 10) {
                document.getElementById('pesan').style.color = 'red';
                document.getElementById('pesan').innerText = 'Nomor HP minimal 10 digit!';
                return;
            }

            if (username.length < 4) {
                document.getElementById('pesan').style.color = 'red';
                document.getElementById('pesan').innerText = 'Username minimal 4 karakter!';
                return;
            }

            if (password.length < 6) {
                document.getElementById('pesan').style.color = 'red';
                document.getElementById('pesan').innerText = 'Password minimal 6 karakter!';
                return;
            }

            fetch('/daftar-akun', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    nama_lengkap:    nama,
                    kelas_jurusan:   kelas,
                    nomor_handphone: hp,
                    username:        username,
                    password:        password
                })
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('pesan').style.color = data.success ? 'green' : 'red';
                document.getElementById('pesan').innerText = data.message;
                if (data.success) {
                    setTimeout(() => window.location.href = '/', 1500);
                }
            });
        }
    </script>

</body>
</html>