<?php
require 'koneksi.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // Hapus user dari tabel inputuser
    $query = "DELETE FROM inputuser WHERE id = $id";
    mysqli_query($conn, $query);
}

// Redirect kembali ke halaman kelola user dengan notifikasi
header('Location: adminkelolauser.php?deleted=1');
exit;
