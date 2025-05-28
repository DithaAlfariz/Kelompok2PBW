<?php
// Tambahkan koneksi ke database
include '../koneksi.php';

// Ambil parameter id dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Proses simpan status & komentar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);
    $bukti_terpilih = isset($_POST['bukti_terpilih']) ? mysqli_real_escape_string($conn, $_POST['bukti_terpilih']) : '';

    // Update tabel detail_history
    $update = "UPDATE detail_history SET status ='$status', komentar='$komentar' WHERE id_history=$id";
    mysqli_query($conn, $update);

    // Cek apakah id_history sudah ada di tabel pengumuman
    $cek = mysqli_query($conn, "SELECT id FROM pengumuman WHERE id_history = $id");
    if (mysqli_num_rows($cek) > 0) {
        // Ambil data terbaru dari detail_history untuk update pengumuman
        $query = "SELECT h.*, d.* 
                  FROM history h 
                  LEFT JOIN detail_history d ON h.id = d.id_history 
                  WHERE h.id = $id";
        $result = mysqli_query($conn, $query);
        $aduan = mysqli_fetch_assoc($result);

        $judul = mysqli_real_escape_string($conn, $aduan['judul']);
        $kategori = mysqli_real_escape_string($conn, $aduan['kategori']);
        $tanggal = mysqli_real_escape_string($conn, $aduan['created_at']);
        $status_pengumuman = mysqli_real_escape_string($conn, $aduan['status']);
        $komentar_pengumuman = mysqli_real_escape_string($conn, $aduan['komentar']);
        // Update data di tabel pengumuman
        $updatePengumuman = "UPDATE pengumuman 
                             SET judul='$judul', kategori='$kategori', tanggal='$tanggal', status='$status_pengumuman', komentar='$komentar_pengumuman', bukti='$bukti_terpilih'
                             WHERE id_history=$id";
        mysqli_query($conn, $updatePengumuman);
    }

    // Refresh data
    header("Location: 1-menuaduan.php");
    exit;
}

// Proses kirim (update pengumuman jadi aktif & simpan ke tabel pengumuman)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kirim'])) {
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);
    $bukti_terpilih = isset($_POST['bukti_terpilih']) ? mysqli_real_escape_string($conn, $_POST['bukti_terpilih']) : '';

    // Cek apakah id_history sudah ada di tabel pengumuman
    $cek = mysqli_query($conn, "SELECT id FROM pengumuman WHERE id_history = $id");
    if (mysqli_num_rows($cek) > 0) {
        // Sudah ada, tampilkan pesan error (bisa pakai alert atau variabel PHP)
        echo "<script>alert('Pengumuman untuk aduan ini sudah pernah dikirim!');</script>";
    } else {
        $update = "UPDATE detail_history SET status ='$status', komentar='$komentar', pengumuman='aktif' WHERE id_history=$id";
        mysqli_query($conn, $update);

        // Ambil data lengkap aduan
        $query = "SELECT h.*, d.* 
                  FROM history h 
                  LEFT JOIN detail_history d ON h.id = d.id_history 
                  WHERE h.id = $id";
        $result = mysqli_query($conn, $query);
        $aduan = mysqli_fetch_assoc($result);

        // Simpan ke tabel pengumuman
        $judul = mysqli_real_escape_string($conn, $aduan['judul']);
        $kategori = mysqli_real_escape_string($conn, $aduan['kategori']);
        $tanggal = mysqli_real_escape_string($conn, $aduan['created_at']);
        $status = mysqli_real_escape_string($conn, $aduan['status']);
        $komentar = mysqli_real_escape_string($conn, $aduan['komentar']);

        $insertPengumuman = "INSERT INTO pengumuman (id_history, judul, kategori, tanggal, status, komentar, bukti)
                             VALUES ($id, '$judul', '$kategori', '$tanggal', '$status', '$komentar', '$bukti_terpilih')";
        mysqli_query($conn, $insertPengumuman);

        // Redirect atau tampilkan pesan sukses
        header("Location: 1-menuaduan.php");
        exit;
    }
}

// Query LEFT JOIN history dan detail_history
$query = "SELECT h.*, d.* 
          FROM history h 
          LEFT JOIN detail_history d ON h.id = d.id_history 
          WHERE h.id = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Ambil array bukti jika ada beberapa file (misal dipisah koma)
