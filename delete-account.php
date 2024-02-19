<?php
session_start();
include "connect.php";

// Check if the user is logged in
if (!isset($_SESSION['cust_email'])) {
    // Redirect to the login page if not logged in
    header("Location: login.html");
    exit();
}

// Assuming you have cust_email stored in the session after login
$cust_email = $_SESSION['cust_email'];

// Delete the user account from the database
$stmt = $conn->prepare("DELETE FROM customer WHERE cust_email = ?");
$stmt->bind_param("s", $cust_email);

if ($stmt->execute()) {
    // Account deleted successfully, redirect to the login page
    session_destroy(); // Clear the session data
    // header("Location: login.html");
    echo "<script>window.location.href = 'login.html?success=2';</script>";
    exit();
} else {
    // Handle the deletion failure (you might want to log the error)
    echo "Error deleting the account. Please try again later.";
}

// Close the database connection
$stmt->close();
$conn->close();
?>
