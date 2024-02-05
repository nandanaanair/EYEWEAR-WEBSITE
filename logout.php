<?php
session_start();    // Start the session (if not started already)
$_SESSION = array();    // Unset all of the session variables
session_destroy();      // Destroy the session
// header("Location: login.html");      // Redirect the user to the login page or any other desired location
echo "<script> window.location.href='login.html'</script>";
exit();
?>
