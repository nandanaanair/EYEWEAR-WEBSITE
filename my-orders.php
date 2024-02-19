<?php
session_start();
include "connect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="./css/my-orders.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<?php include "nav.php"; ?>

    <!-- Page Content -->
    <div class="container mt-5">
        <h2>My Orders</h2>
        <br>
        <div class="row">
            <?php
            
            // Query to retrieve orders for the current user (assuming user email is stored in session)
            $cust_email = $_SESSION['cust_email'];
            $sql = "SELECT * FROM orders WHERE cust_email = '$cust_email'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Order #<?php echo $row["order_id"]; ?></h5>
                                <p class="card-text"><?php echo $row["order_bldg"] . ', ' . $row["order_city"] . ', ' . $row["order_state"] . ' - ' . $row["order_pincode"]; ?></p>
                                <p class="card-text">Price: ₹<?php echo $row["total_price"]; ?></p>
                                <p class="card-text">Order Date: <?php echo $row["order_date"]; ?></p>
                                <p class="card-text">Order Details: <?php echo $row["order_details"]; ?></p>
                                <p class="card-text">Order Status: <?php echo $row["order_status"]; ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No orders found.</p>";
            }

            // Close database connection
            $conn->close();
            ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
