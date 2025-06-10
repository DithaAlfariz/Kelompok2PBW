<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPKS - SiLapor!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>
<body class="pengaduan">
    
<?php include 'navbar.php'; ?>
<?php include 'isiformppks.php'; ?>

<div class="container form-content mt-5 pt-5">
    <blockquote class="blockquote text-center">
        <p>“Berani bersuara untuk perubahan! Kami menjamin keamanan dan kerahasiaan setiap pengaduan yang anda sampaikan.”</p>
    </blockquote>
    <h3 class="judul-kategori text-center">Satgas PPKS</h3>

    <form class="form-container" action= "isiformppks.php" method="POST" enctype="multipart/form-data">
        <!-- Nama (Opsional) -->
        <div class="mb-3">
            <label for="name" class="form-label">Nama <i>(Opsional)</i></label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Boleh dibiarkan kosong">
        </div>

        <!-- Nomor Telepon / Email -->
        <div class="mb-3">
            <label for="contact" class="form-label">Nomor Telepon <i>(isi jika ingin ditindak lanjut)</i></label>
            <input type="text" class="form-control" id="contact" name="contact" placeholder="Jawaban Anda">
        </div>

        <!-- Judul Aduan -->
        <div class="mb-3">
            <label for="complaint" class="form-label">Judul Aduan</label>
            <input type="text" class="form-control" id="complaint" name="complaint" placeholder="Jawaban Anda" required>
        </div>

        <!-- Deskripsi Kejadian -->
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi Kejadian</label>
            <textarea class="form-control" id="description" name="description" placeholder="Ceritakan secara detail" rows="3" required></textarea>
        </div>

        <!-- Lokasi Kejadian -->
        <div class="mb-3">
            <label for="location" class="form-label">Lokasi Kejadian</label>
            <input type="text" class="form-control" id="location" name="location" placeholder="Jawaban Anda" required>
        </div>

        <!-- Tanggal Kejadian -->
        <div class="mb-3">
            <label for="date" class="form-label">Tanggal Kejadian</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>

        <!-- Ciri-Ciri Pelaku -->
        <div class="mb-3">
            <label for="perpetrator" class="form-label">Ciri-Ciri Pelaku</label>
            <textarea class="form-control" id="perpetrator" name="perpetrator" placeholder="Misalnya: tinggi, pakaian, dll." rows="2"></textarea>
        </div>

        <!-- Bukti Pendukung -->
        <div class="mb-3">
            <label for="evidence" class="form-label">Bukti Pendukung</label>
            <input type="file" class="form-control" id="evidence" name="bukti">
        </div>

        <!-- Tindak Lanjut -->
        <div class="mb-3">
            <label for="followup" class="form-label">Bentuk Tindak Lanjut yang Diinginkan</label>
            <select class="form-control" id="followup" name="followup" required>
                <option value="" disabled selected>Pilih Tindak Lanjut</option>
                <option value="pendampingan">Pendampingan Psikologis</option>
                <option value="penyelesaian_internal">Penyelesaian Internal</option>
                <option value="laporan_hukum">Laporan Hukum</option>
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn submit-btn">Submit</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tandai menu yang aktif
    const currentPage = 'pengaduan';
    document.getElementById(currentPage + '-link').classList.add('active');
});

</script>
</body>
</html>