<?php
session_start();
include "connect.php";

// Fetch the count of items in the cart from the database
$cust_email = $_SESSION['cust_email'] ?? ''; // Retrieve customer email from session
$cart_count = 0;

if ($cust_email) {
    $cart_sql = "SELECT SUM(quantity) AS total_items FROM cart WHERE cust_email = '$cust_email'";
    $cart_result = $conn->query($cart_sql);

    if ($cart_result && $cart_result->num_rows > 0) {
        $cart_data = $cart_result->fetch_assoc();
        $cart_count = $cart_data['total_items'];
    }
}

// Output the cart count
echo $cart_count;
?>
