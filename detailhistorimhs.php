<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$user_id = $_SESSION['user_id'];
$id = $_GET['id'] ?? '';
$kategori = $_GET['kategori'] ?? '';
$data = null;
// Update query untuk join dengan detail_history
$q = mysqli_query($conn, "SELECT h.*, d.status, d.komentar 
                         FROM history h 
                         LEFT JOIN detail_history d ON h.id_pengaduan = d.id_history 
                         WHERE h.id_pengaduan='$id' AND h.user_id='$user_id' AND h.kategori='$kategori'");
$data = mysqli_fetch_assoc($q);

if (!$data) {
    echo "<script>alert('Data tidak ditemukan');window.location='historimhs.php';</script>";
    exit;
}
?>
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

<div class="detail-container mt-6 mb-3">
    <p><strong>Kategori:</strong> <?= htmlspecialchars(ucfirst($kategori)) ?></p>
    <p><strong>Nama:</strong> <?= htmlspecialchars($data['nama'] ?? '-') ?></p>
    <p><strong>NPM:</strong> <?= htmlspecialchars($data['npm'] ?? '-') ?></p>
    <p><strong>No. Telepon:</strong> <?= htmlspecialchars($data['kontak'] ?? '-') ?></p>
    <p><strong>Judul Aduan:</strong> <?= htmlspecialchars($data['judul'] ?? '-') ?></p>
    <p><strong>Deskripsi:</strong> <?= nl2br(htmlspecialchars($data['deskripsi'] ?? '-')) ?></p>
    <p><strong>Lokasi:</strong> <?= htmlspecialchars($data['lokasi'] ?? '-') ?></p>
    <p><strong>Tanggal Pengaduan:</strong> <?= date('d-m-Y', strtotime($data['created_at'])) ?></p>
    <p><strong>Bukti Pendukung:</strong>
        <?php if (!empty($data['bukti'])): ?>
            <?php $kategori_folder = strtolower($data['kategori']); ?>
            <a href="bukti/<?= $kategori_folder ?>/<?= htmlspecialchars($data['bukti']) ?>" target="_blank" class="btn btn-lampiran">
                <i class="fas fa-file me-2"></i>Lihat Lampiran
            </a>
            <br>
            <img src="bukti/<?= $kategori_folder ?>/<?= htmlspecialchars($data['bukti']) ?>" alt="Bukti" style="max-width:200px;max-height:120px;margin-top:8px;">
        <?php else: ?>
            Tidak ada lampiran
        <?php endif; ?>
    </p>

    <?php if ($kategori == 'ppks'): ?>
        <p><strong>Tanggal Kejadian:</strong> <?= date('d-m-Y', strtotime($data['tanggal'])) ?></p>
        <p><strong>Ciri-ciri Pelaku:</strong> <?= htmlspecialchars($data['pelaku'] ?? '-') ?></p>
        <p><strong>Bentuk Tindak Lanjut yang Diinginkan:</strong> <?= htmlspecialchars($data['tindak_lanjut'] ?? '-') ?></p>
    <?php endif; ?>

    <!-- Tampilkan feedback admin jika ada -->
    <?php if (!empty($data['status']) || !empty($data['komentar'])): ?>
    <hr>
    <div class="feedback-section">
        <h4>Feedback Admin</h4>
        <p><strong>Status:</strong> <span class="badge bg-status"><?= htmlspecialchars($data['status'] ?? '-') ?></span></p>
        <p><strong>Komentar Admin:</strong> <?= nl2br(htmlspecialchars($data['komentar'] ?? '-')) ?></p>
    </div>
    <?php endif; ?>
    
    <a href="historimhs.php" class="back-link">Kembali ke Histori</a>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>