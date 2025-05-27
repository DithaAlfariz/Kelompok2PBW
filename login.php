<?php
session_start();
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    $query_sql = "SELECT * FROM table_user WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $query_sql);

    if (isset($_POST['ajax']) && $_POST['ajax'] == '1') {
        header('Content-Type: application/json');
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            echo json_encode(['success' => true, 'role' => $user['role']]);
        } else {
            echo json_encode(['success' => false]);
        }
        exit;
    } else {
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            // Simpan data session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $user_id = $user['id'];

            // Redirect berdasarkan role
            if ($user['role'] === 'admin') {
                header("Location: admin-uaspbw/1-menuaduan.php?user_id=" . urlencode($user_id));
            } else {
                header("Location: homemhs.php?user_id=" . urlencode($user_id));
            }
            exit;
        } else {
            echo "<center><h1>Email atau Password Anda Salah. Silahkan Coba Login Kembali.</h1>
                    <button><strong><a href='login.php'>Login</a></strong></button></center>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="script.js">
</head>

<body class="login-page">

    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
        
        <div class="col-md-6 left-panel d-none d-md-flex align-items-center justify-content-center">
            <div class="text-center">
                <h1 class="text-dark fw-bold">SiLapor!</h1>
                <img src="img/Frame-5.png" alt="SiLapor Logo" class="img-fluid mb-3" style="max-width: 660px;">
            </div>
        </div>
        
        
        <div class="col-md-6 p-5 right-panel d-flex align-items-center justify-content-center">
            <div class="form-wrapper w-100" style="max-width: 500px;">
                <h3 class="text-light fw-semibold mb-2 text-center">Welcome,</h3>
                <p class="text-white-50 text-center">Don't have an account? <a href="register.php" class="text-decoration-none text-acsent">Create Your Account.</a></p>

                <form class="mt-4" method="POST" action="">
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control form-control-lg custom-input" placeholder="Email" required>
                    </div>
                    <div class="mb-2">
                        <input type="password" name="password" class="form-control form-control-lg custom-input" placeholder="Password" required>
                    </div>
                    <div class="text-end mb-4">
                        <a href="#" class="text-white-50 small">Forgot Your Password?</a>
                    </div>
                    <button type="submit" id="loginBtn" class="btn btn-blue w-100 text rounded-pill fw-semibold d-block mx-auto text-light">Sign In</button>
                      
                </form>

                <div class="text-center my-3 text-white-50">— Or —</div>
                <div class="text-center">
                    <button class="btn btn-outline-light rounded-square shadow-sm">
                        <img src="img/icons8-google-48.png" alt="Google Login" style="width: 24px;">
                    </button>
                </div>
            </div> 
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
