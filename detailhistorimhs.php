<?php
include 'koneksi.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$query = "SELECT h.*, d.*, h.bukti 
          FROM history h 
          LEFT JOIN detail_history d ON h.id = d.id_history 
          WHERE h.id = $id
          ORDER BY h.created_at DESC";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<div class='alert alert-danger mt-4'>Data tidak ditemukan atau ID tidak valid.</div>";
    exit;
}

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
    <title>Detail Histori</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
<?php include 'navbar.php'; ?>

<body class="detail-histori">

<h1 class="judul-histori">DETAIL ADUAN</h1>

<div class="detail-container mt-6 mb-3">
    <p><strong>Kategori:</strong> <?= htmlspecialchars($data['kategori'] ?? '') ?></p>
    <p><strong>Nama:</strong> <?= htmlspecialchars($data['nama'] ?? '') ?></p>
    <p><strong>NPM:</strong> <?= htmlspecialchars($data['npm'] ?? '') ?></p>
    <p><strong>No. Telepon:</strong> <?= htmlspecialchars($data['kontak'] ?? '') ?></p>
    <p><strong>Judul Aduan:</strong> <?= htmlspecialchars($data['judul'] ?? '') ?></p>
    <p><strong>Deskripsi:</strong> <?= htmlspecialchars($data['deskripsi'] ?? '') ?></p>
    <p><strong>Lokasi:</strong> <?= htmlspecialchars($data['lokasi'] ?? '') ?></p>
    <p><strong>Bukti Pendukung:</strong></p>
    <div class="mb-3">
        <div class="attachment-preview">
            <!-- Tombol lihat lampiran -->
            <?php if (!empty($data['bukti'])): ?>
            <button type="button" class="btn btn-lampiran" data-bs-toggle="modal" data-bs-target="#lampiranModal">
                <i class="fas fa-file me-2"></i>Lihat Lampiran
            </button>
            <?php else: ?>
            <span class="text-muted">Tidak ada lampiran</span>
            <?php endif; ?>
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
                    <?php
                        if (!empty($bukti_files)):
                            $kategori = strtolower($data['kategori'] ?? '');
                            $folder = 'bukti/' . $kategori;
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

    <!-- PPKS Only -->
    <?php if (($data['kategori']) === 'ppks'): ?>
    <div id="ppksOnly">
        <p><strong>Tanggal Kejadian:</strong> <?= htmlspecialchars($data['tanggal'] ?? 'Tidak ada tanggal') ?></p>
        <p><strong>Ciri-ciri Pelaku:</strong> <?= htmlspecialchars($data['pelaku'] ?? 'Tidak ada ciri pelaku') ?></p>
        <p><strong>Bentuk Tindak Lanjut yang Diinginkan:</strong> <?= htmlspecialchars($data['tindak_lanjut'] ?? 'Tidak ada tindak lanjut') ?></p>
    </div>
    <?php endif; ?>

    <hr>
    <h4>Feedback Admin</h4>
    <p><strong>Status:</strong> <span class="status-value status-process"><?= htmlspecialchars($data['status'] ?? '') ?></span></p>
    <p><strong>Komentar Admin:</strong> <span><?= htmlspecialchars($data['komentar'] ?? '') ?></span></p>
    <a href="historimhs.php" class="back-link">Kembali ke Histori</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Hapus script JS yang tidak digunakan karena sudah pakai PHP -->
</body>
</html>