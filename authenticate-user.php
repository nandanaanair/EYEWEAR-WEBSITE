<?php
session_start(); // Ensure session is started
include "connect.php";

function isLoggedIn() {
    return isset($_SESSION['cust_email']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        // Redirect to login page if user is not logged in
        echo "<script>window.location.href='index.html'</script>";
        exit();
    } elseif(basename($_SERVER['PHP_SELF']) !== 'home.php' && basename($_SERVER['PHP_SELF']) !== 'index.html') {
        // Redirect to home page if user is logged in and not already on home.php or index.html
        echo "<script>window.location.href='home.php'</script>";
        exit();
    }
}


// Call requireLogin() function
requireLogin();

?>
