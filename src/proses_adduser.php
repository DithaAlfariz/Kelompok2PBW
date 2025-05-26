<?php
    require 'koneksi.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = $_POST['user_id'];
        $email = $_POST['email'];
        $level = $_POST['level'];

        // Ambil username dari table_user berdasarkan id
        $result = mysqli_query($conn, "SELECT username FROM table_user WHERE id='$user_id'");
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];

        // Cek apakah user sudah ada di inputuser
        $cek = mysqli_query($conn, "SELECT id FROM inputuser WHERE id='$user_id'");
        if (mysqli_num_rows($cek) > 0) {
            // Jika sudah terdaftar, langsung redirect ke halaman kelola user
            header("Location: adminkelolauser.php");
            exit;
        }

        // Simpan ke inputuser, id diisi dari id table_user
        $query = "INSERT INTO inputuser (id, username, email, level) VALUES ('$user_id', '$username', '$email', '$level')";
        if (mysqli_query($conn, $query)) {
            header("Location: adminkelolauser.php");
            exit;
        } else {
            echo "Gagal menambah user: " . mysqli_error($conn);
        }
    }
    ?>
