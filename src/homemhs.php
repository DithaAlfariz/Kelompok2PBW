<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - SiLapor!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="js/script.js">
</head>
<body class="homepage min-vh-100 d-flex flex-column">

<?php include 'navbar.php'; ?>

<div class="container">
    <div class="hero">
        <div class="hero-text">
            <h1 class="judul-histori">Selamat Datang di SiLapor!</h1>
            <p>SiLapor adalah website pengaduan mahasiswa yang dirancang untuk memudahkan mahasiswa menyampaikan aduan terkait akademik, sarana prasarana, dan PPKS. Bersama, kita wujudkan lingkungan kampus yang lebih baik!</p>
        </div>
    </div>
    <div class="announcement-container mb-3">
        <h2 class="section-pengumuman mb-0">Pengumuman</h2>
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
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-3">
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
                </div>
            </div>
            
            <!-- Card 4 -->
            <div class="col">
                <div class="announcement-card h-100">
                    <div class="announcement-img"></div>
                    <h4 class="announcement-title">Tidak bisa isi KRS</h4>
                    <div class="announcement-info">
                        <span class="announcement-kategori">Akademik</span>
                        <span class="announcement-date">| Diterbitkan: 14/05/2025</span>
                    </div>
                    <div class="announcement-status">
                        <span class="status-label">Status:</span>
                        <span class="status-value status-process">Selesai</span>
                    </div>
                    <p class="announcement-desc">
                        sudah bisa isi KRS.
                    </p>
                </div>
            </div>        
    </div>
</div>

<footer class="footer-custom mt-auto">
    <p>Copyright &copy; 2025 by SIC Kelompok 2</p>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>

document.addEventListener('DOMContentLoaded', function() {
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

function filterCards(kategori) {
    
    const cards = document.querySelectorAll('.announcement-card');
    
    cards.forEach(card => {
        const cardKategori = card.querySelector('.announcement-kategori').textContent;
        
        if (kategori === 'Semua' || cardKategori === kategori) {
            card.closest('.col').style.display = 'block';
        } else {
            card.closest('.col').style.display = 'none';
        }
    });
}
</script>
</body>
</html>