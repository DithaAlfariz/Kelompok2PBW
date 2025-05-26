<?php
session_start();
include 'koneksi.php';

$id = $_GET['id'] ?? '';
$kategori = $_GET['kategori'] ?? '';
$user_id = $_SESSION['user_id'] ?? '';

if (!$id || !$kategori || !$user_id) {
    echo "<script>alert('Parameter tidak lengkap!');window.history.back();</script>";
    exit;
}

// Ambil nama file bukti dari tabel history
$q = mysqli_query($conn, "SELECT bukti FROM history WHERE id_pengaduan='$id' AND user_id='$user_id' AND kategori='$kategori'");
$data = mysqli_fetch_assoc($q);

if ($data && !empty($data['bukti'])) {
    $folder = strtolower($kategori);
    $filePath = __DIR__ . "/bukti/$folder/" . $data['bukti'];
    if (file_exists($filePath)) unlink($filePath);
}

// Hapus data dari detail_history, pengumuman, dan history
mysqli_query($conn, "DELETE FROM detail_history WHERE id_history='$id'");
mysqli_query($conn, "DELETE FROM pengumuman WHERE id_history='$id'");
mysqli_query($conn, "DELETE FROM history WHERE id_pengaduan='$id' AND user_id='$user_id' AND kategori='$kategori'");

echo "<script>alert('Data berhasil dihapus!');window.location='historimhs.php';</script>";
?>