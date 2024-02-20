<?php
session_start();
include "connect.php"; // Include your database connection file

// Check if the product ID is provided via POST
if(isset($_POST['prod_id'])) {
    $prod_id = $_POST['prod_id'];
    
    // Insert the product ID and user's email (if applicable) into the cart table
    $cust_email = isset($_SESSION['cust_email']) ? $_SESSION['cust_email'] : null; // Assuming user email is stored in session
    $query = "INSERT INTO cart (cust_email, product_id, quantity) VALUES (?, ?, 1)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $cust_email, $prod_id);
    $stmt->execute();
    $stmt->close();

    // Redirect back to the product page with a success message
    // header("Location: product-details.php?id=$prod_id&success=1");
    echo "<script>window.location.href = 'product-details.php?id=$prod_id&success=1';</script>";
    exit();
} else {
    // If product ID is not provided via POST, redirect back with an error message
    // header("Location: product-page.php?error=1");
    echo "<script>window.location.href = 'product-details.php?id=$prod_id&error=1';</script>";
    exit();
}
?>
