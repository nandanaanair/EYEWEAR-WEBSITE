<?php
session_start();
include "connect.php";

// Check if the user is logged in
if (!isset($_SESSION['cust_email'])) {
    // Redirect to the login page if not logged in
    echo "<script> window.location.href='login.html'</script>";
    exit();
}

// Assuming you have cust_email stored in the session after login
$cust_email = $_SESSION['cust_email'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you have validation logic here

    // Get updated details from the form
    $editFirstName = $_POST['editFirstName'];
    $editLastName = $_POST['editLastName'];
    $editPhone = $_POST['editPhone'];

    // Update user details in the database
    $stmt = $conn->prepare("UPDATE customer SET firstName=?, lastName=?, cust_phno=? WHERE cust_email=?");
    $stmt->bind_param("ssss", $editFirstName, $editLastName, $editPhone, $cust_email);
    $stmt->execute();
    $stmt->close();

    // Get updated address details from the form
    $bldg = $_POST['editBldg'];
    $city = $_POST['editCity'];
    $state = $_POST['editState'];
    $pincode = $_POST['editPincode'];

    // Update address fields in the database
    $stmt = $conn->prepare("UPDATE customer SET bldg = ?, city = ?, state = ?, pincode = ? WHERE cust_email = ?");
    $stmt->bind_param("sssis", $bldg, $city, $state, $pincode, $cust_email);
    $stmt->execute();
    $stmt->close();

    // Redirect back to the profile page
    echo "<script> window.location.href='user-profile.php'</script>";
    exit();
} else {
    // Redirect to the user profile page if accessed without form submission
    echo "<script> window.location.href='user-profile.php'</script>";
    exit();
}
?>
