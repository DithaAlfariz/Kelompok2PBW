<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akademik - SiLapor!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>
<body class="pengaduan">
    
<?php include 'navbar.php'; ?>

<div class="container form-content mt-5 pt-5 mb-5">
    <blockquote class="blockquote text-center">
        <p>“Berani bersuara untuk perubahan! Kami menjamin keamanan dan kerahasiaan setiap pengaduan yang anda sampaikan.”</p>
    </blockquote>
    <h3 class="judul-kategori text-center">Akademik</h3>

    <form class="form-container">
        <div class="mb-3">
            <label for="name" class="form-label">NAMA</label>
            <input type="text" class="form-control" id="name" placeholder="Jawaban Anda" required>
        </div>
        <div class="mb-3">
            <label for="npm" class="form-label">NPM</label>
            <input type="text" class="form-control" id="npm" placeholder="Jawaban Anda" required>
        </div>
        <div class="mb-3">
            <label for="contact" class="form-label">Nomor Telepon</label>
            <input type="tel" class="form-control" id="contact" placeholder="Masukkan nomor telepon Anda" required>
        </div>
        <div class="mb-3">
            <label for="judul" class="form-label">Judul Pengaduan</label>
            <input type="text" class="form-control" id="judul" placeholder="Jawaban Anda"required>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi Pengaduan</label>
            <textarea class="form-control" id="deskripsi" placeholder="Jawaban Anda" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi Pengaduan</label>
            <input type="text" class="form-control" id="lokasi" placeholder="Jawaban Anda" required>
        </div>
        <div class="mb-3">
            <label for="bukti" class="form-label">Bukti Pendukung</label required>
            <input type="file" class="form-control" id="bukti">
        </div>
        <button type="submit" class="btn submit-btn">Submit</button>
    </form>
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