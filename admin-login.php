<?php
session_start();
include "connect.php";

// Check if admin is already logged in
if (isset($_SESSION['admin_email'])) {
    header("Location: home.html");
    exit();
}

if (isset($_POST['admin_email']) && isset($_POST['admin_password'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = validate($_POST['admin_email']);
    $pass = validate($_POST['admin_password']);

    // Use parameterized query to prevent SQL injection
    $sql = "SELECT admin_email, admin_password FROM admin WHERE admin_email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $fetchedEmail, $storedPassword);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($fetchedEmail === $email && $pass === $storedPassword) {
        echo "Admin Logged in!";
        // $_SESSION['admin_email'] = $fetchedEmail;
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
</head>
<body>
    <!-- Your HTML body content here -->
    <header>
        <h4 class="logo">
            <a href="index.html" id="logoLink"> O⌄O VisionVibes </a>
        </h4>
    </header>
    <section class="background-radial-gradient overflow-hidden">
        <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
            <div class="row gx-lg-5 align-items-center mb-5">
                <div class="col-lg-6 offset-md-3">
                    <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
                    <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>
                    <div class="card bg-glass" style="background-color:rgba(250, 246, 242, 0.315);">
                        <div class="card-body px-4 py-4 px-md-5">
                            <form action="admin-login.php" method="post">
                                <div class="row">
                                    <div class="col-md-6 mb-4"></div>
                                    <div class="col-md-6 mb-4"></div>
                                </div>
                                <div class="form-outline mb-4">
                                    <label for="admin_email"></label>
                                    <input type="email" id="emailID" class="inputFields" placeholder="Email*" name="admin_email" required/>
                                </div>
                                <div class="form-outline mb-4">
                                    <label for="admin_password"></label>
                                    <input type="password" id="passwordID" class="inputFields" placeholder="Password* " name="admin_password" required/>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary btn-block mb-4" id="brownBtn">Login</button>
                                <div>
                                    <p class="mb-2" id="forPas"> <a href="forgot-password.html" id="AltLink">Forgot Password?</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
