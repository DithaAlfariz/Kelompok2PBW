<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Histori</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
<?php include 'navbar.php'; ?>

<body>

<h1 class="judul-histori">DETAIL ADUAN</h1>

<div class="detail-container mt-6">
    <p><strong>Kategori:</strong> <span id="kategorii"></span></p>
    <p><strong>Nama:</strong> <span id="nama"></span></p>
    <p><strong>NPM:</strong> <span id="npm"></span></p>
    <p><strong>No. Telepon:</strong> <span id="telp"></span></p>
    <p><strong>Judul Aduan:</strong> <span id="judul"></span></p>
    <p><strong>Deskripsi:</strong> <span id="deskripsi"></span></p>
    <p><strong>Lokasi:</strong> <span id="lokasi"></span></p>
    <p><strong>Bukti Pendukung:</strong></p>
    <div class="mb-3">
        <div class="attachment-preview">
            <!-- Tombol lihat lampiran -->
            <button type="button" class="btn btn-lampiran" data-bs-toggle="modal" data-bs-target="#lampiranModal"><i class="fas fa-file me-2"></i>
                Lihat Lampiran
            </button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="lampiranModal" tabindex="-1" aria-labelledby="lampiranModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lampiranModalLabel">Lampiran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <!-- Placeholder untuk konten modal -->
                    <div id="filePreview">
                        <p>Tidak ada lampiran untuk ditampilkan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PPKS Only -->
    <div id="ppksOnly" style="display: none;">
        <p><strong>Tanggal Kejadian:</strong> <span id="tanggal"></span></p>
        <p><strong>Ciri-ciri Pelaku:</strong> <span id="ciri"></span></p>
        <p><strong>Bentuk Tindak Lanjut yang Diinginkan:</strong> <span id="tindakLanjut"></span></p>
    </div>

    <hr>
    <h4>Feedback Admin</h4>
    <p><strong>Status:</strong> <span id="status"></span></p>
    <p><strong>Komentar Admin:</strong> <span id="komentar"></span></p>
    <a href="historimhs.php" class="back-link">Kembali ke Histori</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Ambil parameter dari URL
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    // Contoh data untuk kategori PPKS
    const dummyData = {
        1: {
            kategorii: "PPKS",
            nama: "",
            npm: "",
            telp: "081234567890",
            judul: "Tindakan pelecehan verbal",
            deskripsi: "Saya mengalami pelecehan verbal saat berada di perpustakaan.",
            lokasi: "Perpustakaan Kampus A",
            lampiran: "",
            tanggal: "2025-05-10",
            ciri: "Pria, tinggi sekitar 170cm, memakai jaket hitam",
            tindakLanjut: "Pendampingan psikologis",
            status: "Diproses",
            komentar: "Kami sedang menyelidiki laporan Anda."
        },
        2: {
            kategorii: "Akademik",
            nama: "Jane Doe",
            npm: "87654321",
            telp: "082345678901",
            judul: "Permasalahan administrasi",
            deskripsi: "Kesalahan pada pengisian KRS.",
            lokasi: "Gedung Administrasi Kampus B",
            lampiran: "",
            status: "Diselesaikan",
            komentar: "Masalah Anda telah kami selesaikan."
        }
    };

    // Ambil data dari dummy berdasarkan ID
    const data = dummyData[1] || {};

    // Isi konten halaman
    document.getElementById('kategorii').textContent = data.kategorii || "Tidak ditemukan";
    document.getElementById('nama').textContent = data.nama || "Tidak ditemukan";
    document.getElementById('npm').textContent = data.npm || "Tidak ditemukan";
    document.getElementById('telp').textContent = data.telp || "Tidak tersedia";
    document.getElementById('judul').textContent = data.judul || "Tidak ditemukan";
    document.getElementById('deskripsi').textContent = data.deskripsi || "Tidak ada deskripsi";
    document.getElementById('lokasi').textContent = data.lokasi || "Tidak ada lokasi";
    document.getElementById('status').textContent = data.status || "Belum ada status";
    document.getElementById('komentar').textContent = data.komentar || "Belum ada komentar";

    // Lampiran
    const filePreview = document.getElementById('filePreview');
    if (data.lampiran) {
        const fileType = data.lampiran.split('.').pop().toLowerCase();
        if (['jpg', 'jpeg', 'png', 'gif'].includes(fileType)) {
            filePreview.innerHTML = `<img src="${data.lampiran}" alt="Lampiran" class="img-fluid">`;
        } else {
            filePreview.innerHTML = `<a href="${data.lampiran}" target="_blank" class="btn btn-secondary">Unduh Lampiran</a>`;
        }
    }

    // PPKS Only
    if (data.kategorii === "PPKS") {
        document.getElementById('ppksOnly').style.display = "block";
        document.getElementById('tanggal').textContent = data.tanggal || "Tidak ada tanggal";
        document.getElementById('ciri').textContent = data.ciri || "Tidak ada ciri pelaku";
        document.getElementById('tindakLanjut').textContent = data.tindakLanjut || "Tidak ada tindak lanjut";
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>