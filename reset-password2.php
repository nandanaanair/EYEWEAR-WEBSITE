<?php
// session_start();
// include 'authenticate-user.php';
session_start();
// Verify if token is provided in the URL
if(isset($_GET['token'])) {
    $token = $_GET['token'];
    
    // Check if the token is valid by comparing it with the one stored in the session
    if(isset($_SESSION['reset_token']) && $_SESSION['reset_token'] === $token) {
        // Token is valid, allow access to reset password form
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
	<!-- Bootstrap 5 CDN Link -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom CSS Link -->
	<link rel="stylesheet" href="css/forgot-password.css">
</head>
<body> 
    <section class="wrapper">
		<div class="container">
			<div class="col-sm-8 offset-sm-2 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
				
				<form method="post" action="reset-password.php" class="rounded shadow p-5" style="background-color: rgba(250, 246, 242, 0.315);">
                    <div class="logo text-center">
                        <img decoding="async" src="logo.png"  alt="logo">
                    </div>
					<h3 class="fw-bolder fs-4 mb-3 text-center" style="color: rgb(255, 255, 255);">Reset Password</h3>

					<div class="fw-normal mb-4 text-center" style="color: bisque;">
						Enter a new password.
					</div>   

					<div class="form-floating mb-3">
                        <div>
                        <label for="floatingInput" style="color: white;" name="new_password">New Password</label>
						<input type="password" class="form-control" id="floatingInput"">
                        </div>
                        <br>
                        <div>   
						<label for="floatingInput" style="color: white;" name="confirm_password">Confirm Password</label>
                        <input name="new_password" type="password" class="form-control" id="floatingInput">
                        </div>
					</div>  
                    <div class="text-center">
					<button type="submit" class="btn submit_btn my-4" style="background-color:#2e180b; color: bisque;" >Submit</button>
                    </div>
				</form>
			</div>
		</div>
	</section>
</body>
</html>
<?php
    } else {
        // Token is invalid, deny access
        // echo "<script>window.location.href='login.html'</script>";
        echo "token invalid";
    }
} else {
    // Token is not provided, deny access
    // echo "<script>window.location.href='login.html'</script>";
    echo "token not provided";
}
?>

