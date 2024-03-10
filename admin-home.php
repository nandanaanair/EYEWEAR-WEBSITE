<?php
// // Include necessary PHP files or define functions here
// include 'authenticate-admin.php';
// requireLogin();

include "connect.php";
// Fetch total number of products
$productCountQuery = "SELECT COUNT(*) AS total FROM products";
$productCountResult = mysqli_query($conn, $productCountQuery);
$productCountRow = mysqli_fetch_assoc($productCountResult);
$productCount = $productCountRow['total'];

// Fetch top selling products
$topSellingProductsQuery = "SELECT prod_name, SUM(quantity) AS total_sales FROM order_details GROUP BY prod_name ORDER BY total_sales DESC LIMIT 5";
$topSellingProductsResult = mysqli_query($conn, $topSellingProductsQuery);
$topSellingProducts = array();
while ($row = mysqli_fetch_assoc($topSellingProductsResult)) {
    $topSellingProducts[] = $row;
}

// Fetch total number of orders
$orderCountQuery = "SELECT COUNT(*) AS total FROM orders";
$orderCountResult = mysqli_query($conn, $orderCountQuery);
$orderCountRow = mysqli_fetch_assoc($orderCountResult);
$orderCount = $orderCountRow['total'];

// Fetch total number of orders for each product category
$orderCategoryQuery = "SELECT prod_category, COUNT(*) AS total_orders FROM products JOIN order_details ON products.prod_name = order_details.prod_name GROUP BY prod_category";
$orderCategoryResult = mysqli_query($conn, $orderCategoryQuery);
$orderCategories = array();
while ($row = mysqli_fetch_assoc($orderCategoryResult)) {
    $orderCategories[] = $row;
}

// Fetch total revenue
$totalRevenueQuery = "SELECT SUM(total_price) AS total_revenue FROM orders";
$totalRevenueResult = mysqli_query($conn, $totalRevenueQuery);
$totalRevenueRow = mysqli_fetch_assoc($totalRevenueResult);
$totalRevenue = $totalRevenueRow['total_revenue'];

// Fetch total number of appointments
$appointmentCountQuery = "SELECT COUNT(*) AS total FROM appointment";
$appointmentCountResult = mysqli_query($conn, $appointmentCountQuery);
$appointmentCountRow = mysqli_fetch_assoc($appointmentCountResult);
$appointmentCount = $appointmentCountRow['total'];

// Fetch total number of customers
$customerCountQuery = "SELECT COUNT(*) AS total FROM customer";
$customerCountResult = mysqli_query($conn, $customerCountQuery);
$customerCountRow = mysqli_fetch_assoc($customerCountResult);
$customerCount = $customerCountRow['total'];


// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha384-4mOC5PJSq1Yq3Jasv4G1kAqQ6owlsOfQ1uHRzBy6ZYgdT1pef0nGhHPfD5QZbb3J" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="./css/admin-home.css">
    <title>Admin Home</title>
</head>

<body>
    <?php
    include "admin-nav.html";
    ?>
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

        <!-- Product Report and Order Placed Report -->
        <div class="row mt-4">
            <div class="col-md-6">
                <!-- Product Report Card -->
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><b>Product Report</b></h5>
                        <p class="card-text">Total Products: <?php echo $productCount; ?></p>
                        <p class="card-text">Top Selling Products:</p>
                        <ul>
                            <?php foreach ($topSellingProducts as $product): ?>
                                <li><?php echo $product['prod_name']; ?> (<?php echo $product['total_sales']; ?> sales)</li>
                            <?php endforeach; ?>
                        </ul>
                        <canvas id="productChart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <!-- Order Placed Report Card -->
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><b>Order Placed Report</b></h5>
                        <p class="card-text">Total Orders: <?php echo $orderCount; ?></p>
                        <p class="card-text">Total Revenue: $<?php echo $totalRevenue; ?></p>
                        <canvas id="orderCategoryChart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Appointment Booking Report and Customer Report -->
        <div class="row mt-4">
            <div class="col-md-6">
                <!-- Appointment Booking Report Card -->
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><b>Appointment Booking Report</b></h5>
                        <p class="card-text">Total Appointments: <?php echo $appointmentCount; ?></p>
                        <canvas id="appointmentChart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <!-- Customer Report Card -->
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><b>Customer Report</b></h5>
                        <p class="card-text">Total Customers: <?php echo $customerCount; ?></p>
                        <canvas id="customerChart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
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
    </div>
</div>
<script>
// Product Report Chart
var productChartCanvas = document.getElementById('productChart').getContext('2d');
var productChart = new Chart(productChartCanvas, {
    type: 'bar',
    data: {
        labels: ['Total Products', 'Top Selling Products'],
        datasets: [{
            label: 'Product Count',
            data: [<?php echo $productCount; ?>, <?php echo count($topSellingProducts); ?>],
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

// Total Orders by Product Category Chart
var orderCategoryChartCanvas = document.getElementById('orderCategoryChart').getContext('2d');
var orderCategoryChart = new Chart(orderCategoryChartCanvas, {
    type: 'pie',
    data: {
        labels: [<?php foreach ($orderCategories as $category) { echo '"' . $category['prod_category'] . '",'; } ?>],
        datasets: [{
            label: 'Total Orders',
            data: [<?php foreach ($orderCategories as $category) { echo $category['total_orders'] . ','; } ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            display: false
        }
    }
});

// Appointment Booking Report Chart
var appointmentChartCanvas = document.getElementById('appointmentChart').getContext('2d');
var appointmentChart = new Chart(appointmentChartCanvas, {
    type: 'bar',
    data: {
        labels: ['Total Appointments'],
        datasets: [{
            label: 'Total Appointments',
            data: [<?php echo $appointmentCount; ?>],
            backgroundColor: 'rgba(255, 206, 86, 0.2)',
            borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

// Customer Report Chart
var customerChartCanvas = document.getElementById('customerChart').getContext('2d');
var customerChart = new Chart(customerChartCanvas, {
    type: 'bar',
    data: {
        labels: ['Total Customers'],
        datasets: [{
            label: 'Total Customers',
            data: [<?php echo $customerCount; ?>],
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>


<!-- Bootstrap JavaScript and dependencies -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/7785e19128.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js" integrity="sha384-7v1vbll1aXQN+/6fkI65f8F6TfT8/zy4PXdMW9sQY3TI4NdIiFqQ0W/gFqgoj3I1" crossorigin="anonymous"></script>

</body>

</html>
