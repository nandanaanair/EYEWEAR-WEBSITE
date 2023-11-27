<?php
session_start();
include "connect.php";

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

    // Use parameterized query to prevent SQL injection
    $sql = "SELECT cust_email, cust_password FROM customer WHERE cust_email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $fetchedEmail, $hashedPassword);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($fetchedEmail === $email && password_verify($pass, $hashedPassword)) {
        echo "Logged in!";
        $_SESSION['cust_email'] = $fetchedEmail;
        header("Location: index.html");
        exit();
    } else {
        echo "Incorrect email or password";
        exit();
    }
} else {
    header("Location: login.html");
    exit();
}
?>
