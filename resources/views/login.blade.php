<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <div class="login-wrapper">

        <div class="login-text">
            <h2></h2>
            <p></p>
        </div>

        <div class="login-container">
            <div class="form-body">

                 <div class="brand-section">
            <div class="logo-wrap">
                <img src="{{ asset('images/logosmk.jpg') }}" alt="Logo SMK" class="logo-img">
            </div>
            <br>
            <h1 class="brand-name">SMK NEGERI 1 CIJATI</h1>
            <p class="brand-sub">Pilih Ekstrakurikuler Favoritmu<br>Kembangkan Bakatmu!</p>
        </div>

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

  <script src="{{ asset('js/login.js') }}"></script>

</body>
</html>