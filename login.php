<?php
// helloo
session_start();
include "connect.php";

if (isset($_SESSION['cust_email'])) {
    // header("Location: home.html");
    echo "<script> window.location.href='home.html'</script>";
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

    // Use parameterized query to prevent SQL injection
    $sql = "SELECT cust_email, cust_password FROM customer WHERE cust_email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $fetchedEmail, $hashedPassword);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($fetchedEmail === $email && password_verify($pass, $hashedPassword)) {
        $_SESSION['cust_email'] = $fetchedEmail;
        // header("Location: home.html");
        echo "<script> window.location.href='home.html'</script>";
        exit();
    } else {
        echo "<script>createPopup('Incorrect email or password');</script>";
        exit();
    }
} 
else {
    // header("Location: login.html");
    echo "<script> window.location.href='login.html'</script>";
    exit();
}
?>


