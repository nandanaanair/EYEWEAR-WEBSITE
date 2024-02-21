<?php
session_start();
include "connect.php";

$order_date = date("Y-m-d H:i:s");
$total_price = $_SESSION['prod_price'];
$cust_email = $_SESSION['cust_email'];
$prod_id = $_SESSION['prod_id'];
// Retrieve the order ID from the session
if (isset($_SESSION['order_id'])) {
    $order_id = $_SESSION['order_id'];
} else {
    // Handle error: order ID not found in session
}

// Set session variables for customer email and order ID
$_SESSION['cust_email'] = $cust_email;
$_SESSION['order_id'] = $order_id;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $order_bldg = $_POST["order_bldg"] ?? '';
    $order_city = $_POST["order_city"] ?? '';
    $order_state = $_POST["order_state"] ?? '';
    $order_pincode = $_POST["order_pincode"] ?? '';

    // Prepare and execute SQL statement to insert data into orders table
    $sql = "INSERT INTO orders (order_id, order_date, order_bldg, order_city, order_state, order_pincode, total_price, cust_email) 
            VALUES ('$order_id', '$order_date', '$order_bldg', '$order_city', '$order_state', '$order_pincode', '$total_price', '$cust_email')";

    if ($conn->query($sql) === TRUE) {
        // Now, let's move the cart items to the order_details table
        // Retrieve cart items from the cart table
        $cartItemsQuery = "SELECT * FROM cart WHERE cust_email = '$cust_email'";
        $cartItemsResult = $conn->query($cartItemsQuery);
        if ($cartItemsResult->num_rows > 0) {
            while ($row = $cartItemsResult->fetch_assoc()) {
                $prod_id = $row['product_id'];
                $quantity = $row['quantity'];
                $price = $row['price'];
                
                // Insert cart item into order_details table
                $orderDetailsInsert = "INSERT INTO order_details (order_id, prod_id, quantity, price) VALUES ('$order_id', '$prod_id', '$quantity', '$price')";
                $conn->query($orderDetailsInsert);
            }
            // After moving cart items to order_details, you can delete them from the cart table
            $deleteCartItemsQuery = "DELETE FROM cart WHERE cust_email = '$cust_email'";
            $conn->query($deleteCartItemsQuery);
        }
        // Redirect to success page or any other page as needed
        echo "<script>window.location.href='success.php'</script>";
    } else {
        // Handle error case
        echo "<script>window.location.href='error.php'</script>";
    }
}

// Close database connection
$conn->close();
?>







if ($conn->query($sql) === TRUE) {
        // echo "Order placed successfully.";
        echo "<script>window.location.href='product-details.php?id=$prod_id&success=2'</script>";
    } else {
        echo "<script>window.location.href='product-details.php?id=$prod_id&error=3'</script>";
    }