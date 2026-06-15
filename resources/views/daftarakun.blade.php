<html>
<head>
    <title>Daftar Akun</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
          <select id="kelas_jurusan">
        <option value="">Pilih Kelas & Jurusan</option>
        <option value="X RPL-A">X RPL - A</option>
        <option value="X RPL-B">X RPL - B</option>
        <option value="X BD-A">X BD - A</option>
        <option value="X BD-B">X BD - B</option>
        <option value="X TKR-A">X TKR - A</option>
        <option value="X TKR-B">X TKR - B</option>
        <option value="X APHP-A">X APHP - A</option>
        <option value="X APHP-B">X APHP - B</option>
             </select>
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

  <script src="{{ asset('js/daftarakun.js') }}"></script>

</body>
</html>