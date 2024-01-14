<?php
session_start();
include "connect.php";

// // Check if the user is logged in as admin
// if (!isset($_SESSION['admin_email'])) {
//     // Redirect to the admin login page if not logged in
//     header("Location: admin-login.php");
//     exit();
// }

if (!isset($_GET['cust_email'])) {
    header("Location: edit-customer.php");
    exit();
}

$customerEmail = $_GET['cust_email'];

// Retrieve customer details based on the cust_email
$stmt = $conn->prepare("SELECT * FROM customer WHERE cust_email = ?");
$stmt->bind_param("s", $customerEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $customerData = $result->fetch_assoc();
    // Add more fields if needed
} else {
    // Redirect if customer ID is not valid
    header("Location: edit-customer.php");
    exit();
}

// Close the database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <link rel="stylesheet" href="list-customer.css">
</head>

<body>

    <!-- Edit Customer Form -->
    <div class="container mt-5">
        <h2 class="text-center">Edit Customer</h2>
        <form action="update-customer.php" method="post">
            <!-- Display customer details in form fields for editing -->
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo $customerData['firstName']; ?>" required>
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo $customerData['lastName']; ?>" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $customerData['cust_email']; ?>" required>
            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" value="<?php echo $customerData['cust_phno']; ?>" required>
            <!-- Add more fields if needed -->
            <button type="submit">Update Customer</button>
        </form>
    </div>

</body>

</html>
