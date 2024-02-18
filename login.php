<?php
session_start();
include "connect.php";

if (isset($_SESSION['cust_email'])) {
    echo "<script>window.location.href='home.php'</script>";
    exit();
}

if (isset($_POST['cust_email']) && isset($_POST['cust_password'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = validate($_POST['cust_email']);
    $pass = validate($_POST['cust_password']);

    $sql = "SELECT cust_email, cust_password FROM customer WHERE cust_email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $fetchedEmail, $hashedPassword);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($fetchedEmail === $email && password_verify($pass, $hashedPassword)) {
        $_SESSION['cust_email'] = $fetchedEmail;
        
        // Retrieve cart items from local storage if available
        if(isset($_SESSION['cart'])) {
            $cartItems = json_decode($_SESSION['cart'], true);
            // Update cart count
            $_SESSION['cart_count'] = count($cartItems);
        } else {
            // If cart is not set, initialize cart count to 0
            $_SESSION['cart_count'] = 0;
        }
        
        echo "<script>window.location.href = 'home.php?success=1';</script>";
        exit();
    } else {
        echo "<script>window.location.href = 'login.html?error=1';</script>";
    }
} else {
    echo "<script>window.location.href = 'login.html';</script>";
    exit();
}
?>
