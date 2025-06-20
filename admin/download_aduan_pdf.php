<?php
require_once __DIR__ . '/vendor/autoload.php'; // pastikan mpdf sudah diinstall via composer
include '../koneksi.php';
session_start();
if (!isset($_SESSION['user_id'])) exit('Unauthorized');
$user_id = $_SESSION['user_id'];
$id = $_GET['id_history'] ?? $_GET['id'] ?? '';
$kategori = $_GET['kategori'] ?? '';
$data = null;

// Debugging: cek nilai variabel
// var_dump($id, $kategori, $user_id);
// exit;

$q = mysqli_query($conn, "SELECT * FROM history WHERE id='$id' AND kategori='$kategori'");
$data = mysqli_fetch_assoc($q);
if (!$data) exit('Data tidak ditemukan');

// Mapping kategori
$kategori_label = [
    'sarana'   => 'Sarana & Prasarana',
    'ppks'     => 'PPKS',
    'akademik' => 'Akademik'
];
$kategori_tampil = isset($kategori_label[strtolower($data['kategori'])]) 
    ? $kategori_label[strtolower($data['kategori'])] 
    : ucfirst($data['kategori']);

$html = '
<style>
    body { font-family: Arial, sans-serif; }
    h2 { margin-bottom: 20px; }
    table {
        border-collapse: collapse;
        width: 100%;
        max-width: 700px;
        margin: 0 auto 20px auto;
        font-size: 14px;
    }
    th, td {
        border: 1px solid #222;
        padding: 10px 12px;
        text-align: left;
    }
    th {
        background: #f2f2f2;
        font-weight: bold;
    }
    tr:nth-child(even) td {
        background: #fafafa;
    }
    .label {
        width: 35%;
        font-weight: bold;
        background: #f7f7f7;
    }
</style>
<h2 align="center">Detail Aduan</h2>
<table>
<tr><td class="label">Kategori</td><td>' . $kategori_tampil . '</td></tr>
<tr><td class="label">Nama</td><td>' . htmlspecialchars($data['nama']) . '</td></tr>
<tr><td class="label">NPM</td><td>' . htmlspecialchars($data['npm']) . '</td></tr>
<tr><td class="label">No. Telepon</td><td>' . htmlspecialchars($data['kontak']) . '</td></tr>
<tr><td class="label">Judul Aduan</td><td>' . htmlspecialchars($data['judul']) . '</td></tr>
<tr><td class="label">Deskripsi</td><td>' . nl2br(htmlspecialchars($data['deskripsi'])) . '</td></tr>
<tr><td class="label">Lokasi</td><td>' . htmlspecialchars($data['lokasi']) . '</td></tr>
<tr><td class="label">Tanggal Pengaduan</td><td>' . (!empty($data['tanggal']) ? date('d-m-Y', strtotime($data['tanggal'])) : date('d-m-Y', strtotime($data['created_at']))) . '</td></tr>
</table>
';

// Sertakan gambar bukti pendukung jika ada
if (!empty($data['bukti'])) {
    $kategori_folder = strtolower($data['kategori']);
    $imgPath = realpath(__DIR__ . "/../bukti/$kategori_folder/" . $data['bukti']);
    if ($imgPath && file_exists($imgPath)) {
        $imgType = pathinfo($imgPath, PATHINFO_EXTENSION);
        $imgData = base64_encode(file_get_contents($imgPath));
        $src = 'data:image/' . $imgType . ';base64,' . $imgData;
        $html .= '<div style="text-align:center; margin-top:30px;">
            <b>Lampiran:</b><br>
            <img src="' . $src . '" style="max-width:350px; max-height:350px; border:1px solid #ccc; margin-top:10px;">
        </div>';
    }
}

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output('detail_aduan.pdf', 'I');
?>