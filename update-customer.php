<?php
session_start();
include "connect.php";

// Check if the user is logged in as admin
// if (!isset($_SESSION['admin_email'])) {
//     // Redirect to the admin login page if not logged in
//     header("Location: admin-login.php");
//     exit();
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = $_POST["first_name"];
    $lastName = $_POST["last_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    // Update customer information in the database
    $stmt = $conn->prepare("UPDATE customer SET firstName = ?, lastName = ?, cust_phno = ? WHERE cust_email = ?");
    $stmt->bind_param("ssss", $firstName, $lastName, $phone, $email);

    if ($stmt->execute()) {
        // Redirect to the customer list page after successful update
        // header("Location: list-customer.php");
        echo "<script> window.location.href='list-customer.php'</script>";
        exit();
    } else {
        // Handle the update failure (you might want to log the error)
        echo "Error updating customer information. Please try again later.";
    }

    $stmt->close();
}

$conn->close();
?>
