<?php
session_start();
include "connect.php";

// Check if the product ID is provided via POST
if(isset($_POST['prod_id'])) {
    $prod_id = $_POST['prod_id'];

    // Check if the product ID is valid and exists in the database
    $sql = "SELECT * FROM products WHERE prod_id = '$prod_id'";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        // Check if the shopping cart session variable exists, if not, initialize it
        if(!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Add the selected product to the shopping cart
        $_SESSION['cart'][$prod_id] = $product;

        // Redirect back to the product details page with a success message
        // header("Location: product-details.php?id=$prod_id&success=1");
        echo "<script>window.location.href='product-details.php?id=$prod_id&success=1'</script>";

        exit();
    } else {
        // Product not found in the database, redirect back to the product details page with an error message
        // header("Location: product-details.php?id=$prod_id&error=1");
        echo "<script>window.location.href='product-details.php?id=$prod_id&error=1'</script>";

        exit();
    }
} else {
    // Redirect back to the product details page if product ID is not provided
    // header("Location: product-details.php?error=2");
    echo "<script>window.location.href='product-details.php?id=$prod_id&error=2'</script>";
    exit();
}
?>
