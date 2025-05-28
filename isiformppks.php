<?php
session_start();
$conn = new mysqli("localhost", "root", "", "silapor");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses form jika disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $conn->real_escape_string($_POST['name'] ?? '');
    $kontak = $conn->real_escape_string($_POST['contact'] ?? '');
    $judul = $conn->real_escape_string($_POST['complaint']);
    $deskripsi = $conn->real_escape_string($_POST['description']);
    $lokasi = $conn->real_escape_string($_POST['location']);
    $tanggal = $conn->real_escape_string($_POST['date']);
    $pelaku = $conn->real_escape_string($_POST['perpetrator'] ?? '');
    $tindak_lanjut = $conn->real_escape_string($_POST['followup']);
    $user_id = $_SESSION['user_id'];
    $kategori = 'ppks';

    // Untuk file bukti (jika ada)
    $bukti = '';
    if (isset($_FILES['bukti']) && $_FILES['bukti']['error'] == 0) {
        $target_dir = "bukti/ppks/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $bukti = time() . '_' . basename($_FILES["bukti"]["name"]);
        move_uploaded_file($_FILES["bukti"]["tmp_name"], $target_dir . $bukti);
    }

        $sql = "INSERT INTO history (user_id, nama, kontak, judul, deskripsi, lokasi, tanggal, pelaku, bukti, tindak_lanjut, kategori)
        VALUES ('$user_id', '$nama', '$kontak', '$judul', '$deskripsi', '$lokasi', '$tanggal', '$pelaku', '$bukti', '$tindak_lanjut', '$kategori')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Pengaduan berhasil dikirim!');window.location='pengaduanmhs.php';</script>";
    } else {
        echo "<script>alert('Gagal mengirim pengaduan: " . $conn->error . "');</script>";
    }
}
?>