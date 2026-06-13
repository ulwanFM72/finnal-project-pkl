var hapusIdSementara = null;

function tampilNotif(pesan, tipe) {
    var notif = document.getElementById("notif");
    notif.innerText = pesan;
    notif.style.display = "block";
    notif.style.backgroundColor = tipe === "sukses" ? "#28a745" : "#dc3545";
    setTimeout(function () {
        notif.style.display = "none";
    }, 2500);
}

function tampilKonfirmasi(pesan, id) {
    hapusIdSementara = id;
    document.getElementById("pesanKonfirmasi").innerText = pesan;
    document.getElementById("konfirmasi").style.display = "block";
}

function tutupKonfirmasi() {
    hapusIdSementara = null;
    document.getElementById("konfirmasi").style.display = "none";
}

function bukaFormTambah() {
    document.getElementById("overlay").style.display = "block";
    document.getElementById("modalTambah").style.display = "block";
}

function tutupSemua() {
    document.getElementById("overlay").style.display = "none";
    document.getElementById("modalTambah").style.display = "none";
    document.getElementById("modalEdit").style.display = "none";
}

function simpanTambah() {
    var csrf = document.querySelector('meta[name="csrf-token"]').content;
    var data = {
        nama_pembina: document.getElementById("tambahNama").value,
        nomor_handphone: document.getElementById("tambahHp").value,
        email: document.getElementById("tambahEmail").value,
        username: document.getElementById("tambahUsername").value,
        password: document.getElementById("tambahPassword").value,
    };

    fetch("/admin/tambah-pembina", {
        method: "POST",
        headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrf },
        body: JSON.stringify(data),
    })
        .then((res) => res.json())
        .then((data) => {
            if (data.success) {
                tutupSemua();
                tampilNotif("Pembina berhasil ditambahkan!", "sukses");
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                document.getElementById("pesanTambah").innerText = data.message;
            }
        });
}

function simpanEdit() {
    var csrf = document.querySelector('meta[name="csrf-token"]').content;
    var id = document.getElementById("editId").value;
    var nama = document.getElementById("editNama").value;
    var hp = document.getElementById("editHp").value;
    var email = document.getElementById("editEmail").value;

    fetch("/admin/edit-pembina/" + id, {
        method: "POST",
        headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrf },
        body: JSON.stringify({
            nama_pembina: nama,
            nomor_handphone: hp,
            email: email,
        }),
    })
        .then((res) => res.json())
        .then((data) => {
            if (data.success) {
                tutupSemua();
                tampilNotif("Data berhasil diperbarui!", "sukses");
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                tampilNotif(data.message, "gagal");
            }
        });
}

document.addEventListener("DOMContentLoaded", function () {
    var csrf = document.querySelector('meta[name="csrf-token"]').content;

    document.querySelectorAll(".btn-edit").forEach(function (btn) {
        btn.addEventListener("click", function () {
            document.getElementById("overlay").style.display = "block";
            document.getElementById("modalEdit").style.display = "block";
            document.getElementById("editId").value =
                this.getAttribute("data-id");
            document.getElementById("editNama").value =
                this.getAttribute("data-nama");
            document.getElementById("editHp").value =
                this.getAttribute("data-hp");
            document.getElementById("editEmail").value =
                this.getAttribute("data-email");
        });
    });

    document.querySelectorAll(".btn-hapus").forEach(function (btn) {
        btn.addEventListener("click", function () {
            tampilKonfirmasi(
                "Yakin ingin menghapus pembina ini?",
                this.getAttribute("data-id"),
            );
        });
    });

    document
        .getElementById("btnKonfirmasiYa")
        .addEventListener("click", function () {
            var id = hapusIdSementara;
            tutupKonfirmasi();
            if (!id) return;

            fetch("/admin/hapus-pembina/" + id, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrf,
                },
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.success) {
                        tampilNotif("Pembina berhasil dihapus!", "sukses");
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else {
                        tampilNotif(data.message, "gagal");
                    }
                });
        });
});
