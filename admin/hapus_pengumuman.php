<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Ambil id_history dari pengumuman yang akan dihapus
    $get = mysqli_query($conn, "SELECT id_history FROM pengumuman WHERE id = $id");
    $row = mysqli_fetch_assoc($get);
    $id_history = isset($row['id_history']) ? intval($row['id_history']) : 0;

    // Hapus data pengumuman
    $query = "DELETE FROM pengumuman WHERE id = $id";
    mysqli_query($conn, $query);

    // Update kolom pengumuman pada detail_history jika id_history ditemukan
    if ($id_history > 0) {
        mysqli_query($conn, "UPDATE detail_history SET pengumuman='tidak aktif' WHERE id_history = $id_history");
    }
}

header('Location: 2-menupengumuman.php');
exit;
?>