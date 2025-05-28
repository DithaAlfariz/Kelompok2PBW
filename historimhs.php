<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History - SiLapor!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsif.css">
</head>
<body class="min-vh-100 d-flex flex-column">
    
<?php include 'navbar.php'; ?>

<h1 class="judul-histori">HISTORI ADUAN</h1>

<div class="container list-histori mt-4">
<?php
// Ambil data dari tabel history, gunakan id_pengaduan sebagai primary key
$query = "SELECT id, judul, kategori, created_at FROM history WHERE user_id='$user_id' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

$aduan = [];
while ($row = mysqli_fetch_assoc($result)) $aduan[] = $row;
?>
<?php if (count($aduan) == 0): ?>
    <div class="history-item">Belum ada aduan.</div>
<?php else: ?>
    <?php foreach ($aduan as $row): ?>
        <div class="history-item d-flex justify-content-between align-items-center">
            <div>
                <span>
                    <span class="badge bg-info text-dark ms-2"><?= ucfirst($row['kategori']) ?></span>
                    <strong><?= htmlspecialchars($row['judul']) ?></strong>
                </span><br>
                <span>Tanggal Pengaduan: <?= date('d-m-Y H:i', strtotime($row['created_at'])) ?></span>
            </div>
            <div>
                <a href="detailhistorimhs.php?kategori=<?= $row['kategori'] ?>&id=<?= $row['id'] ?>" class="detail-link btn btn-sm">Detail</a>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
</div>

<footer class="footer-custom mt-auto">
    <p>Copyright &copy; 2025 by SIC Kelompok 2</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tandai menu yang aktif
    const currentPage = 'history';
    document.getElementById(currentPage + '-link').classList.add('active');
});
</script>
</body>
</html>