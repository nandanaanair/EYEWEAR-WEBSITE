<?php
session_start(); // Ensure session is started
include "connect.php";

function isLoggedIn() {
    return isset($_SESSION['cust_email']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        // Redirect to login page if user is not logged in
        echo "<script>window.location.href='index.php'</script>";
        exit();
    } 
}


// Call requireLogin() function
requireLogin();

?>
