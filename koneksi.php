<?php
$conn = mysqli_connect("localhost", "root", "", "silapor");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>