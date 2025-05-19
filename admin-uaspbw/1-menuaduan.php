<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aduan - Admin SiLapor!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/1-menuaduan.css">
</head>
<main class="flex-grow-1">
<body class="body">
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="#">SiLapor!</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="1-menuaduan.php" id="pengaduan-link">Aduan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="2-menupengumuman.php" id="history-link">Pengumuman</a>
                </li>
            </ul>
            <div class="dropdown">
                <a class="dropdown-toggle text-white d-flex align-items-center text-decoration-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="img/icons8-test-account-48.png" alt="Profile" class="rounded-circle me-2" width="30">
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

<h2 class="fw-bold">Kelola Aduan Masuk</h2>
<div class="container mt-4">
    <section class="tampilan-aduan">
        <div class="filter-container mb-3">
            <form method="GET" action="">
                <label for="kategori"></label>
                <select name="kategori" id="kategori" onchange="this.form.submit()">
                    <option value="Semua" selected>Semua Kategori</option>
                    <option value="Sarana & Prasarana">Sarana & Prasarana</option>
                    <option value="Akademik">Akademik</option>
                    <option value="PPKS">PPKS</option>
                </select>
            </form>
            <form method="GET" action="">
                <label for="status"></label>
                <select name="status" id="status" onchange="this.form.submit()">
                    <option value="Semua" selected>Semua Status</option>
                    <option value="Proses">Diproses</option>
                    <option value="Selesai">Selesai</option>
                </select>
            </form>
        </div>
        <table>
            <tr>
                <th>No.</th>
                <th>Judul Aduan</th>
                <th>Kategori</th>
                <th>Tanggal Pengaduan</th>
                <th>Detail</th>
                <th>Status Aduan</th>
               <th>Status Terkirim</th>
            </tr>
            <tr>
                <td>1.</td>
                <td>Judul 1</td>
                <td>Akademik</td>
                <td>15-05-2025</td>
                <td><a href="4-detailaduan.php">Detail</a></td>
                <td><span class="badge bg-danger">Proses</span></td>
                <td><span class="badge bg-secondary">Tidak Terkirim</span></td>
            </tr>
            <tr>
                <td>2.</td>
                <td>Judul 1</td>
                <td>PPKS</td>
                <td>15-05-2025</td>
                <td><a href="4-detailaduan.php">Detail</a></td>
                <td><span class="badge bg-danger">Proses</span></td>
                <td><span class="badge bg-success">Terkirim</span></td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Judul 1</td>
                <td>Sarana Prasarana</td>
                <td>15-05-2025</td>
                <td><a href="4-detailaduan.php">Detail</a></td>
                <td><span class="badge bg-success">Selesai</span></td>
                <td><span class="badge bg-success">Terkirim</span></td>
            </tr>
        </table>
    </section>
</div>
</main>

<footer class="footer-custom mt-auto">
    <p>Copyright &copy; 2025 by SIC Kelompok 2</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tandai menu yang aktif
    const currentPage = 'aduan';
    document.getElementById(currentPage + '-link').classList.add('active');
});
</script>
</body>
</html>