<?php
session_start();
include "connect.php";

require 'phpmailer2/SMTP.php';
require 'phpmailer2/POP3.php';
require 'phpmailer2/PHPMailer.php';
require 'phpmailer2/Exception.php';
require 'phpmailer2/DSNConfigurator.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check for validation errors
    if (isset($_POST['validationErrors']) && !empty($_POST['validationErrors'])) {
        // Handle validation errors (if needed), or simply exit without any message
        exit();
    }

    // Generate OTP
    $otp = rand(100000, 999999);

    // Store OTP and user data in session
    $_SESSION['otp'] = $otp;
    $_SESSION['user_data'] = [
        'firstName' => $_POST['firstName'],
        'lastName' => $_POST['lastName'],
        'cust_email' => $_POST['cust_email'],
        'cust_phno' => $_POST['cust_phno'],
        'cust_password' => password_hash($_POST['cust_password'], PASSWORD_DEFAULT),
    ];

    // Send OTP via email using PHPMailer
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'editwithcharms@gmail.com'; // Replace with your Gmail email
        $mail->Password   = 'yomq apbp rkcq ktly'; // Use the App Password here
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('editwithcharms@gmail.com');
        $mail->addAddress($_POST['cust_email']);

        $mail->isHTML(true);
        $mail->Subject = 'Registration OTP';
        $mail->Body    = 'Your OTP for registration is: ' . $otp;

        $mail->send();
    } catch (Exception $e) {
        // Handle email sending error (if needed), or simply exit without any message
        exit();
    }

    // Redirect to verify-otp.html for OTP verification
    // header("Location: verify-otp.html");
    // echo "<script> window.location.href='verify-otp.html'</script>";
    echo "<script>window.location.href = 'verify-otp.html?success=1';</script>";
    exit();
} else {
    // Redirect to the registration form if accessed without form submission
    // header("Location: register.php");
    echo "<script> window.location.href='register.php'</script>";
    exit();
}
?>

