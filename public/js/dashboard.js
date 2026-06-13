function tampilNotif(pesan, tipe) {
    var notif = document.getElementById("notif");
    notif.innerText = pesan;
    notif.style.display = "block";
    notif.style.backgroundColor = tipe === "sukses" ? "#28a745" : "#dc3545";
    setTimeout(function () {
        notif.style.display = "none";
    }, 2500);
}

function bukaForm(idEskul, namaEskul, fotoEskul) {
    document.getElementById("formDaftar").style.display = "block";
    document.getElementById("overlay").style.display = "block";
    document.getElementById("idEskul").value = idEskul;
    document.getElementById("namaEskul").value = namaEskul;
    document.getElementById("namaEskulText").innerText = namaEskul;
    document.getElementById("fotoEskul").src = fotoEskul;
}

function tutupForm() {
    document.getElementById("formDaftar").style.display = "none";
    document.getElementById("overlay").style.display = "none";
}

function selesai() {
    var id_ekskul = document.getElementById("idEskul").value;
    var csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    var idSiswa = document.querySelector('meta[name="id-siswa"]').content;

    if (!idSiswa) {
        tutupForm();
        tampilNotif("Silakan login dulu sebelum mendaftar!", "gagal");
        setTimeout(function () {
            window.location.href = "/";
        }, 2000);
        return;
    }

    fetch("/daftar-eskul", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
        body: JSON.stringify({ id_ekskul: id_ekskul }),
    })
        .then((res) => res.json())
        .then((data) => {
            tutupForm();
            tampilNotif(data.message, data.success ? "sukses" : "gagal");
        })
        .catch((err) => {
            tampilNotif("Terjadi kesalahan!", "gagal");
        });
}
