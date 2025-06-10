<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'koneksi.php';

// Include SweetAlert2 CDN
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

// Proses form jika disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['name'] ?? '';
    $kontak = $_POST['contact'] ?? '';
    $judul = $_POST['complaint'] ?? '';
    $deskripsi = $_POST['description'] ?? '';
    $lokasi = $_POST['location'] ?? '';
    $tanggal = $_POST['date'] ?? '';
    $pelaku = $_POST['perpetrator'] ?? '';
    $tindak_lanjut = $_POST['followup'] ?? '';
    $user_id = $_SESSION['user_id'] ?? '';
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

    $status = '';
    if (mysqli_query($conn, $sql)) {
        $status = 'success';
        $message = 'Pengaduan berhasil dikirim!';
    } else {
        $status = 'error';
        $message = 'Gagal mengirim pengaduan!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form Pengaduan</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>


<?php if (!empty($status)) : ?>
<script>
    Swal.fire({
        icon: '<?php echo $status; ?>',
        title: '<?php echo $status == "success" ? "Sukses!" : "Error!"; ?>',
        text: '<?php echo $message; ?>',
        confirmButtonText: 'OK'
    }).then((result) => {
        <?php if ($status == 'success'): ?>
            // Redirect ke halaman pengaduanmhs.php setelah klik OK
            window.location.href = 'pengaduanmhs.php';
        <?php endif; ?>
    });
</script>
<?php endif; ?>

</body>
</html>