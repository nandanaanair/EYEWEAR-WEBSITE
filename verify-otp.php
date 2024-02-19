<?php

session_start();

// Check if the user data and OTP are in the session
if (!isset($_SESSION['otp'], $_SESSION['user_data'])) {
    // Redirect to register.html if accessed without proper context
    // header("Location: register.html");
    echo "<script> window.location.href='register.html'</script>";
    exit();
}

// Extract user data and OTP from the session
$userData = $_SESSION['user_data'];
$otp = $_SESSION['otp'];

// Clear unnecessary session variables
unset($_SESSION['otp']);
unset($_SESSION['user_data']);

// Check if the entered OTP matches the stored OTP
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['entered_otp'])) {
    $enteredOTP = $_POST['entered_otp'];

    if ($enteredOTP == $otp) {
        // OTP is verified, store the user data in the database
        include "connect.php";

        // Perform database insertion here using $userData
        // For example, inserting into the "customer" table
        $stmt = $conn->prepare('INSERT INTO customer (firstName, lastName, cust_email, cust_phno, cust_password) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('sssss', $userData['firstName'], $userData['lastName'], $userData['cust_email'], $userData['cust_phno'], $userData['cust_password']);
        $stmt->execute();
        $stmt->close();

        // Redirect to a success page or login page
        // header("Location: login.html");
        // echo "<script> window.location.href='login.html'</script>";
        echo "<script>window.location.href='login.html?success=1';</script>";
        exit();
    } else {
        // Incorrect OTP, redirect back to verify-otp.html
        // header("Location: verify-otp.html");
        // echo "<script> window.location.href='verify-otp.html'</script>";
        echo "<script>window.location.href='verify-otp.html?error=1';</script>";
        exit();
    }
} else {
    // Redirect to verify-otp.html if accessed without proper form submission
    // header("Location: verify-otp.html");
    echo "<script> window.location.href='register.html'</script>";
    exit();
}

?>
