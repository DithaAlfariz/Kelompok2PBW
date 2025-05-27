<?php
include '../koneksi.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;
// Ambil filter kategori dari GET
$kategori_terpilih = isset($_GET['kategori']) ? $_GET['kategori'] : 'Semua';
$status_terpilih = isset($_GET['status']) ? $_GET['status'] : 'Semua';

// Gabungkan filter kategori dan status
$where = [];
if ($kategori_terpilih && $kategori_terpilih !== 'Semua') {
    $kategori_safe = mysqli_real_escape_string($conn, $kategori_terpilih);
    $where[] = "h.kategori = '$kategori_safe'";
}
if ($status_terpilih && $status_terpilih !== 'Semua') {
    $status_safe = mysqli_real_escape_string($conn, $status_terpilih);
    $where[] = "d.status = '$status_safe'";
}
$where_sql = '';
if (count($where) > 0) {
    $where_sql = 'WHERE ' . implode(' AND ', $where);
}

// Query untuk mengambil semua laporan dengan join ke detail_history
$query = "
    SELECT h.*, d.*, h.id_pengaduan AS history_id, u.username, u.email
    FROM history h
    LEFT JOIN detail_history d ON h.id_pengaduan = d.id_history
    LEFT JOIN table_user u ON h.user_id = u.id
    $where_sql
    ORDER BY h.created_at DESC
";
$result = mysqli_query($conn, $query);

// Query statistik kategori
$stat_query = "SELECT kategori, COUNT(*) as jumlah FROM history GROUP BY kategori";
$stat_result = mysqli_query($conn, $stat_query);

$kategori_data = [];
while ($row = mysqli_fetch_assoc($stat_result)) {
    $kategori_data[$row['kategori']] = $row['jumlah'];
}
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
</head>
<main class="flex-grow-1">
<body class="pengumuman">
<?php include '../navadmin.php'; ?>

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
            <?php
            // Koneksi ke database
            $conn = new mysqli("localhost", "root", "", "silapor");

            // Cek koneksi
            if ($conn->connect_error) {
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
            $result = $conn->query($sql);
            ?>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="col">
                        <!-- Seluruh card dibungkus <a> agar bisa diklik -->
                        <a href="5-detailpengumuman.php?id=<?= $row['id']; ?>" style="text-decoration:none;color:inherit;">
                            <div class="announcement-card h-100" style="cursor:pointer; position:relative;">
                                <div class="announcement-img">
                                    <?php if (!empty($row['bukti'])): ?>
                                        <?php
                                            $kategori_folder = strtolower(str_replace([' ', '&'], ['_', 'dan'], $row['kategori']));
                                            $img_path = "bukti/" . $kategori_folder . "/" . htmlspecialchars($row['bukti']);
                                        ?>
                                        <img src="<?php echo $img_path; ?>" alt="Bukti" class="announcement-photo img-fluid" style="object-fit:cover; width:100%; height:180px; border-radius:8px;">
                                    <?php endif; ?>
                                </div>
                                <h4 class="announcement-title"><?php echo htmlspecialchars($row['judul']); ?></h4>
                                <div class="announcement-info">
                                    <?php
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
                                    <span class="status-value <?php echo ($row['status'] == 'Diproses') ? 'status-process' : 'status-done'; ?>">
                                        <?php echo htmlspecialchars($row['status']); ?>
                                    </span>
                                </div>
                                <p class="announcement-desc">
                                    <?php echo htmlspecialchars($row['komentar']); ?>
                                </p>
                            </div>
                        </a>
                        <!-- Tombol edit dan delete bisa diletakkan di luar <a> agar tidak ikut terklik -->
                        <div style="margin-top:-40px; margin-bottom:20px;">
                            <a href="5-detailpengumuman.php?id=<?= $row['id']; ?>" class="btn-edit">✎</a>
                            <button class="delete-btn" onclick="deletecard(this, <?= $row['id']; ?>)">🗑️</button>
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
    // Tandai menu yang aktif
    const currentPage = 'pengumuman';
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
            card.parentElement.style.display = 'block';
        } else {
            card.parentElement.style.display = 'none';
        }
    });
}

function deletecard(btn, id) {
    const col = btn.closest('.col'); // Ubah dari tr ke .col agar kartu bisa dihapus
    const confirmed = confirm('Apakah Anda yakin ingin menghapus pengumuman ini?');
    if (confirmed) {
        fetch('hapus_pengumuman.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: id })
        })
        .then(response => {
            if (response.ok) {
                col.remove(); // Hapus kartu dari tampilan
            } else {
                alert('Gagal menghapus pengumuman. Silakan coba lagi.');
            }
        })
        .catch(error => {
            console.error('Terjadi kesalahan:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        });
    }
}
</script>
</body>
</html>