<?php
// session_start();
require_once 'koneksi.php';

// Ambil user_id dari session login
$user_id = $_SESSION['user_id'] ?? null;
$username = 'User';

if ($user_id) {
    $result = mysqli_query($conn, "SELECT username FROM table_user WHERE id='$user_id'");
    if ($row = mysqli_fetch_assoc($result)) {
        $username = htmlspecialchars($row['username']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand text-white fw-bold" href="#">SiLapor!</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="homemhs.php" id="home-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pengaduanmhs.php" id="pengaduan-link">Pengaduan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="historimhs.php" id="history-link">Histori</a>
                    </li>
                </ul>
                <div class="dropdown">
                    <a class="dropdown-toggle text-white d-flex align-items-center text-decoration-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="img/icons8-test-account-48.png" alt="Profile" class="rounded-circle me-2" width="30">
                        <span><?= $username ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="settingakun.php">
                                <img src="img/icons8-setting-24.png" alt="Setting Icon" class="me-2" width="20">
                                Setting
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="logout.php">
                                <img src="img/icons8-logout-24.png" alt="Setting Icon" class="me-2" width="20">
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

</body>

</html>