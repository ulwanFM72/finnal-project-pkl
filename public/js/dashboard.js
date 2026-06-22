function tampilNotif(pesan, tipe) {
    var notif = document.getElementById("notif");
    notif.innerText = pesan;
    notif.style.display = "block";
    notif.style.backgroundColor = tipe === "sukses" ? "#28a745" : "#dc3545";
    setTimeout(function () {
        notif.style.display = "none";
    }, 2500);
}

function bukaForm(idEskul, namaEskul, fotoEskul, jadwal) {
    document.getElementById("formDaftar").style.display = "block";
    document.getElementById("overlay").style.display = "block";
    document.getElementById("idEskul").value = idEskul;
    document.getElementById("namaEskul").value = namaEskul;
    document.getElementById("namaEskulText").innerText = namaEskul;
    document.getElementById("fotoEskul").src = fotoEskul;
    document.getElementById("jadwalEskulText").innerHTML = jadwal.replace(
        /\\n/g,
        "<br>",
    );
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
        .catch(() => {
            tampilNotif("Terjadi kesalahan!", "gagal");
        });
}

(function () {
    const track = document.getElementById("eskulSliderTrack");
    const dotsEl = document.getElementById("eskulDots");
    if (!track) return;

    const original = Array.from(track.querySelectorAll(".eskul-slide"));
    const total = original.length;
    if (total === 0) return;

    original.forEach((s) => {
        track.appendChild(s.cloneNode(true));
    });
    original.forEach((s) => {
        track.insertBefore(s.cloneNode(true), track.firstChild);
    });

    let cur = total;
    let locked = false;

    track.style.transition = "none";
    track.style.transform = `translateX(-${cur * 100}%)`;

    original.forEach((_, i) => {
        const dot = document.createElement("button");
        dot.className = "slider-dot" + (i === 0 ? " active" : "");
        dot.setAttribute("aria-label", "Slide " + (i + 1));
        dot.onclick = () => {
            if (locked) return;
            const target = total + i;
            animateTo(target);
        };
        dotsEl.appendChild(dot);
    });

    function updateDots() {
        const real = ((cur % total) + total) % total;
        document
            .querySelectorAll(".slider-dot")
            .forEach((d, i) => d.classList.toggle("active", i === real));
    }

    function animateTo(idx) {
        locked = true;
        track.style.transition = "transform 0.4s cubic-bezier(0.4, 0, 0.2, 1)";
        track.style.transform = `translateX(-${idx * 100}%)`;
        cur = idx;
        updateDots();

        setTimeout(() => {
            track.style.transition = "none";

            if (cur >= total * 2) {
                cur = cur - total;
                track.style.transform = `translateX(-${cur * 100}%)`;
            } else if (cur < total) {
                cur = cur + total;
                track.style.transform = `translateX(-${cur * 100}%)`;
            }

            locked = false;
        }, 420);
    }

    window.eskulMove = function (dir) {
        if (locked) return;
        animateTo(cur + dir);
    };

    window.eskulGoTo = function (idx) {
        if (locked) return;
        animateTo(total + idx);
    };

    const viewport = track.parentElement;

    viewport.addEventListener("click", (e) => {
        const rect = viewport.getBoundingClientRect();
        const clickX = e.clientX - rect.left;
        const half = rect.width / 2;

        if (clickX < half) {
            eskulMove(-1);
        } else {
            eskulMove(1);
        }
    });

    let startX = 0;
    viewport.addEventListener(
        "touchstart",
        (e) => {
            startX = e.touches[0].clientX;
        },
        { passive: true },
    );

    viewport.addEventListener(
        "touchend",
        (e) => {
            const diff = startX - e.changedTouches[0].clientX;
            if (Math.abs(diff) > 40) {
                eskulMove(diff > 0 ? 1 : -1);
            }
        },
        { passive: true },
    );
})();
