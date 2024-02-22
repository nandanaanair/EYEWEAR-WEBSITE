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

    // Handle image upload
    $imagePath = '';
    if ($_FILES["prod_img"]["size"] > 0) {
        $fileName = $_FILES["prod_img"]["name"];
        $tempFileName = $_FILES["prod_img"]["tmp_name"];
        $uploadDirectory = "uploads/"; // Set your upload directory relative to the current script
        $targetFilePath = $uploadDirectory . basename($fileName);
        
        // Check if the file is an actual image
        $imageFileType = strtolower(pathinfo($targetFilePath,PATHINFO_EXTENSION));
        $allowedExtensions = array("jpg", "jpeg", "png", "gif","webp");
        if (!in_array($imageFileType, $allowedExtensions)) {
            echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
            exit;
        }

        // Check file size
        if ($_FILES["prod_img"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            exit;
        }

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($tempFileName, $targetFilePath)) {
            $imagePath = $targetFilePath;
        } else {
            echo "Error uploading image.";
            exit;
        }
    }

    // Update the product details in the database
    if (!empty($imagePath)) {
        // If a new image was uploaded, update the product with the new image path
        $update_sql = "UPDATE products 
                       SET prod_name = '$prod_name', 
                           prod_description = '$prod_description', 
                           prod_frametype = '$prod_frametype', 
                           prod_category = '$prod_category', 
                           prod_price = '$prod_price', 
                           prod_brand = '$prod_brand', 
                           prod_color = '$prod_color',
                           prod_img = '$imagePath' 
                       WHERE prod_id = '$prod_id'";
    } else {
        // If no new image was uploaded, update the product without modifying the image path
        $update_sql = "UPDATE products 
                       SET prod_name = '$prod_name', 
                           prod_description = '$prod_description', 
                           prod_frametype = '$prod_frametype', 
                           prod_category = '$prod_category', 
                           prod_price = '$prod_price', 
                           prod_brand = '$prod_brand', 
                           prod_color = '$prod_color'
                       WHERE prod_id = '$prod_id'";
    }

    if ($conn->query($update_sql) === TRUE) {
        // Redirect back to the edit-products.php page
        header("Location: edit-products.php");
        exit();
    } else {
        echo "Error updating product: " . $conn->error;
    }
} else {
    echo "Invalid request!";
}

// Close the database connection
$conn->close();
?>
