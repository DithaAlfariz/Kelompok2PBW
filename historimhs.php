<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History - SiLapor!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="min-vh-100 d-flex flex-column">
    
<?php include 'navbar.php'; ?>

<h1 class="judul-histori">HISTORI ADUAN</h1>

<div class="container list-histori mt-4">
        <div class="history-item">
            <span><strong>Judul Aduan 1</strong></span>
            <span>Tanggal Pengaduan: 10-05-2025</span>
            <a href="detailhistorimhs.php?id=1" class="detail-link">Detail</a>
        </div>
        <div class="history-item">
            <span><strong>Judul Aduan 2</strong></span>
            <span>Tanggal Pengaduan: 11-05-2025</span>
            <a href="detailhistorimhs.php?id=2" class="detail-link">Detail</a>
        </div>
        <div class="history-item">
            <span><strong>Judul Aduan 3</strong></span>
            <span>Tanggal Pengaduan: 12-05-2025</span>
            <a href="detailhistorimhs.php?id=3" class="detail-link">Detail</a>
        </div>
        <div class="history-item">
            <span><strong>Judul Aduan 4</strong></span>
            <span>Tanggal Pengaduan: 13-05-2025</span>
            <a href="detailhistorimhs.php?id=4" class="detail-link">Detail</a>
        </div>
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