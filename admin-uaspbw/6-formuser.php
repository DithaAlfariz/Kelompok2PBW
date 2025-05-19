<!-- adminformadduser.html / adminformedituser.html -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Form User</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="css/nav.css">
  <link rel="stylesheet" href="css/5-user.css">
</head>
<main class="flex-grow-1">
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
                            <a id="logoutBtn" class="dropdown-item d-flex align-items-center" href="#">
                                <img src="img/icons8-logout-24.png" alt="Setting Icon" class="me-2" width="20">
                                Logout
                            </a>
                        </li>
                    </ul>
            </div>
        </div>
     </div>
</nav>

<h2 class="fw-bold">Tambah User</h2>
<div class="container-form">
    <form action="#">
        <div class="form-group">
            <label for="nama">Nama User</label>
                <input type="text" id="nama" name="nama" placeholder="Masukkan nama">
            </div>
            <div class="form-group">
                <label for="email">Email User</label>
                <input type="email" id="email" name="email" placeholder="Masukkan email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan Password">
            </div>
            <div class="form-group">
                <label for="level">Level</label>
                <select id="level" name="level">
                    <option value="Admin">Admin</option>
                    <option value="User">User</option>
                </select>
            </div>
            <div class="form-buttons">
                <button class="btn btn-kembali" type="button" onclick="window.location.href='3-kelolauser.php'">Kembali</button>
                <div class="right-buttons">
                    <button type="button" class="btn btn-reset" onclick="resetForm()">Reset</button>
                    <button type="submit" class="btn btn-simpan">Simpan</button>
                </div>
            </div>            
        </form>
    </div>    
</body>
<script>
    // Ambil parameter dari URL
    const urlParams = new URLSearchParams(window.location.search);
    const nama = urlParams.get('nama');
    const email = urlParams.get('email');
    const level = urlParams.get('level');
  
    // Isi form dengan data dari URL
    document.getElementById('nama').value = nama || '';
    document.getElementById('email').value = email || '';
    document.getElementById('level').value = level || 'User';
  
    // Fungsi untuk menyimpan perubahan
    document.querySelector('.btn-simpan').addEventListener('click', function(event) {
        event.preventDefault(); // Mencegah form submit default
  
        // Ambil data dari form
        const updatedNama = document.getElementById('nama').value;
        const updatedEmail = document.getElementById('email').value;
        const updatedLevel = document.getElementById('level').value;
  
        // Simpan data ke localStorage (simulasi penyimpanan)
        alert(`Data berhasil diperbarui:\nNama: ${updatedNama}\nEmail: ${updatedEmail}\nLevel: ${updatedLevel}`);
  
        // Kembali ke halaman Kelola User
        window.location.href = '3-kelolauser.php';
    });
  </script>
<script>
    document.querySelector('.btn-simpan').addEventListener('click', function(event) {
        event.preventDefault(); // Mencegah form submit default

        // Ambil data dari form
        const nama = document.getElementById('nama').value;
        const email = document.getElementById('email').value;
        const level = document.getElementById('level').value;

        if (nama && email && level) {
            // Ambil data user yang sudah ada di localStorage
            const users = JSON.parse(localStorage.getItem('users')) || [];

            // Tambahkan user baru ke array
            users.push({ nama, email, level });

            // Simpan kembali ke localStorage
            localStorage.setItem('users', JSON.stringify(users));

            // Tampilkan notifikasi
            alert('User berhasil ditambahkan!');

            // Kembali ke halaman Kelola User
            window.location.href="3-kelolauser.php";
        } else {
            alert('Harap isi semua data!');
        }
    });

    function resetForm() {
        // Ambil elemen form
        const form = document.querySelector('form');

        // Reset semua input dalam form
        form.reset();

        // Tambahkan logika tambahan jika diperlukan
        alert('Form telah direset!');
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</html>
