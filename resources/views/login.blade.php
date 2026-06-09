<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <div class="login-wrapper">

        <div class="login-text">
            <h2>Join Your Fashion!</h2>
            <p>Pilih Ekstrakurikuler Favoritmu<br>& Kembangkan Bakatmu!</p>
        </div>

        <div class="login-container">
            <div class="form-body">
                <h2>Login</h2>

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" id="username" placeholder="Masukkan username">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-password">
                        <input type="password" id="password" placeholder="Masukkan password">
                        <i class="fa-regular fa-eye" id="eyeIcon" onclick="togglePassword()"></i>
                    </div>
                </div>

                <button class="btn-login" onclick="login()">Login</button>

                <p class="pesan" id="pesan"></p>

                <div class="daftar-link">
                    Belum punya akun? <a href="/daftar-akun">Daftar di sini</a>
                </div>
            </div>
        </div>

    </div>

    <script>
        function login() {
            var username = document.getElementById('username').value.trim();
            var password = document.getElementById('password').value.trim();
            var pesan    = document.getElementById('pesan');

            if (!username || !password) {
                pesan.style.color = 'red';
                pesan.innerText = 'Username dan password harus diisi!';
                return;
            }

            fetch('/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ username: username, password: password })
            })
            .then(res => res.json())
            .then(data => {
                pesan.style.color = data.success ? 'green' : 'red';
                pesan.innerText = data.message;
                if (data.success) {
                    window.location.href = data.redirect;
                }
            });
        }

        function togglePassword() {
            var input = document.getElementById('password');
            var icon  = document.getElementById('eyeIcon');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

</body>
</html>