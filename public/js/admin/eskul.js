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

function previewFoto(input, previewId, labelId) {
    var preview = document.getElementById(previewId);
    var label = document.getElementById(labelId);
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = "block";
            label.innerText = input.files[0].name;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function simpanTambah() {
    var csrf = document.querySelector('meta[name="csrf-token"]').content;
    var formData = new FormData();
    formData.append("nama_ekskul", document.getElementById("tambahNama").value);
    formData.append(
        "id_pembina",
        document.getElementById("tambahPembina").value,
    );
    formData.append("jadwal", document.getElementById("tambahJadwal").value);
    formData.append(
        "deskripsi",
        document.getElementById("tambahDeskripsi").value,
    );

    var foto = document.getElementById("tambahFoto").files[0];
    var fotoKegiatan = document.getElementById("tambahFotoKegiatan").files[0];
    if (foto) formData.append("foto", foto);
    if (fotoKegiatan) formData.append("foto_kegiatan", fotoKegiatan);

    fetch("/admin/tambah-eskul", {
        method: "POST",
        headers: { "X-CSRF-TOKEN": csrf },
        body: formData,
    })
        .then((res) => res.json())
        .then((data) => {
            if (data.success) {
                tutupSemua();
                tampilNotif("Eskul berhasil ditambahkan!", "sukses");
                setTimeout(() => location.reload(), 1000);
            } else {
                document.getElementById("pesanTambah").innerText = data.message;
            }
        });
}

function simpanEdit() {
    var csrf = document.querySelector('meta[name="csrf-token"]').content;
    var id = document.getElementById("editId").value;
    var formData = new FormData();
    formData.append("nama_ekskul", document.getElementById("editNama").value);
    formData.append("id_pembina", document.getElementById("editPembina").value);
    formData.append("jadwal", document.getElementById("editJadwal").value);
    formData.append(
        "deskripsi",
        document.getElementById("editDeskripsi").value,
    );

    var foto = document.getElementById("editFoto").files[0];
    var fotoKegiatan = document.getElementById("editFotoKegiatan").files[0];
    if (foto) formData.append("foto", foto);
    if (fotoKegiatan) formData.append("foto_kegiatan", fotoKegiatan);

    fetch("/admin/edit-eskul/" + id, {
        method: "POST",
        headers: { "X-CSRF-TOKEN": csrf },
        body: formData,
    })
        .then((res) => res.json())
        .then((data) => {
            if (data.success) {
                tutupSemua();
                tampilNotif("Eskul berhasil diperbarui!", "sukses");
                setTimeout(() => location.reload(), 1000);
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
            document.getElementById("editPembina").value =
                this.getAttribute("data-id-pembina");
            document.getElementById("editJadwal").value =
                this.getAttribute("data-jadwal") || "";
            document.getElementById("editDeskripsi").value =
                this.getAttribute("data-deskripsi") || "";

            document.getElementById("editPreviewLogo").style.display = "none";
            document.getElementById("editPreviewKegiatan").style.display =
                "none";
            document.getElementById("editLabelLogo").innerText =
                "🖼️ Ganti Logo";
            document.getElementById("editLabelKegiatan").innerText =
                "📷 Ganti Foto";
            document.getElementById("editFoto").value = "";
            document.getElementById("editFotoKegiatan").value = "";
        });
    });

    document.querySelectorAll(".btn-hapus").forEach(function (btn) {
        btn.addEventListener("click", function () {
            tampilKonfirmasi(
                "Yakin ingin menghapus eskul ini?",
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
            fetch("/admin/hapus-eskul/" + id, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrf,
                },
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.success) {
                        tampilNotif("Eskul berhasil dihapus!", "sukses");
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        tampilNotif(data.message, "gagal");
                    }
                });
        });
});
