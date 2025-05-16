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
                <!-- Profile Tab -->
                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <h5 class="section-title">Profil Pengguna</h5>
                    <form id="profileForm">
                        <div class="text-center mb-5">
                            <div class="profile-image-container">
                                <img src="img/icons8-test-account-48.png" alt="Profile" class="profile-image" id="profileImage">
                                <label for="profileImageInput" class="image-upload-btn">
                                    <i class="fas fa-camera"></i>
                                </label>
                                <input type="file" id="profileImageInput" accept="image/*" style="display: none;">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label for="fullName" class="form-label-setting">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="fullName" placeholder="Masukkan nama lengkap" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label-setting">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="username" placeholder="Masukkan username" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="department" class="form-label-setting">Jurusan <span class="text-danger">*</span></label>
                                <select class="form-select" id="department" required>
                                    <option value="" selected disabled>Pilih Jurusan</option>
                                    <option value="Informatika">Informatika</option>
                                    <option value="Sistem Informasi">Sistem Informasi</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="npm" class="form-label-setting">NPM <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="npm" placeholder="Masukkan NPM" required>
                            </div> 
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label-setting">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="email@example.com" disabled readonly>
                                <small class="text-muted">Email hanya dapat diubah melalui menu Akun</small>
                            </div>                       
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="submit" class="btn btn-warning">
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
                            <form id="emailForm">
                                <div class="mb-3">
                                    <label for="currentEmail" class="form-label-setting">Email Saat Ini</label>
                                    <input type="email" class="form-control" id="currentEmail" value="user@example.com" disabled readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="newEmail" class="form-label-setting">Email Baru</label>
                                    <input type="email" class="form-control" id="newEmail" placeholder="Masukkan email baru" required>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-warning">
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
                            <form id="passwordForm">
                                <div class="mb-3">
                                    <label for="currentPassword" class="form-label-setting">Password Saat Ini</label>
                                    <input type="password" class="form-control" id="currentPassword" placeholder="Masukkan password saat ini" required>
                                </div>
                                <div class="mb-3">
                                    <label for="newPassword" class="form-label-setting">Password Baru</label>
                                    <input type="password" class="form-control" id="newPassword" placeholder="Masukkan password baru" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label-setting">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" id="confirmPassword" placeholder="Konfirmasi password baru" required>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-warning">
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
    // Automatically fill in profile data (simulate fetching from server)
    document.getElementById('fullName').value = "M. Rafly";
    document.getElementById('username').value = "rafly123";
    document.getElementById('department').value = "Informatika";
    document.getElementById('npm').value = "123456789";
    document.getElementById('email').value = "user@example.com";
    document.getElementById('currentEmail').value = "user@example.com";
    
    // Handle profile image upload
    const profileImageInput = document.getElementById('profileImageInput');
    const profileImage = document.getElementById('profileImage');
    
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
    
    // Form Handling
    const profileForm = document.getElementById('profileForm');
    const emailForm = document.getElementById('emailForm');
    const passwordForm = document.getElementById('passwordForm');
    
    profileForm.addEventListener('submit', function(e) {
        e.preventDefault();
        // Validate form
        if (this.checkValidity()) {
            // Show success message (in a real app, you would save to backend here)
            alert("Profil berhasil diperbarui!");
        } else {
            // Trigger browser's default validation
            this.reportValidity();
        }
    });
    
    emailForm.addEventListener('submit', function(e) {
        e.preventDefault();
        // Validate form
        if (this.checkValidity()) {
            // Show success message (in a real app, you would save to backend here)
            alert("Email berhasil diperbarui!");
            document.getElementById('currentEmail').value = document.getElementById('newEmail').value;
            document.getElementById('email').value = document.getElementById('newEmail').value;
            document.getElementById('newEmail').value = '';
        } else {
            // Trigger browser's default validation
            this.reportValidity();
        }
    });
    
    passwordForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        
        // Check if passwords match
        if (newPassword !== confirmPassword) {
            alert("Password baru dan konfirmasi password tidak cocok!");
            return;
        }
        
        // Validate form
        if (this.checkValidity()) {
            // Show success message (in a real app, you would save to backend here)
            alert("Password berhasil diperbarui!");
            document.getElementById('currentPassword').value = '';
            document.getElementById('newPassword').value = '';
            document.getElementById('confirmPassword').value = '';
        } else {
            // Trigger browser's default validation
            this.reportValidity();
        }
    });
});
</script>
</body>
</html>