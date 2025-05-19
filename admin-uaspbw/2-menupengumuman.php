<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aduan - Admin SiLapor!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/2-menupengumuman.css">
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

<h2 class="fw-bold">Pengumuman</h2>
<div class="container">
    <div class="announcement-container mb-5">
            <div class="filter-container mb-3">
                <form method="GET" action="">
                    <label for="kategori"></label>
                    <select name="kategori" id="kategori" onchange="this.form.submit()">
                        <option value="Semua" selected>Semua</option>
                        <option value="Sarana & Prasarana">Sarana & Prasarana</option>
                        <option value="Akademik">Akademik</option>
                        <option value="PPKS">PPKS</option>
                    </select>
                </form>
            </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-2">
            <!-- Card 1 -->
            <div class="col">
                <div class="announcement-card h-100">
                    <div class="announcement-img"></div>
                    <h4 class="announcement-title">AC Ruangan 3-04 Rusak</h4>
                    <div class="announcement-info">
                        <span class="announcement-kategori">Sarana & Prasarana</span>
                        <span class="announcement-date">| Diterbitkan: 14/05/2025</span>
                    </div>
                    <div class="announcement-status">
                        <span class="status-label">Status:</span>
                        <span class="status-value status-process">Proses</span>
                    </div>
                    <p class="announcement-desc">
                        AC Ruangan 3-04 sedang diperbaiki teknisi.
                    </p>
                    <a href="5-detailpengumuman.php" class="btn-edit">✎</a>
                    <button class="delete-btn" onclick="deletecard(this)">🗑️</button>
                </div>
            </div>
            
            <!-- Card 2 -->
            <div class="col">
                <div class="announcement-card h-100">
                    <div class="announcement-img"></div>
                    <h4 class="announcement-title">AC Ruangan 3-04 Rusak</h4>
                    <div class="announcement-info">
                        <span class="announcement-kategori">Sarana & Prasarana</span>
                        <span class="announcement-date">| Diterbitkan: 14/05/2025</span>
                    </div>
                    <div class="announcement-status">
                        <span class="status-label">Status:</span>
                        <span class="status-value status-process">Proses</span>
                    </div>
                    <p class="announcement-desc">
                        AC Ruangan 3-04 sedang diperbaiki teknisi.
                    </p>
                    <a href="5-detailpengumuman.php" class="btn-edit">✎</a>
                    <button class="delete-btn" onclick="deletecard(this)">🗑️</button>
                </div>
            </div>
            
            <!-- Card 3 -->
            <div class="col">
                <div class="announcement-card h-100">
                    <div class="announcement-img"></div>
                    <h4 class="announcement-title">AC Ruangan 3-04 Rusak</h4>
                    <div class="announcement-info">
                        <span class="announcement-kategori">Sarana & Prasarana</span>
                        <span class="announcement-date">| Diterbitkan: 14/05/2025</span>
                    </div>
                    <div class="announcement-status">
                        <span class="status-label">Status:</span>
                        <span class="status-value status-process">Proses</span>
                    </div>
                    <p class="announcement-desc">
                        AC Ruangan 3-04 sedang diperbaiki teknisi.
                    </p>
                    <a href="5-detailpengumuman.php" class="btn-edit">✎</a>
                    <button class="delete-btn" onclick="deletecard(this)">🗑️</button>
                </div>
            </div>
            
            <!-- Card 4 -->
            <div class="col">
                <div class="announcement-card h-100">
                    <div class="announcement-img"></div>
                    <h4 class="announcement-title">AC Ruangan 3-04 Rusak</h4>
                    <div class="announcement-info">
                        <span class="announcement-kategori">Sarana & Prasarana</span>
                        <span class="announcement-date">| Diterbitkan: 14/05/2025</span>
                    </div>
                    <div class="announcement-status">
                        <span class="status-label">Status:</span>
                        <span class="status-value status-process">Proses</span>
                    </div>
                    <p class="announcement-desc">
                        AC Ruangan 3-04 sedang diperbaiki teknisi.
                    </p>
                    <a href="5-detailpengumuman.php" class="btn-edit">✎</a>
                    <button class="delete-btn" onclick="deletecard(this)">🗑️</button>
                </div>
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
    // Tandai menu yang aktif
    const currentPage = 'pengumuman';
    document.getElementById(currentPage + '-link').classList.add('active');
});
function deletecard(btn) {
    const row = btn.closest('tr');
    const confirmed = confirm('Apakah Anda yakin ingin menghapus pengumuman ini?');
    if (confirmed) {
        row.remove();
        updateRowNumbers();
    }
}
</script>
</body>
</html>