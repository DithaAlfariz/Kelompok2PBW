<?php
include '../koneksi.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;

$id = $_GET['id'] ?? '';
if (!$id || !is_numeric($id) || $id == 0) {
    echo "<script>alert('ID tidak valid');window.location='2-menupengumuman.php';</script>";
    exit;
}

// Ambil data pengumuman dan join ke history untuk detail pelapor
$q = mysqli_query($conn, "SELECT p.*, h.nama, h.npm, h.kontak, h.judul, h.deskripsi, h.lokasi, h.created_at, h.bukti, h.kategori, h.tanggal, h.pelaku, h.tindak_lanjut
    FROM pengumuman p
    LEFT JOIN history h ON p.id_history = h.id_pengaduan
    WHERE p.id = '$id' LIMIT 1");
$data = mysqli_fetch_assoc($q);

if (!$data) {
    echo "<script>alert('Data tidak ditemukan');window.location='2-menupengumuman.php';</script>";
    exit;
}

$kategori_folder = strtolower($data['kategori']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengumuman - SiLapor!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/4-detail.css">
</head>
<body class="detailaduan">
<?php include '../navadmin.php'; ?>

<h2 class="fw-bold">Detail Pengumuman</h2>
<div class="detail-container mt-6 mb-3">
    <p><strong>Kategori:</strong> <?= htmlspecialchars(ucfirst($data['kategori'])) ?></p>
    <p><strong>Nama:</strong> <?= htmlspecialchars($data['nama'] ?? '-') ?></p>
    <p><strong>NPM:</strong> <?= htmlspecialchars($data['npm'] ?? '-') ?></p>
    <p><strong>No. Telepon:</strong> <?= htmlspecialchars($data['kontak'] ?? '-') ?></p>
    <p><strong>Judul Aduan:</strong> <?= htmlspecialchars($data['judul'] ?? '-') ?></p>
    <p><strong>Deskripsi:</strong> <?= nl2br(htmlspecialchars($data['deskripsi'] ?? '-')) ?></p>
    <p><strong>Lokasi:</strong> <?= htmlspecialchars($data['lokasi'] ?? '-') ?></p>
    <p><strong>Tanggal Pengaduan:</strong> <?= !empty($data['created_at']) ? date('d-m-Y', strtotime($data['created_at'])) : '-' ?></p>
    <p><strong>Bukti Pendukung:</strong>
        <?php if (!empty($data['bukti'])): ?>
            <a href="bukti/<?= $kategori_folder ?>/<?= htmlspecialchars($data['bukti']) ?>" target="_blank" class="btn btn-lampiran">
                <i class="fas fa-file me-2"></i>Lihat Lampiran
            </a>
            <br>
            <img src="bukti/<?= $kategori_folder ?>/<?= htmlspecialchars($data['bukti']) ?>" alt="Bukti" style="max-width:200px;max-height:120px;margin-top:8px;">
        <?php else: ?>
            Tidak ada lampiran
        <?php endif; ?>
    </p>

    <?php if (strtolower($data['kategori']) === 'ppks'): ?>
        <p><strong>Tanggal Kejadian:</strong> <?= !empty($data['tanggal']) ? date('d-m-Y', strtotime($data['tanggal'])) : '-' ?></p>
        <p><strong>Ciri-ciri Pelaku:</strong> <?= htmlspecialchars($data['pelaku'] ?? '-') ?></p>
        <p><strong>Bentuk Tindak Lanjut yang Diinginkan:</strong> <?= htmlspecialchars($data['tindak_lanjut'] ?? '-') ?></p>
    <?php endif; ?>

    <hr>
    <div class="announcement-status">
        <span class="status-label">Status:</span>
        <span class="status-value <?= ($data['status'] == 'Diproses') ? 'status-process' : 'status-done'; ?>">
            <?= htmlspecialchars($data['status']); ?>
        </span>
    </div>
    <p class="announcement-desc">
        <?= htmlspecialchars($data['komentar']); ?>
    </p>
    <a href="2-menupengumuman.php" class="btn btn-secondary mt-2">Kembali ke Pengumuman</a>
</div>

<div class="container">
    <div class="row">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM pengumuman WHERE id_user = '$user_id' ORDER BY created_at DESC");
        while($row = $result->fetch_assoc()):
        ?>
        <div class="col-md-4 mb-4">
            <a href="5-detailpengumuman.php?id=<?= $row['id']; ?>" style="text-decoration:none;color:inherit;">
                <div class="announcement-card h-100" style="cursor:pointer; position:relative;">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($row['judul']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($row['kategori']) ?> | Diterbitkan: <?= date('d-m-Y', strtotime($row['tanggal'])) ?></p>
                        <p class="card-text"><strong>Status:</strong> <?= htmlspecialchars($row['status']) ?></p>
                        <p class="card-text"><?= htmlspecialchars($row['komentar']) ?></p>
                    </div>
                </div>
            </a>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>