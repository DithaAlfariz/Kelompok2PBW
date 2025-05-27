<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    die('Anda harus login terlebih dahulu!');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $nama      = $_POST['name'];
    $npm       = $_POST['npm'];
    $kontak    = $_POST['contact'];
    $judul     = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $lokasi    = $_POST['lokasi'];
    $user_id   = $_SESSION['user_id'];
    $kategori  = 'sarana';
    

    $bukti = '';
    if (isset($_FILES['bukti']) && $_FILES['bukti']['error'] == 0) {
        $target_dir = __DIR__ . '/bukti/sarana/';
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $bukti = time() . '_' . basename($_FILES["bukti"]["name"]);
        move_uploaded_file($_FILES["bukti"]["tmp_name"], $target_dir . $bukti);
    }

    $sql = "INSERT INTO history 
        (user_id, nama, npm, kontak, judul, deskripsi, lokasi, bukti, kategori)
        VALUES 
        ('$user_id', '$nama', '$npm', '$kontak', '$judul', '$deskripsi', '$lokasi', '$bukti', '$kategori')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Pengaduan berhasil dikirim!');window.location='saranapmhs.php';</script>";
    } else {
        echo "<script>alert('Gagal mengirim pengaduan!');</script>";
    }
}
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

<div class="container form-content mt-5 mb-5 pt-5">
    <blockquote class="blockquote text-center">
        <p>“Berani bersuara untuk perubahan! Kami menjamin keamanan dan kerahasiaan setiap pengaduan yang anda sampaikan.”</p>
    </blockquote>
    <h3 class="judul-kategori text-center">Sarana & Prasarana</h3>
    
    <form class="form-container" action="saranapmhs.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">NAMA</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Jawaban Anda" required>
        </div>
        <div class="mb-3">
            <label for="npm" class="form-label">NPM</label>
            <input type="text" class="form-control" id="npm" name="npm" placeholder="Jawaban Anda" required>
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

<script></script>
</html>