<?php
// Tambahkan koneksi ke database
include '../koneksi.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;
// Ambil parameter id dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Proses simpan feedback admin (hanya update detail_history)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);

    $check = mysqli_query($conn, "SELECT * FROM detail_history WHERE id_history='$id'");
    if (mysqli_num_rows($check) > 0) {
        $update = "UPDATE detail_history SET status='$status', komentar='$komentar' WHERE id_history='$id'";
    } else {
        $update = "INSERT INTO detail_history (id_history, status, komentar) VALUES ('$id', '$status', '$komentar')";
    }
    mysqli_query($conn, $update);

    header("Location: 4-detailaduan.php?id=$id");
    exit;
}

// Proses kirim ke pengumuman
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kirim'])) {
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);
    $bukti_terpilih = isset($_POST['bukti_terpilih']) ? mysqli_real_escape_string($conn, $_POST['bukti_terpilih']) : '';

    // Update detail_history (set pengumuman aktif)
    $check = mysqli_query($conn, "SELECT * FROM detail_history WHERE id_history='$id'");
    if (mysqli_num_rows($check) > 0) {
        $update = "UPDATE detail_history SET status='$status', komentar='$komentar', pengumuman='aktif' WHERE id_history='$id'";
    } else {
        $update = "INSERT INTO detail_history (id_history, status, komentar, pengumuman) VALUES ('$id', '$status', '$komentar', 'aktif')";
    }
    mysqli_query($conn, $update);

    // Insert ke tabel pengumuman, tapi cek dulu apakah sudah ada data dengan id_history yang sama
    $cekPengumuman = mysqli_query($conn, "SELECT id FROM pengumuman WHERE id_history='$id' LIMIT 1");
    if (mysqli_num_rows($cekPengumuman) > 0) {
        // Jika sudah ada, lakukan UPDATE
        $q = mysqli_query($conn, "SELECT * FROM history WHERE id_pengaduan='$id'");
        $aduan = mysqli_fetch_assoc($q);
        $judul = mysqli_real_escape_string($conn, $aduan['judul']);
        $kategori = mysqli_real_escape_string($conn, $aduan['kategori']);
        $tanggal = mysqli_real_escape_string($conn, $aduan['created_at']);
        mysqli_query($conn, "UPDATE pengumuman SET judul='$judul', kategori='$kategori', tanggal='$tanggal', status='$status', komentar='$komentar', bukti='$bukti_terpilih' WHERE id_history='$id'");
    } else {
        // Jika belum ada, lakukan INSERT
        $q = mysqli_query($conn, "SELECT * FROM history WHERE id_pengaduan='$id'");
        $aduan = mysqli_fetch_assoc($q);
        $judul = mysqli_real_escape_string($conn, $aduan['judul']);
        $kategori = mysqli_real_escape_string($conn, $aduan['kategori']);
        $tanggal = mysqli_real_escape_string($conn, $aduan['created_at']);
        $insertPengumuman = "INSERT INTO pengumuman (id_history, judul, kategori, tanggal, status, komentar, bukti)
                             VALUES ('$id', '$judul', '$kategori', '$tanggal', '$status', '$komentar', '$bukti_terpilih')";
        mysqli_query($conn, $insertPengumuman);
    }

    header("Location: 2-menupengumuman.php");
    exit;
}

// Query LEFT JOIN history dan detail_history
$query = "SELECT h.*, d.status, d.komentar, d.pengumuman 
          FROM history h 
          LEFT JOIN detail_history d ON h.id_pengaduan = d.id_history 
          WHERE h.id_pengaduan = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Ambil array bukti jika ada beberapa file (misal dipisah koma)
