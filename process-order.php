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
    // Fetch the order details from the checkout form
    $order_bldg = $_POST["order_bldg"] ?? '';
    $order_city = $_POST["order_city"] ?? '';
    $order_state = $_POST["order_state"] ?? '';
    $order_pincode = $_POST["order_pincode"] ?? '';

    // Retrieve the order ID from the session
    $order_id = $_SESSION['order_id'];

    // Insert order details into the orders table
    $sql = "INSERT INTO orders (order_id, order_date, order_bldg, order_city, order_state, order_pincode, total_price, cust_email) 
            VALUES ('$order_id', NOW(), '$order_bldg', '$order_city', '$order_state', '$order_pincode', '{$_SESSION['total_price']}', '{$_SESSION['cust_email']}')";
    if ($conn->query($sql) === TRUE) {
        // Order placed successfully
    } else {
        // Handle error
    }

    // Fetch cart items from the database for the current user
    $cust_email = $_SESSION['cust_email'];
    $sql = "SELECT * FROM cart WHERE cust_email = '$cust_email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Iterate through each cart item
        while($row = $result->fetch_assoc()) {
            $product_id = $row['product_id'];
            $quantity = $row['quantity'];

            // Retrieve product details (name and price) from the products table
            $product_sql = "SELECT prod_name, prod_price FROM products WHERE prod_id = '$product_id'";
            $product_result = $conn->query($product_sql);

            if ($product_result->num_rows > 0) {
                $product_row = $product_result->fetch_assoc();
                $prod_name = $product_row['prod_name'];
                $prod_price = $product_row['prod_price'];

                // Insert product details into the order_details table
                $insert_sql = "INSERT INTO order_details (order_id, prod_id, prod_name, price, quantity) 
                               VALUES ('$order_id', '$product_id', '$prod_name', '$prod_price', '$quantity')";
                if ($conn->query($insert_sql) !== TRUE) {
                    // Handle error
                }
            }
        }

        // Clear the cart after shifting cart details to order details
        $delete_sql = "DELETE FROM cart WHERE cust_email = '$cust_email'";
        if ($conn->query($delete_sql) !== TRUE) {
            // Handle error
        }
    }

    // Retrieve the prescription details from the form
    $l_sph = $_POST['l_sph'];
    $r_sph = $_POST['r_sph'];
    $l_cyl = $_POST['l_cyl'];
    $r_cyl = $_POST['r_cyl'];
    $l_axis = $_POST['l_axis'];
    $r_axis = $_POST['r_axis'];
    $l_addn = $_POST['l_addn'];
    $r_addn = $_POST['r_addn'];

    // Check if all prescription fields are empty
    if (!empty($l_sph) || !empty($r_sph) || !empty($l_cyl) || !empty($r_cyl) || !empty($l_axis) || !empty($r_axis) || !empty($l_addn) || !empty($r_addn)) {
        // Insert prescription details into the prescription table
        $stmt = $conn->prepare("INSERT INTO prescription (order_id, l_sph, r_sph, l_cyl, r_cyl, l_axis, r_axis, l_addn, r_addn) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssssss", $order_id, $l_sph, $r_sph, $l_cyl, $r_cyl, $l_axis, $r_axis, $l_addn, $r_addn);

        // Check if the statement executed successfully
        if ($stmt->execute()) {
            // Redirect to the success page
            echo "<script>window.location.href='product-details.php?id=$prod_id&success=2'</script>";
        } else {
            // Handle error
            echo "<script>window.location.href='product-details.php?id=$prod_id&error=3'</script>";
        }

        // Close the statement and database connection
        $stmt->close();
    } else {
        // Redirect to the success page as prescription fields are empty
        echo "<script>window.location.href='product-details.php?id=$prod_id&success=2'</script>";
    }
}

// Close database connection
$conn->close();
?>