$bukti_files = [];
if (!empty($data['bukti'])) {
    $bukti_files = array_map('trim', explode(',', $data['bukti']));
}
?>
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
                    <a class="nav-link active" href="1-menuaduan.php" id="pengaduan-link">Aduan</a>
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
    <p><strong>Kategori:</strong> <span id="kategori"><?php echo htmlspecialchars($data['kategori'] ?? '-'); ?></span></p>
    <p><strong>Nama:</strong> <span id="nama"><?php echo htmlspecialchars($data['nama'] ?? '-'); ?></span></p>
    <p><strong>NPM:</strong> <span id="npm"><?php echo htmlspecialchars($data['npm'] ?? '-'); ?></span></p>
    <p><strong>No. Telepon:</strong> <span id="telp"><?php echo htmlspecialchars($data['kontak'] ?? '-'); ?></span></p>
    <p><strong>Judul Aduan:</strong> <span id="judul"><?php echo htmlspecialchars($data['judul'] ?? '-'); ?></span></p>
    <p><strong>Deskripsi:</strong> <span id="deskripsi"><?php echo htmlspecialchars($data['deskripsi'] ?? '-'); ?></span></p>
    <p><strong>Lokasi:</strong> <span id="lokasi"><?php echo htmlspecialchars($data['lokasi'] ?? '-'); ?></span></p>
    <p><strong>Bukti Pendukung:</strong></p>
    <div class="mb-3">
        <div class="attachment-preview">
            <?php if (!empty($bukti_files)): ?>
                <button type="button" class="btn btn-lampiran" data-bs-toggle="modal" data-bs-target="#lampiranModal"><i class="fas fa-file me-2"></i>
                    Lihat Lampiran
                </button>
            <?php else: ?>
                <span>Tidak ada lampiran</span>
            <?php endif; ?>
        </div>
    </div>
    <!-- Modal Lampiran -->
    <div class="modal fade" id="lampiranModal" tabindex="-1" aria-labelledby="lampiranModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lampiranModalLabel">Lampiran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <?php
                        if (!empty($bukti_files)):
                            $kategori = strtolower($data['kategori'] ?? '');
                            $folder = '../bukti/' . $kategori;
                            foreach ($bukti_files as $file):
                                if (trim($file) !== ''):
                    ?>
                <img src="<?= $folder ?>/<?= htmlspecialchars($file) ?>" alt="Lampiran" class="img-fluid mb-2 me-2" style="max-height:300px;">
                    <?php
                                endif;
                            endforeach;
                        else:
                    ?>
                        <p>Tidak ada lampiran untuk ditampilkan.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php if (strtolower($data['kategori'] ?? '') === "ppks"): ?>
    <div id="ppksOnly">
        <p><strong>Tanggal Kejadian:</strong> <span id="tanggal"><?php echo htmlspecialchars($data['tanggal'] ?? '-'); ?></span></p>
        <p><strong>Ciri-ciri Pelaku:</strong> <span id="pelaku"><?php echo htmlspecialchars($data['pelaku'] ?? '-'); ?></span></p>
        <p><strong>Bentuk Tindak Lanjut yang Diinginkan:</strong> <span id="tindak_lanjut"><?php echo htmlspecialchars($data['tindak_lanjut'] ?? '-'); ?></span></p>
    </div>
    <?php endif; ?>
    <a href="download_aduan_pdf.php?kategori=<?= $kategori ?>&id=<?= $data['id_pengaduan'] ?>" class="btn btn-primary mb-2" target="_blank">
            <i class="fas fa-download"></i> Export
    </a>
    <hr>
    <h4 class="judul-edit">Feedback Admin</h4>
    <form method="post">
        <div class="custom-select mb-3">
            <label for="status"><strong>Status</strong></label>
            <select id="status" name="status" class="form-select">
                <option value="Diproses" <?= ($data['status'] ?? '') === 'Diproses' ? 'selected' : '' ?>>Diproses</option>
                <option value="Selesai" <?= ($data['status'] ?? '') === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="komentar"><strong>Tambahkan Komentar</strong></label>
            <textarea id="komentar" name="komentar" class="form-control" rows="3" placeholder="tambahkan komentar"><?= htmlspecialchars($data['komentar_admin'] ?? '') ?></textarea>
        </div>
        <!-- Pilihan Foto Bukti -->
        <div class="mb-3">
            <label for="pilihBukti" class="form-label"><strong>Pilih Foto Bukti</strong></label>
            <select id="pilihBukti" class="form-select" onchange="tampilkanBukti()">
                <option value="">-- Pilih Foto --</option>
                <?php foreach ($bukti_files as $file): ?>
                    <option value="<?= $folder ?>/<?= htmlspecialchars($file) ?>"><?= htmlspecialchars($file) ?></option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="bukti_terpilih" id="bukti_terpilih" value="">
        </div>
        <div class="mb-3">
            <img id="uploadedImage" src="" alt="Uploaded Image" class="img-fluid" style="display: none; max-width: 100%;">
        </div>
        <div style="display: flex; justify-content: space-between; margin-top: 15px;">
            <button class="btn btn-secondary" style="margin-right: auto;" type="button" onclick="window.history.back()">Kembali</button>
            <div style="display: flex; gap: 10px;">
                <button class="btn btn-success" name="simpan" type="submit">Simpan</button>
                <button class="btn btn-primary" name="kirim" type="submit">Kirim</button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Preview Foto Bukti & set hidden input
    function tampilkanBukti() {
        const select = document.getElementById('pilihBukti');
        const img = document.getElementById('uploadedImage');
        const hidden = document.getElementById('bukti_terpilih');
        if (select.value) {
            img.src = select.value;
            img.style.display = "block";
            hidden.value = select.value.split('/').pop(); // hanya nama file
        } else {
            img.style.display = "none";
            hidden.value = "";
        }
    }
</script>
</body>
</html>
