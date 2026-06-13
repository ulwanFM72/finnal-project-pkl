function login() {
    var username = document.getElementById("username").value.trim();
    var password = document.getElementById("password").value.trim();
    var pesan = document.getElementById("pesan");
    var csrf = document.querySelector('meta[name="csrf-token"]').content;

    if (!username || !password) {
        pesan.style.color = "red";
        pesan.innerText = "Username dan password harus diisi!";
        return;
    }

    pesan.style.color = "#888";
    pesan.innerText = "Memproses...";

    fetch("/login", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrf,
        },
        body: JSON.stringify({ username: username, password: password }),
    })
        .then((res) => res.json())
        .then((data) => {
            pesan.style.color = data.success ? "green" : "red";
            pesan.innerText = data.message;
            if (data.success) {
                window.location.href = data.redirect;
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

document.addEventListener("keydown", function (e) {
    if (e.key === "Enter") login();
});
