<?php
include '../koneksi.php';
session_start();

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

    // Cek apakah email sudah dipakai user lain
    $cek_email = mysqli_query($conn, "SELECT id FROM table_user WHERE email='$email'");
    if(mysqli_num_rows($cek_email) > 0) {
        $alert = 'Email sudah terpakai';
    } else {
        $query = "UPDATE table_user SET username='$username', email='$email'";
        if (!empty($password)) {
            $query .= ", password='$password'";
        }
        $query .= " WHERE id='$id' AND role='admin'";
        mysqli_query($conn, $query);
        header("Location: 3-kelolauser.php");
        exit;
    }
}

// Ambil data admin untuk form edit
$user = null;
if (isset($_GET['edit'])) {
    $id = mysqli_real_escape_string($conn, $_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM table_user WHERE id='$id'");
    $user = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Form Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="css/nav.css">
  <link rel="stylesheet" href="css/5-user.css">
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
                            <a id="logoutBtn" class="dropdown-item d-flex align-items-center" href="../logout.php">
                                <img src="img/icons8-logout-24.png" alt="Setting Icon" class="me-2" width="20">
                                Logout
                            </a>
                        </li>
                    </ul>
            </div>
        </div>
     </div>
</nav>

<h2 class="fw-bold"><?= $user ? 'Edit Admin' : 'Tambah Admin' ?></h2>
<div class="container-form">
    <form method="POST" action="">
        <?php if($user): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
        <?php endif; ?>
        <div class="form-group">
            <label for="nama">Nama Admin</label>
            <input type="text" id="nama" name="nama" placeholder="Masukkan nama" value="<?= $user ? htmlspecialchars($user['username']) : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email Admin</label>
            <input type="email" id="email" name="email" placeholder="Masukkan email" value="<?= $user ? htmlspecialchars($user['email']) : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="password"><?= $user ? 'Password Baru (kosongkan jika tidak diubah)' : 'Password' ?></label>
            <input type="password" id="password" name="password" placeholder="Masukkan Password" <?= $user ? '' : 'required' ?>>
        </div>
        <div class="form-buttons">
            <button class="btn btn-kembali" type="button" onclick="window.location.href='3-kelolauser.php'">Kembali</button>
            <div class="right-buttons">
                <button type="submit" class="btn btn-simpan" name="<?= $user ? 'update' : 'simpan' ?>"><?= $user ? 'Update' : 'Simpan' ?></button>
            </div>
        </div>            
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (isset($alert) && $alert === 'Email sudah terpakai'): ?>
<script>
Swal.fire({
    icon: 'warning',
    title: 'Email Sudah Terpakai!',
    text: 'Email sudah terpakai, silakan gunakan email lain.',
    confirmButtonText: 'OK'
}).then(() => {
    window.location.href = '3-kelolauser.php';
});
</script>
<?php endif; ?>
</body>
</html>
