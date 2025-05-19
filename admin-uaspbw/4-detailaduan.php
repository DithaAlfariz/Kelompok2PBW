<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aduan - Admin SiLapor!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/4-detail.css">
</head>
<body class="detailaduan">
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="#">SiLapor!</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="1-menuaduan.phpl" id="pengaduan-link">Aduan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="2-menupengumuman.php" id="history-link">Pengumuman</a>
                </li>
            </ul>
            <div class="dropdown">
                <a class="dropdown-toggle text-white d-flex align-items-center text-decoration-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="img/icons8-test-account-48.png" alt="Profile" class="rounded-circle me-2" width="30">
                    <span>Admin</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="3-kelolauser.php">
                            <img src="img/icons8-setting-24.png" alt="Setting Icon" class="me-2" width="20">
                            Kelola User
                        </a>
                    </li>
                    <li>
                        <a id="logoutBtn" class="dropdown-item d-flex align-items-center" href="#">
                            <img src="img/icons8-logout-24.png" alt="Setting Icon" class="me-2" width="20">
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<h2 class="fw-bold">Kelola Aduan</h2>
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
            <button type="button" class="btn btn-lampiran" data-bs-toggle="modal" data-bs-target="#lampiranModal"><i class="fas fa-file me-2"></i>
                Lihat Lampiran
            </button>
        </div>
    </div>

    <div class="modal fade" id="lampiranModal" tabindex="-1" aria-labelledby="lampiranModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lampiranModalLabel">Lampiran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div id="filePreview">
                        <p>Tidak ada lampiran untuk ditampilkan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="ppksOnly" style="display: none;">
        <p><strong>Tanggal Kejadian:</strong> <span id="tanggal"></span></p>
        <p><strong>Ciri-ciri Pelaku:</strong> <span id="ciri"></span></p>
        <p><strong>Bentuk Tindak Lanjut yang Diinginkan:</strong> <span id="tindakLanjut"></span></p>
    </div>
    <button class="export-btn">EXPORT</button>
    <hr>
    <h4 class="judul-edit">Feedback Admin</h4>
    <div class="custom-select mb-3">
        <label for="status"><strong>Status</strong></label>
        <select id="status">
          <option value="Diproses">Diproses</option>
          <option value="Selesai">Selesai</option>
        </select>
    </div>
      
    <div class="form-group mb-3">
        <label for="komentar"><strong>Tambahkan Deskripsi</strong></label>
        <textarea id="komentar" class="form-control" rows="3" placeholder="tambahkan komentar"></textarea>
    </div>
    
    <!-- Fitur Upload Foto -->
    <div class="mb-3">
        <label for="fileUpload" class="form-label"><strong>Upload Foto</strong></label>
        <input type="file" class="form-control" id="fileUpload" accept="image/*" onchange="previewImage(event)">
    </div>
    <div class="mb-3">
        <img id="uploadedImage" src="" alt="Uploaded Image" class="img-fluid" style="display: none; max-width: 100%;">
    </div>
    
    <div style="display: flex; justify-content: space-between; margin-top: 15px;">
        <button class="btn btn-secondary" style="margin-right: auto;" onclick="window.history.back()">Kembali</button>
        <div style="display: flex; gap: 10px;">
            <button class="btn btn-success" onclick="simpan()">Simpan</button> 
            <button class="btn btn-primary" onclick="kirim()">Kirim</button>
        </div>
    </div>



</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Ambil parameter dari URL
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id') || 1; // Gunakan id=1 jika tidak ada parameter id

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
    const data = dummyData[id] || {};

    // Isi konten halaman
    document.getElementById('kategorii').textContent = data.kategorii || "Tidak ditemukan";
    document.getElementById('nama').textContent = data.nama || "Tidak ditemukan";
    document.getElementById('npm').textContent = data.npm || "Tidak ditemukan";
    document.getElementById('telp').textContent = data.telp || "Tidak tersedia";
    document.getElementById('judul').textContent = data.judul || "Tidak ditemukan";
    document.getElementById('deskripsi').textContent = data.deskripsi || "Tidak ada deskripsi";
    document.getElementById('lokasi').textContent = data.lokasi || "Tidak ada lokasi";
    document.getElementById('status').value = data.status || "Belum ada status";
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

    // Preview Image Upload
    function previewImage(event) {
        const uploadedImage = document.getElementById('uploadedImage');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                uploadedImage.src = e.target.result;
                uploadedImage.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    }
    function simpan() {
        alert("Data berhasil disimpan!");
    }
    function kirim() {
        alert("Data berhasil dikirim!");
    }
    </script>
</script>
</body>
</html>
