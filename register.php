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
