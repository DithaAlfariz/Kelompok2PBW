<?php
require 'koneksi.php';
session_start();

$user_id = $_SESSION['user_id'] ?? 0;

// Ambil data user dari table_user
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM table_user WHERE id='$user_id'"));

// Ambil data setting akun
$setting = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM setting_akun WHERE user_id='$user_id'"));

// Jika belum ada data di setting_akun, insert default
if (!$setting && $user) {
    $username = $user['username'];
    $email = $user['email'];
    $full_name = '';
    $department = '';
    $npm = '';
    $password = $user['password'];
    mysqli_query($conn, "INSERT INTO setting_akun (user_id, username, email, password, full_name, department, npm) VALUES ('$user_id', '$username', '$email', '$password', '', '', '')");
    $setting = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM setting_akun WHERE user_id='$user_id'"));
}

$email = $setting['email'] ?? '';
$username = $setting['username'] ?? '';
$full_name = $setting['full_name'] ?? '';
$department = $setting['department'] ?? '';
$npm = $setting['npm'] ?? '';

// Proses update profil manual
if (isset($_POST['simpan_profil'])) {
    $full_name = $_POST['full_name'];
    $department = $_POST['department'];
    $npm = $_POST['npm'];
    mysqli_query($conn, "UPDATE setting_akun SET full_name='$full_name', department='$department', npm='$npm' WHERE user_id='$user_id'");
    header("Location: settingakun.php?success=profil");
    exit;
}

// Proses update email
if (isset($_POST['ubah_email'])) {
    $email_baru = $_POST['email_baru'];
    mysqli_query($conn, "UPDATE setting_akun SET email='$email_baru' WHERE user_id='$user_id'");
    mysqli_query($conn, "UPDATE table_user SET email='$email_baru' WHERE id='$user_id'");
    $email = $email_baru;
    header("Location: settingakun.php?success=email");
    exit;
}

// Proses update password
if (isset($_POST['ubah_password'])) {
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi = $_POST['konfirmasi_password'];

    if (password_verify($password_lama, $setting['password'])) {
        if ($password_baru === $konfirmasi) {
            $hash = password_hash($password_baru, PASSWORD_DEFAULT);
            mysqli_query($conn, "UPDATE setting_akun SET password='$hash' WHERE user_id='$user_id'");
            header("Location: settingakun.php?success=password");
            exit;
        } else {
            $error = "Konfirmasi password baru tidak cocok!";
        }
    } else {
        $error = "Password lama salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - SiLapor!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container main-content mt-5">
    <div class="row settings-container">
        <!-- Sidebar Menu -->
        <div class="col-md-3 settings-sidebar">
            <h5 class="mb-4 text-center">Pengaturan</h5>
            <ul class="nav flex-column settings-menu" id="settingsTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">
                        <i class="fas fa-user me-2"></i> Profil
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="account-tab" data-bs-toggle="tab" data-bs-target="#account" type="button" role="tab" aria-controls="account" aria-selected="false">
                        <i class="fas fa-key me-2"></i> Akun
                    </button>
                </li>
            </ul>
        </div>
        
        <!-- Content Area -->
        <div class="col-md-9 settings-content">
            <div class="tab-content" id="settingsTabContent">
                <!-- Profil Tab -->
                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <h5 class="section-title">Profil Pengguna</h5>
                    <?php if (isset($_GET['success']) && $_GET['success'] == 'profil'): ?>
                        <div class="alert alert-success">Profil berhasil diperbarui!</div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label for="fullName" class="form-label-setting">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="fullName" name="full_name" value="<?= htmlspecialchars($full_name) ?>" placeholder="Masukkan nama lengkap" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label-setting">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="username" value="<?= htmlspecialchars($username) ?>" disabled readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="department" class="form-label-setting">Jurusan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="department" name="department" value="<?= htmlspecialchars($department) ?>" placeholder="Jurusan" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="npm" class="form-label-setting">NPM <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="npm" name="npm" value="<?= htmlspecialchars($npm) ?>" placeholder="Masukkan NPM" required>
                            </div> 
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label-setting">Email</label>
                                <input type="email" class="form-control" id="email" value="<?= htmlspecialchars($email) ?>" disabled readonly>
                                <small class="text-muted">Email hanya dapat diubah melalui menu Akun</small>
                            </div>                       
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="submit" name="simpan_profil" class="btn btn-confirm">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Account Tab -->
                <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account-tab">
                    <h5 class="section-title">Pengaturan Akun</h5>
                    
                    <!-- Email Change Form -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="card-title mb-3">Ubah Email</h6>
                            <?php if (isset($_GET['success']) && $_GET['success'] == 'email'): ?>
                                <div class="alert alert-success">Email berhasil diubah!</div>
                            <?php endif; ?>
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="currentEmail" class="form-label-setting">Email Saat Ini</label>
                                    <input type="email" class="form-control" id="currentEmail" value="<?= htmlspecialchars($email) ?>" disabled readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="newEmail" class="form-label-setting">Email Baru</label>
                                    <input type="email" class="form-control" id="newEmail" name="email_baru" placeholder="Masukkan email baru" required>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" name="ubah_email" class="btn btn-confirm">
                                        <i class="fas fa-envelope me-2"></i> Ubah Email
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Password Change Form -->
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title mb-3">Ubah Password</h6>
                            <?php if (isset($_GET['success']) && $_GET['success'] == 'password'): ?>
                                <div class="alert alert-success">Password berhasil diubah!</div>
                            <?php endif; ?>
                            <?php if (!empty($error)): ?>
                                <div class="alert alert-danger"><?= $error ?></div>
                            <?php endif; ?>
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="currentPassword" class="form-label-setting">Password Saat Ini</label>
                                    <input type="password" class="form-control" id="currentPassword" name="password_lama" placeholder="Masukkan password saat ini" required>
                                </div>
                                <div class="mb-3">
                                    <label for="newPassword" class="form-label-setting">Password Baru</label>
                                    <input type="password" class="form-control" id="newPassword" name="password_baru" placeholder="Masukkan password baru" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label-setting">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" id="confirmPassword" name="konfirmasi_password" placeholder="Konfirmasi password baru" required>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" name="ubah_password" class="btn btn-confirm">
                                        <i class="fas fa-key me-2"></i> Ubah Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    const profileTab = document.getElementById('profile-tab');
    const accountTab = document.getElementById('account-tab');
    const profilePane = document.getElementById('profile');
    const accountPane = document.getElementById('account');

    profileTab.addEventListener('click', function() {
        profileTab.classList.add('active');
        accountTab.classList.remove('active');
        profilePane.classList.add('show', 'active');
        accountPane.classList.remove('show', 'active');
    });
    accountTab.addEventListener('click', function() {
        accountTab.classList.add('active');
        profileTab.classList.remove('active');
        accountPane.classList.add('show', 'active');
        profilePane.classList.remove('show', 'active');
    });

    // Handle profile image upload (optional, demo only)
    const profileImageInput = document.getElementById('profileImageInput');
    const profileImage = document.getElementById('profileImage');
    if (profileImageInput) {
        profileImageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profileImage.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
</body>
</html>
