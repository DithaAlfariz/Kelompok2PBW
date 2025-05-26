<?php
require 'koneksi.php';

// Fungsi untuk generate random id unik (misal 10 karakter alfanumerik)
function generateRandomId($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomId = '';
    for ($i = 0; $i < $length; $i++) {
        $randomId .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomId;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $repeat_password = $_POST["repeat_password"];

    if ($password !== $repeat_password) {
        echo "<script>alert('Password dan Repeat Password tidak sama!');window.location.href='register.php';</script>";
        exit;
    }

    // Generate random id dan pastikan unik
    do {
        $id = generateRandomId();
        $check = mysqli_query($conn, "SELECT id FROM table_user WHERE id = '$id'");
    } while(mysqli_num_rows($check) > 0);

    // Set role as 'mahasiswa' automatically
    $role = 'mahasiswa';

    // Simpan id, email, dan password ke database dengan role
    $query_sql = "INSERT INTO table_user (id, username, email, password, role) VALUES ('$id', '$username', '$email', '$password', '$role')";

    if (mysqli_query($conn, $query_sql)) {
        header("Location: login.php");
        exit;
    } else {
        echo "Pendaftaran Gagal : " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="css/style.css"/>
</head>

<body class="register-page">

    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
        
        <div class="col-md-6 left-panel d-none d-md-flex align-items-center justify-content-center">
            <div class="text-center">
                <h1 class="text-dark fw-bold">SiLapor!</h1>
                <img src="img/Frame-5.png" alt="SiLapor Logo" class="img-fluid mb-3" style="max-width: 660px;">
            </div>
        </div>
        
        
        <div class="col-md-6 p-5 right-panel d-flex align-items-center justify-content-center">
            <div class="form-wrapper w-100" style="max-width: 500px;">
                <h3 class="text-light fw-semibold mb-2 text-center">Create Account,</h3>
                <p class="text-white-50 text-center">Have an account? <a href="login.php" class="text-decoration-none text-acsent">Sign In</a></p>

                <form class="mt-4" method="POST" action="#">
                    <div class="mb-3">
                      <input type="username" name="username" id="username" class="form-control form-control-lg custom-input" placeholder="Username" required />
                    </div>

                    <div class="mb-3">
                      <input type="email" name="email" id="email" class="form-control form-control-lg custom-input" placeholder="Email" required />
                    </div>
            
                    <div class="mb-3">
                      <input type="password" name="password" id="password" class="form-control form-control-lg custom-input" placeholder="Password" required />
                    </div>
            
                    <div class="mb-4">
                      <input type="password" name="repeat_password" id="repeat_password" class="form-control form-control-lg custom-input" placeholder="Repeat Password" required />
                    </div>
            
                    <button type="submit" class="btn btn-blue w-100 rounded-pill fw-semibold text-light">Create Account</button>
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
