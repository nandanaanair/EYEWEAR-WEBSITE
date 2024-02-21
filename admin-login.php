<?php
session_start();

$admin_email = "visionvibesadmin@gmail.com";
$admin_password = "admin";

if (isset($_POST['admin_email']) && isset($_POST['admin_password'])) {
    $email = $_POST['admin_email'];
    $pass = $_POST['admin_password'];

    // Check if the provided email and password match the admin credentials
    if ($email === $admin_email && $pass === $admin_password) {
        // Store admin email in session
        $_SESSION['admin_email'] = $email;
        // Redirect to admin home page
        header("Location: admin-home.php");
        exit();
    } else {
        echo "Incorrect email or password";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login-register.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="js/script.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <title>Login</title>
    <style>
        .error-message {
      color: rgb(255, 176, 176);
      font-size: 14px;
      margin-top: 5px;
      }
    </style>
</head>
<body>
    <!-- Your HTML body content here -->
    <header>
        <h4 class="logo">
            <a href="index.php" id="logoLink"> O⌄O VisionVibes </a>
        </h4>
    </header>
    <section class="background-radial-gradient overflow-hidden">
        <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
            <div class="row gx-lg-5 align-items-center mb-5">
                <div class="col-lg-6 offset-md-3">
                    <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
                    <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>
                    <div class="card bg-glass" style="background-color:rgba(250, 246, 242, 0.315);">
                        <div class="card-body px-4 py-5 px-md-5">
                            <form action="admin-login.php" method="post" novalidate>
                                <div class="row">
                                    <div class="col-md-6 mb-4"></div>
                                    <div class="col-md-6 mb-4"></div>
                                </div>
                                <div class="form-outline mb-4">
                                    <label for="admin_email"></label>
                                    <input type="email" id="emailID" class="inputFields" placeholder="Email*" name="admin_email" required/>
                                    <div id="emailError" class="error-message"></div>
                                </div>
                                <div class="form-outline mb-4">
                                    <label for="admin_password"></label>
                                    <input type="password" id="passwordID" class="inputFields" placeholder="Password* " name="admin_password" required/>
                                    <div id="passwordError" class="error-message"></div>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary btn-block mb-4" id="brownBtn">Login</button>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
          const email = document.getElementById('emailID');
          const emailError = document.getElementById('emailError');
          const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
          const password = document.getElementById('passwordID');
          const passwordError = document.getElementById('passwordError');
    
          email.addEventListener('input', function () {
              if (email.value.trim() === '') {
                  emailError.textContent = 'Email is required.';
              } else if (!emailRegex.test(email.value)) {
                  emailError.textContent = 'Enter a valid email address.';
              } else {
                  emailError.textContent = '';
              }
          });
    
          password.addEventListener('input', function () {
              if (password.value.trim() === '') {
                  passwordError.textContent = 'Password is required.';
              } else {
                  passwordError.textContent = '';
              }
          });
      });
    </script>
</body>
</html>
