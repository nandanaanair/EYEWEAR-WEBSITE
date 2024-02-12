<?php
session_start();
include "connect.php";

// Add product to cart if prod_id is provided via POST
if(isset($_POST['prod_id'])) {
    $prod_id = $_POST['prod_id'];

    // Fetch product details from database
    $product = getProductDetails($prod_id);

    // If product details are retrieved successfully, add it to the cart
    if($product) {
        addToCart($product);
        // Store cart details in local storage
        storeCartInLocalStorage($_SESSION['cart']);
        // Redirect back to the product details page with a success message
        // echo "<meta http-equiv='refresh' content='0;url=product-details.php?id=$prod_id&success=1'>";
        echo "<script>window.location.href='product-details.php?id=$prod_id&success=1'</script>";
        exit();
    } else {
        // If product is not found in the database, redirect back with an error message
        redirectWithError($prod_id, 1);
    }
} else {
    // If prod_id is not provided via POST, redirect back with an error message
    redirectWithError($prod_id, 2);
}

// Function to fetch product details from the database
function getProductDetails($prod_id) {
    global $conn;
    $sql = "SELECT * FROM products WHERE prod_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $prod_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
    return $product;
}

// Function to add product to cart in session
function addToCart($product) {
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    $_SESSION['cart'][$product['prod_id']] = $product;
}

// Function to store cart details in local storage
function storeCartInLocalStorage($cart) {
    echo "<script>localStorage.setItem('cart', JSON.stringify(".json_encode($cart)."));</script>";
}

// Function to redirect back to the product details page with an error message
function redirectWithError($prod_id, $error_code) {
    // echo "<meta http-equiv='refresh' content='0;url=product-details.php?id=$prod_id&error=$error_code'>";
    echo "<script>window.location.href='product-details.php?id=$prod_id&error=1'</script>";
    exit();
}
?>
