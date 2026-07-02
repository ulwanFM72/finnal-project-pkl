function daftar() {
    var nama = document.getElementById("nama_lengkap").value.trim();
    var kelas = document.getElementById("kelas_jurusan").value.trim();
    var hp = document.getElementById("nomor_handphone").value.trim();
    var username = document.getElementById("username").value.trim();
    var password = document.getElementById("password").value.trim();
    var pesan = document.getElementById("pesan");
    var csrf = document.querySelector('meta[name="csrf-token"]').content;

    fetch("/daftar-akun", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrf,
        },
        body: JSON.stringify({
            nama_lengkap: nama,
            kelas_jurusan: kelas,
            nomor_handphone: hp,
            username: username,
            password: password,
        }),
    })
        .then((res) => res.json())
        .then((data) => {
            var pesan = document.getElementById("pesan");
            pesan.innerText = data.message;
            pesan.style.display = "block";
            pesan.style.backgroundColor = data.success ? "#28a745" : "#dc3545";

            if (data.success) {
                setTimeout(function () {
                    window.location.href = "/";
                }, 1500);
            } else {
                setTimeout(function () {
                    pesan.style.display = "none";
                }, 3000);
            }
        });
}

function togglePassword() {
    var input = document.getElementById("password");
    var icon = document.getElementById("eyeIcon");
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
