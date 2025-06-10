<?php
session_start();
include 'koneksi.php';

$user_id = $_SESSION['user_id'];

// Ambil data nama dan npm dari tabel setting_akun
$query = "SELECT full_name, npm FROM setting_akun WHERE user_id = '$user_id' LIMIT 1";
$result = mysqli_query($conn, $query);
$userData = mysqli_fetch_assoc($result);

$nama = $userData['full_name'] ?? '';
$npm = $userData['npm'] ?? '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sarana - SiLapor!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="pengaduan">
    
<?php include 'navbar.php'; ?>
<?php include 'isiformsarana.php'; ?>

<div class="container form-content mt-5 pt-5">
    <blockquote class="blockquote text-center">
        <p>“Berani bersuara untuk perubahan! Kami menjamin keamanan dan kerahasiaan setiap pengaduan yang anda sampaikan.”</p>
    </blockquote>
    <h3 class="judul-kategori text-center">Sarana & Prasarana</h3>
    
    <form class="form-container" action="saranapmhs.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">NAMA</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($nama); ?>">
        </div>
        <div class="mb-3">
            <label for="npm" class="form-label">NPM</label>
            <input type="text" class="form-control" id="npm" name="npm" value="<?php echo htmlspecialchars($npm); ?>">
        </div>
        <div class="mb-3">
            <label for="contact" class="form-label">Nomor Telepon</label>
            <input type="tel" class="form-control" id="contact" name="contact" placeholder="Masukkan nomor telepon Anda" required>
        </div>
        <div class="mb-3">
            <label for="judul" class="form-label">Judul Pengaduan</label>
            <input type="text" class="form-control" id="judul" name="judul" placeholder="Jawaban Anda" required>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi Pengaduan</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Jawaban Anda" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi Pengaduan</label>
            <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Jawaban Anda" required>
        </div>
        <div class="mb-3">
            <label for="bukti" class="form-label">Bukti Pendukung</label>
            <input type="file" class="form-control" id="bukti" name="bukti">
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