$bukti_files = [];
if (!empty($data['bukti'])) {
    $bukti_files = array_map('trim', explode(',', $data['bukti']));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aduan - Admin SiLapor!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/4-detail.css">
    <!-- Hapus link navadmin.css di sini, sudah di-include di navadmin.php -->
</head>
<body class="detailaduan">
<?php include '../navadmin.php'; ?>

<h2 class="fw-bold">Kelola Aduan</h2>
<div class="detail-container mt-6">
    <p><strong>Kategori:</strong> <span id="kategori"><?php echo htmlspecialchars($data['kategori'] ?? '-'); ?></span></p>
    <p><strong>Nama:</strong> <span id="nama"><?php echo htmlspecialchars($data['nama'] ?? '-'); ?></span></p>
    <p><strong>NPM:</strong> <span id="npm"><?php echo htmlspecialchars($data['npm'] ?? '-'); ?></span></p>
    <p><strong>No. Telepon:</strong> <span id="telp"><?php echo htmlspecialchars($data['kontak'] ?? '-'); ?></span></p>
    <p><strong>Judul Aduan:</strong> <span id="judul"><?php echo htmlspecialchars($data['judul'] ?? '-'); ?></span></p>
    <p><strong>Deskripsi:</strong> <span id="deskripsi"><?php echo htmlspecialchars($data['deskripsi'] ?? '-'); ?></span></p>
    <p><strong>Lokasi:</strong> <span id="lokasi"><?php echo htmlspecialchars($data['lokasi'] ?? '-'); ?></span></p>
    <p><strong>Bukti Pendukung:</strong>
        <?php if (!empty($data['bukti'])): ?>
            <?php $kategori_folder = strtolower($data['kategori']); ?>
            <a href="bukti/<?= $kategori_folder ?>/<?= htmlspecialchars($data['bukti']) ?>" target="_blank" class="btn btn-lampiran">
                <i class="fas fa-file me-2"></i>Lihat Lampiran
            </a>
            <br>
            <img src="bukti/<?= $kategori_folder ?>/<?= htmlspecialchars($data['bukti']) ?>" alt="" style="max-width:200px;max-height:120px;margin-top:8px;">
        <?php else: ?>
            Tidak ada lampiran
        <?php endif; ?>
    </p>
    <!-- Modal Lampiran -->
    <div class="modal fade" id="lampiranModal" tabindex="-1" aria-labelledby="lampiranModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lampiranModalLabel">Lampiran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <?php
                        if (!empty($bukti_files)):
                            $kategori = strtolower($data['kategori'] ?? '');
                            $folder = 'bukti/' . $kategori;
                            foreach ($bukti_files as $file):
                                ?>
                        <img src="<?= $folder ?>/<?= htmlspecialchars($file) ?>" alt="Lampiran" class="img-fluid mb-2" style="max-height:300px;">
                        <?php
                            endforeach;
                        else:
                            ?>
                        <p>Tidak ada lampiran untuk ditampilkan.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if (strtolower($data['kategori'] ?? '') === "ppks"): ?>
            <div id="ppksOnly">
                <p><strong>Tanggal Kejadian:</strong> <span id="tanggal"><?php echo htmlspecialchars($data['tanggal'] ?? '-'); ?></span></p>
                <p><strong>Ciri-ciri Pelaku:</strong> <span id="pelaku"><?php echo htmlspecialchars($data['pelaku'] ?? '-'); ?></span></p>
                <p><strong>Bentuk Tindak Lanjut yang Diinginkan:</strong> <span id="tindak_lanjut"><?php echo htmlspecialchars($data['tindak_lanjut'] ?? '-'); ?></span></p>
            </div>
        </button>
        <?php endif; ?>
        <hr>
        <h4 class="judul-edit">Feedback Admin</h4>
        <form method="post">
            <div class="custom-select mb-3">
                <label for="status"><strong>Status</strong></label>
                <select id="status" name="status" class="form-select">
                    <option value="Diproses" <?= ($data['status'] ?? '') === 'Diproses' ? 'selected' : '' ?>>Diproses</option>
                    <option value="Selesai" <?= ($data['status'] ?? '') === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="komentar"><strong>Tambahkan Komentar</strong></label>
                <textarea id="komentar" name="komentar" class="form-control" rows="3" placeholder="tambahkan komentar"><?= htmlspecialchars($data['komentar_admin'] ?? '') ?></textarea>
            </div>
            <!-- Pilihan Foto Bukti -->
            <div class="mb-3">
                <label for="pilihBukti" class="form-label"><strong>Pilih Foto Bukti</strong></label>
                <select id="pilihBukti" class="form-select" onchange="tampilkanBukti()">
                    <option value="">-- Pilih Foto --</option>
                    <?php foreach ($bukti_files as $file): ?>
                        <option value="<?= $folder ?>/<?= htmlspecialchars($file) ?>"><?= htmlspecialchars($file) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="bukti_terpilih" id="bukti_terpilih" value="">
                </div>
                <div class="mb-3">
                    <img id="uploadedImage" src="" alt="Uploaded Image" class="img-fluid" style="display: none; max-width: 100%;">
                </div>
                <div style="display: flex; justify-content: space-between; margin-top: 15px;">
                    <button class="btn btn-secondary" style="margin-right: auto;" type="button" onclick="window.history.back()">Kembali</button>
                    <div style="display: flex; gap: 10px;">
                        <button class="btn btn-success" name="simpan" type="submit">Simpan</button>
                        <button class="btn btn-primary" name="kirim" type="submit">Kirim</button>
                        <a href="download_aduan_pdf.php?kategori=<?= $kategori ?>&id=<?= $data['id_pengaduan'] ?>" class="btn btn-primary mb-2" target="_blank">
                            <i class="fas fa-download"></i> Download PDF
                        </a>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Preview Foto Bukti & set hidden input
    function tampilkanBukti() {
        const select = document.getElementById('pilihBukti');
        const img = document.getElementById('uploadedImage');
        const hidden = document.getElementById('bukti_terpilih');
        if (select.value) {
            img.src = select.value;
            img.style.display = "block";
            hidden.value = select.value.split('/').pop(); // hanya nama file
        } else {
            img.style.display = "none";
            hidden.value = "";
        }
    }
</script>
</body>
</html>
