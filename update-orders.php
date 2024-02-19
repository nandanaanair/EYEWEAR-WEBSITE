<?php
session_start();
include "connect.php";

// Check if the user is logged in as admin
// if (!isset($_SESSION['admin_email'])) {
//     // Redirect to the admin login page if not logged in
//     header("Location: admin-login.php");
//     exit();
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $orderID = $_POST["edit_order_id"];
    $orderStatus = $_POST["edit_order_status"];

    // Update order status in the database
    $stmt = $conn->prepare("UPDATE orders SET order_status = ? WHERE order_id = ?");
    $stmt->bind_param("si", $orderStatus, $orderID);

    if ($stmt->execute()) {
        // Redirect to the order list page after successful update
        // header("Location: list-orders.php");
        echo "<script> window.location.href='list-orders.php'</script>";
        exit();
    } else {
        // Handle the update failure (you might want to log the error)
        echo "Error updating order status. Please try again later.";
    }

    $stmt->close();
}

$conn->close();
?>
