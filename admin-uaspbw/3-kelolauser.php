<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelolauser - Admin SiLapor!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/3-kelolauser.css">
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

<h2 class="fw-bold">Kelola User</h2>
<div class="container kategori-content mt-5">
    <div class="table-container">
        <a href="6-formuser.php" class="add-user-btn">+ Add User</a>
        <a href="6-formuser.php">
        <i class="bi bi-pencil"></i>
    </a>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="userTable">
                <tr>
                    <td>1.</td>
                    <td>Administrator</td>
                    <td>admin@admin.com</td>
                    <td>Admin</td>
                    <td>
                        <button class="edit-btn" onclick="editUser(this)">✎</button>
                        <button class="delete-btn" onclick="deleteUser(this)">🗑️</button>
                    </td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>M.Rafly</td>
                    <td>mrafly@gmail.com</td>
                    <td>User</td>
                    <td>
                        <button class="edit-btn" onclick="editUser(this)">✎</button>
                        <button class="delete-btn" onclick="deleteUser(this)">🗑️</button>
                    </td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td>D.Alfariz</td>
                    <td>alfariz@gmail.com</td>
                    <td>User</td>
                    <td>
                        <button class="edit-btn" onclick="editUser(this)">✎</button>
                        <button class="delete-btn" onclick="deleteUser(this)">🗑️</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</main>

<footer class="footer-custom mt-auto">
    <p>Copyright &copy; 2025 by SIC Kelompok 2</p>
</footer>

<script>
function deleteUser(btn) {
    const row = btn.closest('tr');
    const confirmed = confirm('Apakah Anda yakin ingin menghapus user ini?');
    if (confirmed) {
        row.remove();
        updateRowNumbers();
    }
}

function editUser(btn) {
    // Ambil baris tabel yang sesuai
    const row = btn.closest('tr');
    const nama = row.cells[1].innerText; // Kolom Nama
    const email = row.cells[2].innerText; // Kolom Email
    const level = row.cells[3].innerText; // Kolom Level

    // Navigasi ke halaman edit user dengan parameter query string
    window.location.href = `6-formuser.php?nama=${encodeURIComponent(nama)}&email=${encodeURIComponent(email)}&level=${encodeURIComponent(level)}`;
}
</script>
</body>
</html>