function cetakPDF() {
    var { jsPDF } = window.jspdf;
    var doc = new jsPDF("l", "mm", "a4");

    var judul = document.querySelector("h1, .topbar h1, .card-header h2");
    var titleText = judul ? judul.innerText : "Data Siswa";

    var tabel = document.querySelector(".card-body table, .container table");

    html2canvas(tabel, { scale: 2 }).then(function (canvas) {
        var imgData = canvas.toDataURL("image/png");

        doc.setFontSize(14);
        doc.setFont("helvetica", "bold");
        doc.text(titleText, 148, 15, { align: "center" });

        doc.setFontSize(10);
        doc.setFont("helvetica", "normal");
        var tanggal = new Date().toLocaleDateString("id-ID", {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric",
        });
        doc.text("Dicetak pada: " + tanggal, 148, 22, { align: "center" });

        var imgWidth = 280;
        var imgHeight = (canvas.height * imgWidth) / canvas.width;
        doc.addImage(imgData, "PNG", 8, 28, imgWidth, imgHeight);

        doc.save(titleText.replace(/\s+/g, "_") + ".pdf");
    });
}

function cetakPNG() {
    var tabel = document.querySelector(".card-body table, .container table");
    var judul = document.querySelector("h1, .topbar h1, .card-header h2");
    var titleText = judul ? judul.innerText : "Data Siswa";

    html2canvas(tabel, { scale: 2 }).then(function (canvas) {
        var link = document.createElement("a");
        link.download = titleText.replace(/\s+/g, "_") + ".png";
        link.href = canvas.toDataURL("image/png");
        link.click();
    });
}
