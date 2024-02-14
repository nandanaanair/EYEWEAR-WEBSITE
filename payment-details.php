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
// $payment_amt = $payment_data['payment_amt'] ?? '';
$payment_amt = isset($payment_data['payment_amt']) ? floatval($payment_data['payment_amt']) : 0; // Convert to float if present
$cust_email = $payment_data['cust_email'] ?? '';
$order_id = $payment_data['order_id'] ?? '';

// Validate if all necessary data is present
if (!$trans_id || !$payment_type || !$payment_date || !$payment_amt || !$cust_email || !$order_id) {
    echo json_encode(array("success" => false, "error" => "Missing payment details"));
    exit; // Terminate the script
}

// Prepare and execute SQL statement to insert data into payment table
$sql = "INSERT INTO payment (trans_id, payment_type, payment_date, payment_amt, cust_email, order_id) 
        VALUES ('$trans_id', '$payment_type', '$payment_date', '$payment_amt', '$cust_email', '$order_id')";

if ($conn->query($sql) === TRUE) {
    echo "stored";
} else {
    echo "failed";
}

// Close database connection
$conn->close();
?>
