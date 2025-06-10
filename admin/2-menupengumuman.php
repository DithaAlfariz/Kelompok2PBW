<?php
include '../koneksi.php';

$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : 'Semua';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman - Admin SiLapor!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/2-menupengumuman.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<main class="flex-grow-1">
<body class="pengumuman">
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="#">SiLapor!</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="1-menuaduan.php" id="pengaduan-link">Aduan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="2-menupengumuman.php" id="history-link">Pengumuman</a>
                </li>
            </ul>
            <div class="dropdown">
                <a class="dropdown-toggle text-white d-flex align-items-center text-decoration-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span>Admin</span>
                </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="3-kelolauser.php">
                                <img src="img/icons8-setting-24.png" alt="Setting Icon" class="me-2" width="20">
                                Kelola User
                            </a>
                        </li>
                        <li>
                            <a id="logoutBtn" class="dropdown-item d-flex align-items-center" href="#">
                                <img src="img/icons8-logout-24.png" alt="Setting Icon" class="me-2" width="20">
                                Logout
                            </a>
                        </li>
                    </ul>
            </div>
        </div>
    </div>
</nav>

<h2 class="fw-bold">Pengumuman</h2>
<div class="container">
    <div class="announcement-container mb-5">
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
            // Koneksi ke database
            $koneksi = new mysqli("localhost", "root", "", "silapor");

            // Cek koneksi
            if ($koneksi->connect_error) {
                die("Koneksi gagal: " . $koneksi->connect_error);
            }

            // Ambil filter kategori dari GET
            $kategori = isset($_GET['kategori']) ? $_GET['kategori'] : 'Semua';

            // Query data pengumuman
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
                                    $kategori_folder = strtolower(str_replace(' ', '', $row['kategori']));
                                    $nama_file = isset($row['bukti']) ? $row['bukti'] : '';
                                    $imgSrc = (!empty($nama_file) && file_exists(__DIR__."/../bukti/$kategori_folder/$nama_file"))
                                        ? "../bukti/$kategori_folder/$nama_file"
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
                            <a href="5-detailpengumuman.php?id=<?php echo $row['id']; ?>" class="btn-edit">✎</a>
                            <form method="POST" action="hapus_pengumuman.php" class="form-hapus" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="delete-btn" style="border:none;background:none;padding:0;">🗑️</button>
                            </form>
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
</main>

<footer class="footer-custom mt-auto">
    <p>Copyright &copy; 2025 by SIC Kelompok 2</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // SweetAlert konfirmasi hapus
    document.querySelectorAll('.form-hapus').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Pengumuman akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // SweetAlert jika pengumuman berhasil dihapus
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('hapus') === 'sukses') {
        Swal.fire({
            icon: 'success',
            title: 'Pengumuman berhasil dihapus',
            showConfirmButton: false,
            timer: 1800
        });
        // Hapus parameter dari URL agar tidak muncul lagi saat reload
        if (window.history.replaceState) {
            const url = new URL(window.location);
            url.searchParams.delete('hapus');
            window.history.replaceState({}, document.title, url.pathname + url.search);
        }
    }
});
</script>
</body>
</html>