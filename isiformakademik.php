<?php
session_start();
include 'koneksi.php'; // pastikan file koneksi ke database sudah benar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama      = $_POST['name'];
    $npm       = $_POST['npm'];
    $kontak    = $_POST['contact'];
    $judul     = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $lokasi    = $_POST['lokasi'];
    $user_id   = $_SESSION['user_id'];
    $kategori = 'akademik';

    // Upload file bukti jika ada
    $bukti = '';
    if (isset($_FILES['bukti']) && count($_FILES['bukti']['name']) > 0 && $_FILES['bukti']['name'][0] != '') {
        $target_dir = "bukti/akademik/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $file_names = [];
        foreach ($_FILES['bukti']['name'] as $key => $name) {
            if ($_FILES['bukti']['error'][$key] == 0) {
                $new_name = time() . '_' . rand(1000,9999) . '_' . basename($name);
                move_uploaded_file($_FILES['bukti']['tmp_name'][$key], $target_dir . $new_name);
                $file_names[] = $new_name;
            }
        }
        $bukti = implode(',', $file_names);
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