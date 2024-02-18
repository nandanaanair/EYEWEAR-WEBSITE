<?php
session_start();

// Generate the order ID if it doesn't exist in the session
if (!isset($_SESSION['order_id'])) {
    $_SESSION['order_id'] = mt_rand(100000, 999999);
}

// Echo or return the generated order ID
echo $_SESSION['order_id'];
?>
