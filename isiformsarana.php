<?php
session_start();
include 'koneksi.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama      = $_POST['name'];
    $npm       = $_POST['npm'];
    $kontak    = $_POST['contact'];
    $judul     = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $lokasi    = $_POST['lokasi'];
    $user_id   = $_SESSION['user_id'];
    $kategori  = 'sarana';

    // Upload file bukti jika ada
    $bukti = '';
    if (isset($_FILES['bukti']) && $_FILES['bukti']['error'] == 0) {
        $target_dir = "bukti/sarana/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $bukti = time() . '_' . basename($_FILES["bukti"]["name"]);
        move_uploaded_file($_FILES["bukti"]["tmp_name"], $target_dir . $bukti);
    }

    // Insert ke history
        $sql = "INSERT INTO history (user_id, nama, npm, kontak, judul, deskripsi, lokasi, bukti, kategori)
                VALUES ('$user_id', '$nama', '$npm', '$kontak', '$judul', '$deskripsi', '$lokasi', '$bukti', '$kategori')";

    if (mysqli_query($conn, $sql)) {

        echo "<script>alert('Pengaduan berhasil dikirim!');window.location='pengaduanmhs.php';</script>";
    } else {
        echo "<script>alert('Gagal mengirim pengaduan!');</script>";
    }
}
?>