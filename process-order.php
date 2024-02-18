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
// Handle file upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["pdf_file"])) {
    $targetDir = "uploads/"; // Specify the directory where you want to store uploaded files
    $targetFile = $targetDir . basename($_FILES["pdf_file"]["name"]);
    $uploadOk = 1;
    $pdfFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the file is a PDF
    if ($pdfFileType != "pdf") {
        echo "Only PDF files are allowed.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["pdf_file"]["size"] > 5000000) { // Adjust the file size limit as per your requirement
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // If everything is ok, try to upload file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $targetFile)) {
            echo "The file " . htmlspecialchars(basename($_FILES["pdf_file"]["name"])) . " has been uploaded.";
            
            // Now you can store $targetFile (path to the uploaded file) in the database along with other details
            
            // Prepare and execute SQL statement to insert data into orders table
            $sql = "INSERT INTO orders (order_id, order_date, order_bldg, order_city, order_state, order_pincode, total_price, cust_email, prod_id, pdf_path) 
                    VALUES ('$order_id', '$order_date', '$order_bldg', '$order_city', '$order_state', '$order_pincode', '$total_price', '$cust_email', '$prod_id', '$targetFile')";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}


// Close database connection
$conn->close();
?>