<?php
$conn = mysqli_connect("localhost", "root", "", "silapor");
if ($conn->connect_error) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>