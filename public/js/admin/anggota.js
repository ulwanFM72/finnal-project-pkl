var hapusIdSementara = null;
var hapusEskulSementara = null;

function tampilNotif(pesan, tipe) {
    var notif = document.getElementById("notif");
    notif.innerText = pesan;
    notif.style.display = "block";
    notif.style.backgroundColor = tipe === "sukses" ? "#28a745" : "#dc3545";
    setTimeout(function () {
        notif.style.display = "none";
    }, 2500);
}

function tampilKonfirmasi(pesan, id_siswa, id_ekskul) {
    hapusIdSementara = id_siswa;
    hapusEskulSementara = id_ekskul;
    document.getElementById("pesanKonfirmasi").innerText = pesan;
    document.getElementById("konfirmasi").style.display = "block";
}

function tutupKonfirmasi() {
    hapusIdSementara = null;
    hapusEskulSementara = null;
    document.getElementById("konfirmasi").style.display = "none";
}

function tutupSemua() {
    document.getElementById("overlay").style.display = "none";
    document.getElementById("modalEdit").style.display = "none";
}

function simpanEdit() {
    var csrf = document.querySelector('meta[name="csrf-token"]').content;
    var id = document.getElementById("editId").value;
    var nama = document.getElementById("editNama").value;
    var kelas = document.getElementById("editKelas").value;
    var hp = document.getElementById("editHp").value;

    fetch("/admin/edit-anggota/" + id, {
        method: "POST",
        headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrf },
        body: JSON.stringify({
            nama_lengkap: nama,
            kelas_jurusan: kelas,
            nomor_handphone: hp,
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

            var kelas = this.getAttribute("data-kelas");
            var select = document.getElementById("editKelas");
            select.value = kelas;

            if (select.value !== kelas) {
                select.value = "";
            }
        });
    });

    document.querySelectorAll(".btn-hapus").forEach(function (btn) {
        btn.addEventListener("click", function () {
            tampilKonfirmasi(
                "Yakin ingin menghapus anggota ini dari eskul?",
                this.getAttribute("data-id-siswa"),
                this.getAttribute("data-id-ekskul"),
            );
        });
    });

    document
        .getElementById("btnKonfirmasiYa")
        .addEventListener("click", function () {
            var id_siswa = hapusIdSementara;
            var id_ekskul = hapusEskulSementara;
            tutupKonfirmasi();
            if (!id_siswa || !id_ekskul) return;

            fetch("/admin/hapus-anggota/" + id_siswa + "/" + id_ekskul, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrf,
                },
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.success) {
                        tampilNotif("Anggota berhasil dihapus!", "sukses");
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else {
                        tampilNotif(data.message, "gagal");
                    }
                });
        });
});
