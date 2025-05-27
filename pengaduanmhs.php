<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan - SiLapor!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsif.css">
</head>
<body class="pengaduan min-vh-100 d-flex flex-column">
    
<?php include 'navbar.php'; ?>

<div class="container form-content mt-5 pt-5">
    <blockquote class="blockquote text-center">
        <p>“Berani bersuara untuk perubahan! Kami menjamin keamanan dan kerahasiaan setiap pengaduan yang anda sampaikan.”</p>
    </blockquote>

    <div class="container kategori-content mt-5">
    <h2 class="text-center">Pilih Kategori Pengaduan</h2>
    
        <a href="saranapmhs.php?user_id=<?= $_SESSION['user_id'] ?>">
            <button class="kategori-btn">Sarana & Prasarana</button>
        </a>
        <a href="akademikmhs.php?user_id=<?= $_SESSION['user_id'] ?>">
            <button class="kategori-btn">Akademik</button>
        </a>
        <a href="ppksmhs.php?user_id=<?= $_SESSION['user_id'] ?>">
            <button class="kategori-btn">PPKS</button>
        </a>
    </div>
</div>

<footer class="footer-custom mt-auto">
    <p>Copyright &copy; 2025 by SIC Kelompok 2</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tandai menu yang aktif
    const currentPage = 'pengaduan';
    document.getElementById(currentPage + '-link').classList.add('active');
});
</script>
</body>
</html>
<?php echo 'User ID: ' . ($_SESSION['user_id'] ?? 'Belum login'); ?>