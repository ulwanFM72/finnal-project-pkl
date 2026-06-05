<html>
<head>
    <title>Login</title>
    <style>
    </style>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

    <div class="login-wrapper">

        <div class="login-text">
             <h2>Join Your Fashion!</h2>
        <p>
            Pilih Ekstrakurikuler Favoritmu<br>
            & Kembangkan Bakatmu!
        </p>
        </div>

        <div class="login-container">
            <div class="role-selector">
                <button class="role-btn active" id="btnSiswa" onclick="pilihRole('siswa')">Siswa</button>
                <button class="role-btn" id="btnPembina" onclick="pilihRole('pembina')">Pembina</button>
            </div>

            <div class="form-body">
                <h2 id="judulLogin">Login Siswa</h2>

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" id="username" placeholder="Masukkan username">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" id="password" placeholder="Masukkan password">
                </div>

                <button class="btn-login" onclick="login()">Login</button>

                <p class="pesan" id="pesan"></p>

                <div class="daftar-link" id="linkDaftar">
                    Belum punya akun? <a href="/daftar-akun">Daftar di sini</a>
                </div>
            </div>
        </div>

    </div>

    <script>
        var roleAktif = 'siswa';

        function pilihRole(role) {
            roleAktif = role;

            document.getElementById('btnSiswa').classList.remove('active');
            document.getElementById('btnPembina').classList.remove('active');

            document.getElementById('btn' + role.charAt(0).toUpperCase() + role.slice(1)).classList.add('active');

            document.getElementById('judulLogin').innerText = role === 'siswa' ? 'Login Siswa' : 'Login Pembina';

            document.getElementById('linkDaftar').style.display = role === 'siswa' ? 'block' : 'none';

            document.getElementById('pesan').innerText = '';
            document.getElementById('username').value = '';
            document.getElementById('password').value = '';
        }

        function login() {
            var username = document.getElementById('username').value.trim();
            var password = document.getElementById('password').value.trim();
            var pesan    = document.getElementById('pesan');

            if (!username || !password) {
                pesan.innerText = 'Username dan password harus diisi!';
                return;
            }

            fetch('/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    username: username,
                    password: password,
                    role: roleAktif
                })
            })
            .then(res => res.json())
           .then(data => {
            pesan.innerText = data.message;

            if (data.success) {
            window.location.href = data.redirect;
            }
          });
        }
    </script>

</body>
</html>