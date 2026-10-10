// Fungsi generik untuk mengambil & menampilkan data dari file JSON
async function muatDaftar(fileJson, daftarKunci) {
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");
    if (!tbody) return;

    loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        // simulasi delay jaringan agar loading indicator terlihat
        await new Promise((resolve) => setTimeout(resolve, 3000));

        const res = await fetch(fileJson);
        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }

        const daftarData = await res.json();

        daftarData.forEach(function (item) {
            const tr = document.createElement("tr");
            let selKolom = "";

            // Membuat kolom berdasarkan daftar nama kunci
            daftarKunci.forEach(function (kunci) {
                selKolom += "<td>" + item[kunci] + "</td>";
            });

            tr.innerHTML =
                selKolom +
                "<td>" +
                "<button type=\"button\">Edit</button> " +
                "<button type=\"button\" class=\"btn-hapus\">Hapus</button>" +
                "</td>";

            tbody.appendChild(tr);
        });
    } catch (err) {
        tbody.innerHTML =
            "<tr><td colspan=\"5\">Gagal memuat data: " + err.message + "</td></tr>";
    } finally {
        loading.style.display = "none";
    }
}

// Menampilkan data buku menggunakan fungsi generik
document.addEventListener("DOMContentLoaded", function () {
    muatDaftar(
    "../data/buku.json",
    ["judul", "pengarang", "tahun", "stok", "kategori"]
);
});