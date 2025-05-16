<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan - SiLapor!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="pengaduan">
    
<?php include 'navbar.php'; ?>

<div class="container form-content mt-5 pt-5">
    <blockquote class="blockquote text-center">
        <p>“Berani bersuara untuk perubahan! Kami menjamin keamanan dan kerahasiaan setiap pengaduan yang anda sampaikan.”</p>
    </blockquote>

    <div class="container kategori-content mt-5">
    <h2 class="text-center">Pilih Kategori Pengaduan</h2>
    
        <a href="saranapmhs.php">
            <button class="kategori-btn">Sarana & Prasarana</button>
        </a>
        <a href="akademikmhs.php">
            <button class="kategori-btn">Akademik</button>
        </a>
        <a href="ppksmhs.php">
            <button class="kategori-btn">PPKS</button>
        </a>
    </div>

</div>

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