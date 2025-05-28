<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$user_id = $_SESSION['user_id'] ?? null;
$username = '';
if ($user_id) {
    include_once 'koneksi.php';
    $q = mysqli_query($conn, "SELECT username FROM table_user WHERE id='$user_id' LIMIT 1");
    if ($row = mysqli_fetch_assoc($q)) {
        $username = $row['username'];
    }
}
?>
<link rel="stylesheet" href="css/nav.css">
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="#">SiLapor!</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="1-menuaduan.php?user_id=<?= urlencode($user_id) ?>" id="pengaduan-link">Aduan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="2-menupengumuman.php?user_id=<?= urlencode($user_id) ?>" id="pengumuman-link">Pengumuman</a>
                </li>
            </ul>
            <div class="dropdown">
                <a class="dropdown-toggle text-white d-flex align-items-center text-decoration-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span><?= htmlspecialchars($username ?: 'Admin') ?></span>
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
