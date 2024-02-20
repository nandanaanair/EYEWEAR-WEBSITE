<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if (!isset($_SESSION['cust_email'])) {
        // Redirect to login page or handle the case when the user is not logged in
        echo "<script>window.location.href = 'login.php';</script>";
        exit();
    }

    // Get the updated quantity and product ID from the form submission
    $update_prod_id = $_POST['update_prod_id'];
    $new_quantity = $_POST['quantity'];

    // Validate the new quantity
    if (!is_numeric($new_quantity) || $new_quantity < 0 || floor($new_quantity) != $new_quantity) {
        // Handle invalid quantity (e.g., display an error message)
        echo "Invalid quantity";
        exit();
    }

    // Update the quantity of the product in the cart
    $sql = "UPDATE cart SET quantity = ? WHERE cust_email = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $new_quantity, $_SESSION['cust_email'], $update_prod_id);
    $stmt->execute();
    $stmt->close();

    // Close the database connection
    $conn->close();

    // Redirect back to the shopping cart page after updating the quantity
    echo "<script>window.location.href = 'shopping-cart.php';</script>";
    exit();
} else {
    // Handle invalid form submission method (e.g., direct access to the script)
    // Redirect or display an error message
    echo "<script>window.location.href = 'shopping-cart.php';</script>";
    exit();
}
?>
