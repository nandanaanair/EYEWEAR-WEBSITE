<?php
session_start();

// Check if the user is authenticated (OTP verified)
// if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
//     // Redirect to the OTP verification page if not authenticated
//     header("Location: send-otp.html");
//     exit();
// }

// Reset password logic goes here
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you have a database connection
    include "connect.php";

    // Initialize error message
    $error_message = '';

    // Validate and sanitize the new password (add more validation as needed)
    $newPassword = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';

    if (empty($newPassword)) {
        $error_message = 'Please enter a new password.';
    } else {
        // Hash the new password before storing it in the database
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the user's password in the database
        $email = $_SESSION['cust_email']; // Assuming you stored the user's email during OTP verification
        $updateQuery = "UPDATE customer SET cust_password = ? WHERE cust_email = ?";
        
        if ($stmt = $conn->prepare($updateQuery)) {
            $stmt->bind_param('ss', $hashedPassword, $email);
            $stmt->execute();

            // Redirect to a success page or login page
            header("Location: login.html");
            exit();
        } else {
            $error_message = 'Error updating the password.';
        }
    }
}
?>
