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

function editData(id, nama, kelas, hp) {
    document.getElementById("formEdit").style.display = "block";
    document.getElementById("editId").value = id;
    document.getElementById("editNama").value = nama;
    document.getElementById("editKelas").value = kelas;
    document.getElementById("editHp").value = hp;

    var select = document.getElementById("editKelas");
    select.value = kelas;

    if (select.value !== kelas) {
        select.value = "";
    }
}

function tutupEdit() {
    document.getElementById("formEdit").style.display = "none";
}

function simpanEdit() {
    var id = document.getElementById("editId").value;
    var nama = document.getElementById("editNama").value.trim();
    var kelas = document.getElementById("editKelas").value;
    var hp = document.getElementById("editHp").value.trim();
    var csrf = document.querySelector('meta[name="csrf-token"]').content;

    if (!/^[a-zA-Z\s]+$/.test(nama)) {
        tampilNotif("Nama hanya boleh berisi huruf!", "gagal");
        return;
    }

    if (nama.length < 3 || nama.length > 100) {
        tampilNotif("Nama harus 3-100 karakter!", "gagal");
        return;
    }

    if (kelas === "") {
        tampilNotif("Silakan pilih kelas!", "gagal");
        return;
    }

    hp = hp.replace(/[-\s]/g, "");

    if (!/^[0-9]+$/.test(hp)) {
        tampilNotif("Nomor HP hanya boleh berisi angka!", "gagal");
        return;
    }

    if (hp.length < 10 || hp.length > 13) {
        tampilNotif("Nomor HP harus 10-13 digit!", "gagal");
        return;
    }

    fetch("/edit-siswa/" + id, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrf,
        },
        body: JSON.stringify({
            nama_lengkap: nama,
            kelas_jurusan: kelas,
            nomor_handphone: hp,
        }),
    })
        .then((res) => res.json())
        .then((data) => {
            if (data.success) {
                tutupEdit();
                tampilNotif("Data berhasil diperbarui!", "sukses");
                setTimeout(() => location.reload(), 1000);
            } else {
                tampilNotif(data.message, "gagal");
            }
        });
}

function hapusData(id_siswa) {
    tampilKonfirmasi("Yakin ingin menghapus pendaftaran siswa ini?", id_siswa);
}

function toggleDropdown() {
    const menu = document.getElementById("dropdownMenu");
    const btn = document.querySelector(".btn-dropdown");
    const rect = btn.getBoundingClientRect();

    menu.style.top = rect.bottom + 6 + "px";
    menu.style.left = rect.left + "px";

    menu.classList.toggle("open");
}

function tutupDropdown() {
    const menu = document.getElementById("dropdownMenu");
    if (menu) menu.classList.remove("open");
}

function filterTabel() {
    const keyword = document.getElementById("searchInput").value.toLowerCase();
    const rows = document.querySelectorAll("table tr:not(:first-child)");

    rows.forEach(function (row) {
        const nama = row.cells[1] ? row.cells[1].innerText.toLowerCase() : "";
        const kelas = row.cells[2] ? row.cells[2].innerText.toLowerCase() : "";
        const hp = row.cells[3] ? row.cells[3].innerText.toLowerCase() : "";

        if (
            nama.includes(keyword) ||
            kelas.includes(keyword) ||
            hp.includes(keyword)
        ) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById("btnKonfirmasiYa")
        .addEventListener("click", function () {
            var id = hapusIdSementara;
            var csrf = document.querySelector(
                'meta[name="csrf-token"]',
            ).content;
            tutupKonfirmasi();
            if (!id) return;

            fetch("/hapus-siswa/" + id, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrf,
                },
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.success) {
                        tampilNotif("Data berhasil dihapus!", "sukses");
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else {
                        tampilNotif(data.message, "gagal");
                    }
                });
        });

    document.addEventListener("click", function (e) {
        const wrapper = document.querySelector(".dropdown-wrapper");
        if (wrapper && !wrapper.contains(e.target)) {
            tutupDropdown();
        }
    });
});
