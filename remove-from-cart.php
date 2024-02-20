<?php
session_start();
include 'connect.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_prod_id'])) {
    // Get the product ID to remove
    $prod_id = $_POST['remove_prod_id'];

    // Remove the product from the cart
    $cust_email = isset($_SESSION['cust_email']) ? $_SESSION['cust_email'] : null; // Assuming customer email is stored in session
    if ($cust_email) {
        // Prepare and execute the DELETE query
        $sql = "DELETE FROM cart WHERE cust_email = ? AND product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $cust_email, $prod_id);
        $stmt->execute();
        $stmt->close();
    }

    // Redirect back to the cart page
    // header("Location: shopping-cart.php");
    echo "<script>window.location.href = 'shopping-cart.php';</script>";
    exit();
} else {
    // Redirect to the cart page if the form was not submitted
    // header("Location: shopping-cart.php");
    echo "<script>window.location.href = 'shopping-cart.php';</script>";
    exit();
}
?>
