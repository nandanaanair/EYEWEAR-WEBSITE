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
    $sql = "INSERT INTO orders (order_id, order_date, order_bldg, order_city, order_state, order_pincode, total_price, cust_email, prod_id) 
            VALUES ('$order_id', '$order_date', '$order_bldg', '$order_city', '$order_state', '$order_pincode', '$total_price', '$cust_email', '$prod_id')";

    if ($conn->query($sql) === TRUE) {
        // echo "Order placed successfully.";
        echo "<script>window.location.href='product-details.php?id=$prod_id&success=2'</script>";
    } else {
        echo "<script>window.location.href='product-details.php?id=$prod_id&error=3'</script>";
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

// Retrieve the order ID from the session
$order_id = $_SESSION['order_id'];

// Prepare and execute the SQL statement to insert prescription details into the database
$stmt = $conn->prepare("INSERT INTO prescription (order_id, l_sph, r_sph, l_cyl, r_cyl, l_axis, r_axis, l_addn, r_addn) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issssssss", $order_id, $l_sph, $r_sph, $l_cyl, $r_cyl, $l_axis, $r_axis, $l_addn, $r_addn);

// Check if the statement executed successfully
if ($stmt->execute()) {
    // Prescription details inserted successfully
    echo "Prescription details saved successfully!";
} else {
    // Error occurred while inserting prescription details
    echo "Error: " . $stmt->error;
}

// Close the statement and database connection
$stmt->close();


// Close database connection
$conn->close();
?>