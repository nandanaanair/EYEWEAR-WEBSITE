<?php
include 'authenticate-admin.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha384-4mOC5PJSq1Yq3Jasv4G1kAqQ6owlsOfQ1uHRzBy6ZYgdT1pef0nGhHPfD5QZbb3J" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/admin-home.css">
    <title>Admin Home</title>
</head>

<body>
    <!-- Sidebar -->
    <nav id="sidebar">
        <ul class="list-unstyled components" >
            <li class="active">
                <a href="admin-home.php">Dashboard</a>
            </li>
            <li>
                <a href="edit-products.php">Products</a>
            </li>
            <li>
                <a href="list-appointment.php">Appointments</a>
            </li>
            <li>
                <a href="list-customer.php">Customers</a>
            </li>
            <li>
                <a href="list-orders.php">Orders</a>
            </li>
            <li>
                <a href="list-prescription.php">Prescriptions</a>
            </li>
            <li>
                <a href="admin-pay.php">Payments</a>
            </li>
        </ul>
    </nav>
<div id="content">
    <br><br>
    <div class="container mt-4">
        <h2 class="text-center">Welcome, Admin!</h2>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card" style="margin-top: 23px;">
                    <div class="card-body">
                        <h5 class="card-title">Add Products</h5>
                        <p class="card-text">Click below to add a new product to the inventory.</p>
                        <a href="add-products.php" class="btn btn-primary">Add a Product</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <br>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit products</h5>
                        <p class="card-text">Click below to edit product information.</p>
                        <a href="edit-products.php" class="btn btn-primary">Edit Products</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <br>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">List Customers</h5>
                        <p class="card-text">Click below to view the customer details.</p>
                        <a href="list-customer.php" class="btn btn-primary">List Customers</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <br>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">List Appointments</h5>
                        <p class="card-text">Click below to view the appointment details.</p>
                        <a href="list-appointment.php" class="btn btn-primary">List Appointments</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <br>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">View Orders</h5>
                        <p class="card-text">Click below to view the orders placed.</p>
                        <a href="list-orders.php" class="btn btn-primary">List Orders</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <br>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">View Prescriptions</h5>
                        <p class="card-text">Click below to view the Prescriptions sent.</p>
                        <a href="list-prescription.php" class="btn btn-primary">List Prescriptions</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <br>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">View Payments</h5>
                        <p class="card-text">Click below to view the payment details.</p>
                        <a href="list-payment.php" class="btn btn-primary">List Payment</a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <!-- Include your existing appointments table code here -->
    </div>

    <?php
    include 'admin-nav.html'; // Assuming you have a navigation bar included in the 'nav.html' file
    ?>

    
    <!-- Bootstrap JavaScript and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/7785e19128.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js" integrity="sha384-7v1vbll1aXQN+/6fkI65f8F6TfT8/zy4PXdMW9sQY3TI4NdIiFqQ0W/gFqgoj3I1" crossorigin="anonymous"></script>

</body>

</html>
