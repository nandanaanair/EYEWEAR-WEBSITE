<?php
// Start the session
session_start();

// Include database connection
include "connect.php";

// Check if the cart session variable exists and is not empty
if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Initialize an array to store cart item details
    $cartData = array();

    // Loop through each item in the cart
    foreach($_SESSION['cart'] as $prod_id => $item) {
        // Fetch product details from the database
        $product = getProductDetails($prod_id);

        // If product details are found, add them to the cart data array
        if($product) {
            // Add product details to cart data array
            $cartData[] = array(
                'prod_id' => $prod_id,
                'prod_name' => $product['prod_name'],
                'prod_description' => $product['prod_description'],
                'prod_image' => $product['prod_image'], // Assuming this is the image URL
                // Add any other product details you need
            );
        }
    }

    // Encode the cart data array as JSON and send it to the client
    echo json_encode($cartData);
} else {
    // If the cart is empty, send an empty JSON array
    echo json_encode(array());
}

// Function to fetch product details from the database
function getProductDetails($prod_id) {
    global $conn;
    // Adjust the query based on your database schema
    $sql = "SELECT * FROM products WHERE prod_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $prod_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
    return $product;
}
?>
