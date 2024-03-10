<?php
session_start();
include "connect.php"; // Include your database connection file
// Check if the user is logged in
if (!isset($_SESSION['cust_email'])) {
    echo "<script> window.location.href='index.html'</script>";
    exit();
}


if(isset($_POST['prod_id'])) {
    $prod_id = $_POST['prod_id'];
} elseif(isset($_GET['id'])) {
    $prod_id = $_GET['id'];
} else {
    // // If product ID is not provided via POST or URL, redirect back with an error message
    // echo "<script>window.location.href = 'product-page.php?error=1';</script>";
    exit();
}

// Retrieve the product category from the database
$query = "SELECT prod_category FROM products WHERE prod_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $prod_id);
$stmt->execute();
$stmt->bind_result($prod_category);
$stmt->fetch();
$stmt->close();

// Determine the redirect page based on the type of product
if ($prod_category == 'eyeglass') {
    $redirect_page = 'eyeglasses-prod.php';
} elseif ($prod_category == 'sunglass') {
    $redirect_page = 'sunglasses-prod.php';
} elseif ($prod_category == 'screen_glass') {
    $redirect_page = 'screenglasses-prod.php';
} else {
    // Default redirection if type is not recognized
    $redirect_page = 'all-products.php';
}

// Insert the product ID and user's email (if applicable) into the cart table
$cust_email = isset($_SESSION['cust_email']) ? $_SESSION['cust_email'] : null; // Assuming user email is stored in session
$query = "INSERT INTO cart (cust_email, product_id, quantity) VALUES (?, ?, 1)";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $cust_email, $prod_id);
$stmt->execute();
$stmt->close();

// Redirect back to the appropriate page with a success message
echo "<script>window.location.href = '$redirect_page?success=1';</script>";
exit();
?>
