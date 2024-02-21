<?php
session_start();  
unset($_SESSION['cart']);
session_destroy();      
echo "<script> window.location.href='index.php'</script>";
?>
