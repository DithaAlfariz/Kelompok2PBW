<?php
include 'koneksi.php';

$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : 'Semua';
?>
<!DOCTYPE html>
<html lang="en" translate="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate">
    <title>Home - SiLapor!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="admin/css/2-menupengumuman.css">
    <link rel="stylesheet" href="script.js">
    <?php
    include 'navbar.php';
    ?>
</head>
<body class="homepage min-vh-100 d-flex flex-column">
<div class="container">
    <div class="hero">
        <div class="hero-text">
            <h1 class="judul-histori">Selamat Datang di SiLapor!</h1>
            <p>SiLapor adalah website pengaduan mahasiswa yang dirancang untuk memudahkan mahasiswa menyampaikan aduan terkait akademik, sarana prasarana, dan PPKS. Bersama, kita wujudkan lingkungan kampus yang lebih baik!</p>
        </div>
    </div>
    <div class="announcement-container mb-3">
            <div class="filter-container mb-3">
                <form method="GET" action="">
                    <label for="kategori"></label>
                    <select name="kategori" id="kategori" onchange="this.form.submit()">
                        <option value="Semua" <?= ($kategori == 'Semua') ? 'selected' : '' ?>>Semua</option>
                        <option value="sarana" <?= ($kategori == 'sarana') ? 'selected' : '' ?>>Sarana & Prasarana</option>
                        <option value="akademik" <?= ($kategori == 'akademik') ? 'selected' : '' ?>>Akademik</option>
                        <option value="ppks" <?= ($kategori == 'ppks') ? 'selected' : '' ?>>PPKS</option>
                    </select>
                </form>
            </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-2">
            <?php

            $koneksi = new mysqli("localhost", "root", "", "silapor");
            if ($koneksi->connect_error) {
                die("Koneksi gagal: " . $koneksi->connect_error);
            }

            $kategori = isset($_GET['kategori']) ? $_GET['kategori'] : 'Semua';

            if ($kategori == 'Semua' || $kategori == '') {
                $sql = "SELECT * FROM pengumuman ORDER BY tanggal DESC";
            } else {
                $sql = "SELECT * FROM pengumuman WHERE kategori = '$kategori' ORDER BY tanggal DESC";
            }
            $result = $koneksi->query($sql);
            ?>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="col">
                        <div class="announcement-card h-100">
                            <div class="announcement-img">
                                <?php
                                    $kategori_folder = $row['kategori'];
                                    $nama_file = isset($row['bukti']) ? $row['bukti'] : '';
                                    $img_path = "bukti/$kategori_folder/$nama_file";
                                    $img_full_path = __DIR__ . "/bukti/$kategori_folder/$nama_file";
                                    $imgSrc = (!empty($nama_file) && file_exists($img_full_path))
                                        ? $img_path
                                        : "img/default-image.png";
                                ?>
                            <img src="<?php echo $imgSrc; ?>" alt="Bukti" class="announcement-photo">
                        </div>
                            <h4 class="announcement-title"><?php echo htmlspecialchars($row['judul']); ?></h4>
                            <div class="announcement-info">
                                <?php
                                    // Mapping kategori database ke label tampilan
                                    $kategori_label = [
                                        'sarana'   => 'Sarana & Prasarana',
                                        'ppks'     => 'PPKS',
                                        'akademik' => 'Akademik'
                                    ];
                                    $kategori_tampil = isset($kategori_label[strtolower($row['kategori'])]) ? $kategori_label[strtolower($row['kategori'])] : htmlspecialchars($row['kategori']);
                                ?>
                                <span class="announcement-kategori"><?php echo $kategori_tampil; ?></span>
                                <span class="announcement-date">| Diterbitkan: <?php echo date('d/m/Y', strtotime($row['tanggal'])); ?></span>
                            </div>
                            <div class="announcement-status">
                                <span class="status-label">Status:</span>
                                <span class="status-value 
                                    <?php 
                                        if (strtolower($row['status']) == 'diproses') echo 'status-process';
                                        else if (strtolower($row['status']) == 'selesai') echo 'status-done';
                                    ?>">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </span>
                            </div>
                            <p class="announcement-desc">
                                <?php echo htmlspecialchars($row['komentar']); ?>
                            </p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col">
                    <div class="alert alert-info">Belum ada pengumuman.</div>
                </div>
            <?php endif; ?>
        </div>     
    </div>
</div>

<footer class="footer-custom mt-auto">
    <p>Copyright &copy; 2025 by SIC Kelompok 2</p>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    //menandai menu navbar yang aktif
    const currentPage = 'home';
    document.getElementById(currentPage + '-link').classList.add('active');
    
    const urlParams = new URLSearchParams(window.location.search);
    const selectedKategori = urlParams.get('kategori') || 'Semua';
    
    document.getElementById('kategori').value = selectedKategori;
    
    filterCards(selectedKategori);
    
    document.getElementById('kategori').addEventListener('change', function() {
        const selectedKategori = this.value;
        filterCards(selectedKategori);
    });
});

</script>
</body>
</html>