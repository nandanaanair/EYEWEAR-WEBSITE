<?php
session_start();
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $prod_id = $_POST['prod_id'];
    $prod_name = $_POST['prod_name'];
    $prod_description = $_POST['prod_description'];
    $prod_frametype = $_POST['prod_frametype'];
    $prod_category = $_POST['prod_category'];
    $prod_price = $_POST['prod_price'];
    $prod_brand = $_POST['prod_brand'];
    $prod_color = $_POST['prod_color'];

    // Update the product in the database
    $update_sql = "UPDATE products 
                   SET prod_name = '$prod_name', 
                       prod_description = '$prod_description', 
                       prod_frametype = '$prod_frametype', 
                       prod_category = '$prod_category', 
                       prod_price = '$prod_price', 
                       prod_brand = '$prod_brand', 
                       prod_color = '$prod_color' 
                   WHERE prod_id = '$prod_id'";

    if ($conn->query($update_sql) === TRUE) {
        // header("Location: edit-products.php");
        echo "<script> window.location.href='edit-products.php'</script>";
    } else {
        echo "Error updating product: " . $conn->error;
    }
} else {
    echo "Invalid request!";
}

// Close the database connection
$conn->close();
?>
