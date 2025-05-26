<?php
include 'koneksi.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;
// Fungsi generate random ID
function generateRandomId($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomId = '';
    for ($i = 0; $i < $length; $i++) {
        $randomId .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomId;
}

// Proses tambah admin
if (isset($_POST['simpan'])) {
    $username = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = 'admin';
    
    // Cek email sudah ada atau belum
    $check_email = mysqli_query($conn, "SELECT * FROM table_user WHERE email='$email'");
    if(mysqli_num_rows($check_email) > 0) {
        echo "<script>alert('Email sudah terdaftar!');window.location='3-kelolauser.php';</script>";
        exit;
    }

    // Generate random id dan pastikan unik
    do {
        $id = generateRandomId();
        $check = mysqli_query($conn, "SELECT id FROM table_user WHERE id = '$id'");
    } while(mysqli_num_rows($check) > 0);

    // Query insert dengan ID yang digenerate
    $query = "INSERT INTO table_user (id, username, email, password, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssss", $id, $username, $email, $password, $role);
    
    if(mysqli_stmt_execute($stmt)) {
        header("Location: 3-kelolauser.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Proses edit admin
if (isset($_POST['update'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $username = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "UPDATE table_user SET username='$username', email='$email'";
    if (!empty($password)) {
        $query .= ", password='$password'";
    }
    $query .= " WHERE id='$id' AND role='admin'";
    mysqli_query($conn, $query);
    header("Location: 3-kelolauser.php");
    exit;
}

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
    <link rel="stylesheet" href="css/navadmin.css">
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
                    <button class="btn btn-primary" style="font-size: 0.9rem; padding: 0.4rem 0.8rem;">
                        <i class="fas fa-plus me-1"></i> Tambah Admin
                    </button>
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
                                            <button class="btn btn-warning btn-action" data-bs-toggle="modal" data-bs-target="#editAdminModal<?= $row['id'] ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-action" onclick="return confirm('Yakin hapus admin ini?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Edit Admin -->
                                <div class="modal fade" id="editAdminModal<?= $row['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Admin</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form method="POST">
                                                <div class="modal-body">
                                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                    <div class="mb-3">
                                                        <label class="form-label">Username</label>
                                                        <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($row['username']) ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Email</label>
                                                        <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($row['email']) ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Password Baru (kosongkan jika tidak diubah)</label>
                                                        <input type="password" class="form-control" name="password">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" name="update" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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

    <!-- Modal Tambah Admin -->
    <div class="modal fade" id="addAdminModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>