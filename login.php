<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="js/script.js">
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

                <form class="mt-4" method="POST" action="javascript:void(0);">
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