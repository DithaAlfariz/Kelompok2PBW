<?php

include 'koneksi.php';
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
    <title>Aduan - Admin SiLapor!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/navadmin.css">
    <link rel="stylesheet" href="css/1-menuaduan.css">
</head>
<main class="flex-grow-1">
<body class="body">
<?php include 'navadmin.php'; ?>
</nav>
<div class="container mb-4 d-flex justify-content-center align-items-center flex-column" style="min-height:220px;">
    <h5 class="fw-bold mb-3 text-center">Statistik Aduan per Kategori</h5>
    <canvas id="kategoriPieChart" width="400" height="200"></canvas>
</div>
<h2 class="fw-bold">Kelola Aduan Masuk</h2>
<div class="container mt-4">
    <section class="tampilan-aduan">
        <div class="filter-container mb-3">
            <form method="GET" action="">
                <label for="kategori"></label>
                <select name="kategori" id="kategori" onchange="this.form.submit()">
                    <option value="Semua" <?= $kategori_terpilih == 'Semua' ? 'selected' : '' ?>>Semua Kategori</option>
                    <option value="sarana" <?= $kategori_terpilih == 'sarana' ? 'selected' : '' ?>>Sarana & Prasarana</option>
                    <option value="akademik" <?= $kategori_terpilih == 'akademik' ? 'selected' : '' ?>>Akademik</option>
                    <option value="ppks" <?= $kategori_terpilih == 'ppks' ? 'selected' : '' ?>>PPKS</option>
                </select>
                <label for="status"></label>
                <select name="status" id="status" onchange="this.form.submit()">
                    <option value="Semua" <?= $status_terpilih == 'Semua' ? 'selected' : '' ?>>Semua Status</option>
                    <option value="Diproses" <?= $status_terpilih == 'Diproses' ? 'selected' : '' ?>>Diproses</option>
                    <option value="Selesai" <?= $status_terpilih == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                </select>
            </form>
        </div>
        <table>
            <tr>
                <th>No.</th>
                <th>Judul Aduan</th>
                <th>Nama Pelapor</th>
                <th>Email</th>
                <th>Kategori</th>
                <th>Tanggal Pengaduan</th>
                <th>Detail</th>
                <th>Status Aduan</th>
                <th>Status Pengumuman</th>
            </tr>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['judul']) ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['kategori']) ?></td>
                <td><?= date('d-m-Y', strtotime($row['created_at'])) ?></td>
                <td><a href="4-detailaduan.php?id=<?= $row['history_id'] ?>">Detail</a></td>
                <td>
                    <?php if ($row['status'] == 'Diproses'): ?>
                        <span class="badge bg-warning">Diproses</span>
                    <?php elseif ($row['status'] == 'Selesai'): ?>
                        <span class="badge bg-success">Selesai</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Belum Diproses</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($row['pengumuman'] == 'aktif'): ?>
                        <span class="badge bg-success">Ditampilkan</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Tidak Ditampilkan</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </section>
</div>
</main>

<footer class="footer-custom mt-auto">
    <p>Copyright &copy; 2025 by SIC Kelompok 2</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tandai menu yang aktif
    const currentPage = 'aduan';
    document.getElementById(currentPage + '-link').classList.add('active');
});

const kategoriData = <?php echo json_encode($kategori_data); ?>;
const labels = Object.keys(kategoriData);
const data = Object.values(kategoriData);

const ctx = document.getElementById('kategoriPieChart').getContext('2d');
const kategoriPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: labels,
        datasets: [{
            label: 'Jumlah Aduan',
            data: data,
            backgroundColor: [
            "rgba(33, 84, 141, 0.8)",
            "rgba(50, 112, 190, 0.8)",
            "rgba(143, 169, 219, 0.8)",
          ],
          hoverBackgroundColor: [
            "rgba(33, 84, 141, 1)",
            "rgba(50, 112, 190, 1)",
            "rgba(143, 169, 219, 1)",
          ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>
</body>
</html>