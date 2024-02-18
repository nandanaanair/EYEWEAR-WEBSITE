<?php
session_start();
include "connect.php";

// Retrieve payment details from the request body
$request_body = file_get_contents('php://input');
$payment_data = json_decode($request_body, true);

// Retrieve necessary payment details
$trans_id = $payment_data['trans_id'] ?? '';
$payment_type = $payment_data['payment_type'] ?? '';
$payment_date = $payment_data['payment_date'] ?? '';
$payment_amt = isset($payment_data['payment_amt']) ? floatval($payment_data['payment_amt']) : 0; // Convert to float if present
$cust_email = $payment_data['cust_email'] ?? '';
// Retrieve the order ID from the session
if (isset($_SESSION['order_id'])) {
    $order_id = $_SESSION['order_id'];
} else {
    // Handle error: order ID not found in session
}

// Validate if all necessary data is present
if (!$trans_id || !$payment_type || !$payment_date || !$payment_amt || !$cust_email || !$order_id) {
    echo json_encode(array("success" => false, "error" => "Missing payment details"));
    exit; // Terminate the script
}

// Prepare and execute SQL statement to insert data into payment table
$sql = "INSERT INTO payment (trans_id, payment_type, payment_date, payment_amt, cust_email, order_id) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $trans_id, $payment_type, $payment_date, $payment_amt, $cust_email, $order_id);

if ($stmt->execute()) {
    // Call process-order.php upon successful payment
    $processOrderUrl = "process-order.php?order_id=$order_id"; // Assuming you pass the order ID to process-order.php
    $response = file_get_contents($processOrderUrl);

    if ($response === false) {
        // Error handling if the call to process-order.php fails
        echo json_encode(array("success" => false, "error" => "Error processing order"));
    } else {
        // Process the response from process-order.php
        // This could include confirmation messages or further actions based on the response
        echo json_encode(array("success" => true, "message" => "Order processed successfully"));
    }
} else {
    echo json_encode(array("success" => false, "error" => "Failed to store payment details"));
}

// Close statement and database connection
$stmt->close();
$conn->close();
?>
