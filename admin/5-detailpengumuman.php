<?php
include '../koneksi.php';

// Ambil parameter id pengumuman
$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Ambil data pengumuman + detail_history + history
$query = "SELECT 
            p.*, 
            d.status AS status_detail, 
            d.komentar AS komentar_detail, 
            h.nama, h.npm, h.kontak, h.judul, h.deskripsi, h.lokasi, h.kategori, h.tanggal AS tanggal_kejadian, h.pelaku, h.tindak_lanjut, h.bukti AS bukti_history
          FROM pengumuman p
          LEFT JOIN detail_history d ON p.id_history = d.id_history
          LEFT JOIN history h ON h.id = d.id_history
          WHERE p.id = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Bukti yang dipilih di pengumuman
$bukti_terpilih = $data['bukti'] ?? '';
// Bukti asli dari history
$bukti_history = $data['bukti_history'] ?? '';
$kategori = strtolower($data['kategori'] ?? '');

// Proses update jika form disimpan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);
    $bukti_terpilih_post = isset($_POST['bukti_terpilih']) ? mysqli_real_escape_string($conn, $_POST['bukti_terpilih']) : '';

    // Update detail_history
    $updateDetail = "UPDATE detail_history SET status='$status', komentar='$komentar' WHERE id_history=" . intval($data['id_history']);
    mysqli_query($conn, $updateDetail);

    // Update pengumuman
    $updatePengumuman = "UPDATE pengumuman SET status='$status', komentar='$komentar', bukti='$bukti_terpilih_post' WHERE id=" . intval($id);
    $resultPengumuman = mysqli_query($conn, $updatePengumuman);

    // Debug jika gagal
    if (!$resultPengumuman) {
        die("Gagal update pengumuman: " . mysqli_error($conn));
    }

    // Refresh data
    header("Location: 5-detailpengumuman.php?id=$id");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate">
    <title>Detail Pengumuman - Admin SiLapor!</title>
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
                    <a class="nav-link" href="1-menuaduan.php" id="pengaduan-link">Aduan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="2-menupengumuman.php" id="history-link">Pengumuman</a>
                </li>
            </ul>
            <div class="dropdown">
                <a class="dropdown-toggle text-white d-flex align-items-center text-decoration-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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

<h2 class="fw-bold">Detail Pengumuman</h2>
<div class="detail-container mt-6">
    <p><strong>Kategori:</strong> <span><?php echo htmlspecialchars($data['kategori'] ?? '-'); ?></span></p>
    <p><strong>Nama:</strong> <span><?php echo htmlspecialchars($data['nama'] ?? '-'); ?></span></p>
    <p><strong>NPM:</strong> <span><?php echo htmlspecialchars($data['npm'] ?? '-'); ?></span></p>
    <p><strong>No. Telepon:</strong> <span><?php echo htmlspecialchars($data['kontak'] ?? '-'); ?></span></p>
    <p><strong>Judul Aduan:</strong> <span><?php echo htmlspecialchars($data['judul'] ?? '-'); ?></span></p>
    <p><strong>Deskripsi:</strong> <span><?php echo htmlspecialchars($data['deskripsi'] ?? '-'); ?></span></p>
    <p><strong>Lokasi:</strong> <span><?php echo htmlspecialchars($data['lokasi'] ?? '-'); ?></span></p>
    <p><strong>Bukti Pendukung:</strong></p>
    <div class="mb-3">
        <div class="attachment-preview">
            <?php if (!empty($bukti_history)): ?>
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
                    <?php if (!empty($bukti_history)): ?>
                        <img src="../bukti/<?= $kategori ?>/<?= htmlspecialchars($bukti_history) ?>" alt="Lampiran" class="img-fluid mb-2" style="max-height:300px;<?= ($bukti_history == $bukti_terpilih) ? 'border:3px solid #007bff;' : '' ?>">
                        <?php if ($bukti_history == $bukti_terpilih): ?>
                            <div><span class="badge bg-primary">Bukti Utama</span></div>
                        <?php endif; ?>
                    <?php else: ?>
                        <p>Tidak ada lampiran untuk ditampilkan.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php if (strtolower($data['kategori'] ?? '') === "ppks"): ?>
    <div id="ppksOnly">
        <p><strong>Tanggal Kejadian:</strong> <span><?php echo htmlspecialchars($data['tanggal_kejadian'] ?? '-'); ?></span></p>
        <p><strong>Ciri-ciri Pelaku:</strong> <span><?php echo htmlspecialchars($data['pelaku'] ?? '-'); ?></span></p>
        <p><strong>Bentuk Tindak Lanjut yang Diinginkan:</strong> <span><?php echo htmlspecialchars($data['tindak_lanjut'] ?? '-'); ?></span></p>
    </div>
    <?php endif; ?>
    <button class="export-btn btn btn-warning mb-3" onclick="window.print()">EXPORT</button>
    <hr>
    <h4 class="judul-edit">Edit Pengumuman</h4>
    <form method="post">
        <div class="custom-select mb-3">
            <label for="status"><strong>Status</strong></label>
            <select id="status" name="status" class="form-select">
                <option value="Diproses" <?= ($data['status_detail'] ?? '') === 'Diproses' ? 'selected' : '' ?>>Diproses</option>
                <option value="Selesai" <?= ($data['status_detail'] ?? '') === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="komentar"><strong>Tambahkan Deskripsi</strong></label>
            <textarea id="komentar" name="komentar" class="form-control" rows="3" placeholder="tambahkan komentar"><?= htmlspecialchars($data['komentar_detail'] ?? '') ?></textarea>
        </div>
        <!-- Pilihan Foto Bukti -->
        <div class="mb-3">
            <label for="pilihBukti" class="form-label"><strong>Pilih Foto Bukti</strong></label>
            <select id="pilihBukti" name="bukti_terpilih" class="form-select" onchange="tampilkanBukti()">
                <option value="">-- Pilih Foto --</option>
                <?php if (!empty($bukti_history)): ?>
                    <option value="<?= htmlspecialchars($bukti_history) ?>" <?= ($bukti_history == $bukti_terpilih) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($bukti_history) ?>
                    </option>
                <?php endif; ?>
            </select>
        </div>
        <div class="mb-3">
            <?php if ($bukti_terpilih): ?>
                <img id="uploadedImage" src="../bukti/<?= $kategori ?>/<?= htmlspecialchars($bukti_terpilih) ?>" alt="Uploaded Image" class="img-fluid" style="max-width: 100%;">
            <?php else: ?>
                <img id="uploadedImage" src="" alt="Uploaded Image" class="img-fluid" style="display: none; max-width: 100%;">
            <?php endif; ?>
        </div>
        <div style="display: flex; justify-content: space-between; margin-top: 15px;">
            <button class="btn btn-secondary" style="margin-right: auto;" type="button" onclick="window.history.back()">Kembali</button>
            <button class="btn btn-success" name="simpan" type="submit">Simpan</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Preview Foto Bukti
    function tampilkanBukti() {
        const select = document.getElementById('pilihBukti');
        const img = document.getElementById('uploadedImage');
        const kategori = "<?= $kategori ?>";
        if (select.value) {
            img.src = "../bukti/" + kategori + "/" + select.value;
            img.style.display = "block";
        } else {
            img.style.display = "none";
        }
    }
</script>
</body>
</html>
