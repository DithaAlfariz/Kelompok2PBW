<?php
include '../koneksi.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;

// Proses hapus admin
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    mysqli_query($conn, "DELETE FROM table_user WHERE id='$id' AND role='admin'");
    header("Location: 3-kelolauser.php");
    exit;
}

// Ambil data admin untuk ditampilkan
$result = mysqli_query($conn, "SELECT * FROM table_user WHERE role='admin'");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/3-kelolauser.css">
</head>
<body class="kelolauser">
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
                            <a id="logoutBtn" class="dropdown-item d-flex align-items-center" href="logout.php">
                                <img src="img/icons8-logout-24.png" alt="Setting Icon" class="me-2" width="20">
                                Logout
                            </a>
                        </li>
                    </ul>
            </div>
        </div>
     </div>
</nav>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="text-dark fw-bold m-0">Kelola Admin</h5>
                <a href="6-formuser.php?role=admin" class="btn btn-primary" style="font-size: 0.9rem; padding: 0.4rem 0.8rem;">
                    <i class="fas fa-plus me-1"></i> Tambah Admin
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php if(mysqli_num_rows($result) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th class="aksi-column">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            while($row = mysqli_fetch_assoc($result)): 
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['username']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td class="aksi-column">
                                    <div class="action-buttons">
                                        <a href="6-formuser.php?edit=<?= $row['id'] ?>" class="btn btn-warning btn-action">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-action" onclick="return confirm('Yakin hapus admin ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    Belum ada admin.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>