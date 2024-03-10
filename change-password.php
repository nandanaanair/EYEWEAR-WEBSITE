<?php
include 'authenticate-user.php';
requireLogin();
?>
<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Assuming you have stored customer information in a session, you can retrieve the customer's email
    $cust_email = $_SESSION['cust_email'];

    // Verify if new password and confirm password match
    if ($new_password !== $confirm_password) {
        // echo "<script>alert('New password and confirm password do not match.');</script>";
        echo "<script>window.location.href = 'change-password.php?error=3';</script>";
        exit; // Exit if passwords don't match
    }

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Check if the current password matches the password stored in the database
    $sql = "SELECT cust_password FROM customer WHERE cust_email = '$cust_email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $stored_password = $row['cust_password'];
        
        // Verify if the entered current password matches the stored password
        if (password_verify($current_password, $stored_password)) {
            // Update the password in the database
            $update_sql = "UPDATE customer SET cust_password = '$hashed_password' WHERE cust_email = '$cust_email'";
            if (mysqli_query($conn, $update_sql)) {
                // echo "<script>alert('Password updated successfully.');</script>";
                echo "<script>window.location.href = 'user-profile.php?success=1';</script>";
            } else {
                // echo "<script>alert('Error updating password.');</script>";
                echo "<script>window.location.href = 'change-password.php?error=1';</script>";
            }
        } else {
            // echo "<script>alert('Current password is incorrect.');</script>";
            echo "<script>window.location.href = 'change-password.php?error=2';</script>";
        }
    } else {
        echo "<script>alert('User not found.');</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/apptmt.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="js/script.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <title>Contact Us</title>
    <style>
        .message {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .success {
            background-color: #7caf4c;
            color: white;
        }
        .error {
            background-color: #943726;
            color: white;
        }
    </style>
    <script>
        window.onload = function() {
            var urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('error') && urlParams.get('error') == '1') {
                displayMessage("Error updating password. Please Try again.", "error");
            }
            if (urlParams.has('error') && urlParams.get('error') == '2') {
                displayMessage("Current password is incorrect.", "error");
            }
            if (urlParams.has('error') && urlParams.get('error') == '3') {
                displayMessage("New password and confirm password do not match", "error");
            }
        };

        function displayMessage(message, type) {
            var messageContainer = document.createElement('div');
            messageContainer.textContent = message;
            messageContainer.classList.add('message', type);
            document.body.insertBefore(messageContainer, document.body.firstChild);
            setTimeout(function() {
                messageContainer.remove();
            }, 5000); 
        }

    </script>
    
<style>
    .error-message {
        color: rgb(255, 176, 176);
        font-size: 14px;
        margin-top: 5px;
    }
</style>
</head>
<body>
    <!-- Navigation Bar -->
    <?php
    include 'nav.php';
    ?>

<div class="container mt-5 mb-5 d-flex flex-column align-items-center" >
    <div id="apptmt-head" class="mb-4">Change Password</div>
    
    <form action="change-password.php" method="post" class="card px-1 py-4" style="background-color: rgba(250, 246, 242, 0.315);" novalidate>
        <div class="card-body" style="color: white;">
            <h6 style="font-weight: 700; font-size: large;">Current Password</h6>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <!-- Use textarea instead of input for multiline text -->
                        <input type="password" class="form-control" name="current_password" id="current_password"></input>
                        <div id="messageError" class="error-message"></div>
                    </div>
                </div>
            </div><br>
            <h6 style="font-weight: 700; font-size: large;">New Password</h6>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <!-- Use textarea instead of input for multiline text -->
                        <input type="password" class="form-control" name="new_password" id="new_password"></input>
                        <div id="messageError" class="error-message"></div>
                    </div>
                </div>
            </div><br>
            <h6 style="font-weight: 700; font-size: large;">Confirm Password</h6>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <!-- Use textarea instead of input for multiline text -->
                        <input type="password" class="form-control" name="confirm_password" id="confirm_password"></input>
                        <div id="messageError" class="error-message"></div>
                    </div>
                </div>
            </div><br>
            <button class="btn btn-block confirm-button" id="brownBtn">Confirm</button>
        </div>
    </form>
</div>
</body>
</html>
