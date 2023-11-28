<<<<<<< HEAD
<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'eyeweardb';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_error()) {
    exit('Error connecting to the database' . mysqli_connect_error());
}

if (!isset($_POST['firstName'], $_POST['lastName'], $_POST['cust_email'], $_POST['cust_phno'], $_POST['cust_password'])) {
    exit('Empty Field(s)');
}

if (empty($_POST['firstName']) || empty($_POST['lastName']) || empty($_POST['cust_email']) || empty($_POST['cust_phno']) || empty($_POST['cust_password'])) 
{
    exit('Values Empty');
}

if ($stmt = $con->prepare('SELECT firstName, lastName, cust_password FROM customer WHERE cust_email = ?')) {
    $stmt->bind_param('s', $_POST['cust_email']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo 'This email is already registered. Try again with a different email.';
    } else {
        $stmt->close();  // Close the previous statement before preparing a new one

        if ($stmt = $con->prepare('INSERT INTO customer (firstName, lastName, cust_email, cust_phno, cust_password) VALUES (?, ?, ?, ?, ?)')) {
            $cust_password = password_hash($_POST['cust_password'], PASSWORD_DEFAULT);
            $stmt->bind_param('sssss', $_POST['firstName'], $_POST['lastName'], $_POST['cust_email'], $_POST['cust_phno'], $cust_password);
            $stmt->execute();
            header("Location: login.html");
        } else {
            echo 'Error Occurred';
        }
    }
    $stmt->close();
} else {
    echo 'Error Occurred';
}

$con->close();
?>
=======
<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'eyeweardb';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_error()) {
    exit('Error connecting to the database' . mysqli_connect_error());
}

if (!isset($_POST['firstName'], $_POST['lastName'], $_POST['cust_email'], $_POST['cust_phno'], $_POST['cust_password'])) {
    exit('Empty Field(s)');
}

if (empty($_POST['firstName']) || empty($_POST['lastName']) || empty($_POST['cust_email']) || empty($_POST['cust_phno']) || empty($_POST['cust_password'])) 
{
    exit('Values Empty');
}

if ($stmt = $con->prepare('SELECT firstName, lastName, cust_password FROM customer WHERE cust_email = ?')) {
    $stmt->bind_param('s', $_POST['cust_email']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo 'This email is already registered. Try again with a different email.';
    } else {
        $stmt->close();  // Close the previous statement before preparing a new one

        if ($stmt = $con->prepare('INSERT INTO customer (firstName, lastName, cust_email, cust_phno, cust_password) VALUES (?, ?, ?, ?, ?)')) {
            $cust_password = password_hash($_POST['cust_password'], PASSWORD_DEFAULT);
            $stmt->bind_param('sssss', $_POST['firstName'], $_POST['lastName'], $_POST['cust_email'], $_POST['cust_phno'], $cust_password);
            $stmt->execute();
            header("Location: login.html");
        } else {
            echo 'Error Occurred';
        }
    }
    $stmt->close();
} else {
    echo 'Error Occurred';
}

$con->close();
?>
>>>>>>> 578a0b26f5671bfa122584699edb4f56b0384a45
