<?php
// Start the session
session_start();

// Function to remove a product from the cart
function removeProduct($cart, $removeProdId) {
    foreach($cart as $key => $item) {
        if($item['prod_id'] == $removeProdId) {
            unset($cart[$key]); // Remove the product from the cart array
            break;
        }
    }
    return $cart;
}

// Check if the remove product action is triggered
if(isset($_POST['remove_prod_id']) && !empty($_POST['remove_prod_id'])) {
    // Retrieve the product ID to remove
    $removeProdId = $_POST['remove_prod_id'];

    // Check if cart session variable exists and is not empty
    if(isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        // Get the cart from the session
        $cart = $_SESSION['cart'];

        // Remove the product from the cart
        $cart = removeProduct($cart, $removeProdId);

        // Update the cart session variable
        $_SESSION['cart'] = $cart;
    }

    // Redirect back to the cart page to reflect changes
    // header("Location: cart.php");
    echo "<script>window.location.href = 'cart.php';</script>";
    exit();
} else {
    // Redirect to an error page or handle the error accordingly
    // header("Location: error.php");
    echo "<script>window.location.href = 'error.php';</script>";
    exit();
}
?>
