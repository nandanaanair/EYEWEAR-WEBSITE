<?php
// Start session
session_start();
include "connect.php";

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['cust_email']);
}

// Function to restrict access to logged-in users
function requireLogin() {
    if (!isLoggedIn()) {
        // header("Location: login.php"); // Redirect to login page if user is not logged in
        echo "<script>window.location.href='login.html'</script>";
        exit();
    }
}
?>
