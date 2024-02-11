<?php
session_start();
include "connect.php";

// Generate random order ID
$order_id = mt_rand(100000, 999999);

// Get current date and time
$order_date = date("Y-m-d H:i:s");

// Retrieve product price from session
$total_price = $_SESSION['prod_price'];

// Retrieve customer email from session
$cust_email = $_SESSION['cust_email'];

// Retrieve product ID from session
$prod_id = $_SESSION['prod_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $order_bldg = $_POST["order_bldg"] ?? '';
    $order_city = $_POST["order_city"] ?? '';
    $order_state = $_POST["order_state"] ?? '';
    $order_pincode = $_POST["order_pincode"] ?? '';
    

    // Prepare and execute SQL statement to insert data into orders table
    $sql = "INSERT INTO orders (order_id, order_date, order_bldg, order_city, order_state, order_pincode, total_price, cust_email, prod_id) 
            VALUES ('$order_id', '$order_date', '$order_bldg', '$order_city', '$order_state', '$order_pincode', '$total_price', '$cust_email', '$prod_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Order placed successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
// Close database connection
$conn->close();
?>