<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/cart.css"> <!-- Your custom styles -->
    <title>Cart</title>
</head>

<body>
    <!-- Navigation Bar -->
    <?php include 'nav.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8">
                <h2 class="mb-4">Shopping Cart</h2>
                <div id="cart-items" class="cart-items">
                    <!-- Cart items will be displayed here dynamically using PHP -->
                    <?php
                    include 'connect.php'; // Include your database connection file    
                    $totalItems = 0;
                    $totalPrice = 0;
                    // Retrieve cart data from the database based on customer email
                    $cust_email = isset($_SESSION['cust_email']) ? $_SESSION['cust_email'] : null; // Assuming customer email is stored in session

                    if ($cust_email) {
                        // Fetch cart items from the database using MySQL JOIN query to get product details
                        $sql = "SELECT c.quantity, p.prod_id, p.prod_name, p.prod_description, p.prod_price, p.prod_img
                                FROM cart c
                                JOIN products p ON c.product_id = p.prod_id
                                WHERE c.cust_email = ?";

                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $cust_email);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Check if cart has items
                        if ($result->num_rows > 0) {
                            // Output HTML markup for each cart item
                            while ($row = $result->fetch_assoc()) {
                                echo "<div class='cart-item bg-white shadow-sm p-3 mb-3 rounded'>";
                                echo "<div class='row align-items-center'>";
                                echo "<div class='col-md-3'>";
                                echo "<img src='" . $row['prod_img'] . "' alt='" . $row['prod_name'] . "' class='img-fluid rounded'>";
                                echo "</div>";
                                echo "<div class='col-md-6'>";
                                echo "<h4 class='mb-1'>" . $row['prod_name'] . "</h4>";
                                echo "<div class='mb-1'>" . $row['prod_description'] . "</div>";
                                echo "<div class='row align-items-center mb-1'>";
                                echo "<div class='col-auto'>";
                                // echo "<label class='mr-2'>Quantity:</label>";
                                echo "</div>";
                                echo "<div class='col'>";
                                // echo "Quantity: " . $row['quantity']; // Add this line for debugging
                                echo "<label class='mr-2'>Quantity:</label>";
                                echo "<form action='update-cart.php' method='post' class='update-form'>";
                                echo "<input type='hidden' name='update_prod_id' value='" . $row['prod_id'] . "'>";
                                echo "<input type='number' class='form-control quantity-input' value='" . $row['quantity'] . "' name='quantity'>";
                                echo "<br>";
                                echo "<button type='submit' class='btn btn-sm btn-outline-danger update-button'>Update</button>";
                                echo "</form>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                                echo "<div class='col-md-3 text-right'>";
                                echo "<h4 style='padding-bottom: 30%'><strong>Rs. " . $row['prod_price'] . "</strong></h4>"; // Add padding to the bottom of the price
                                echo "<form action='remove-from-cart.php' method='post' class='remove-form'>";
                                echo "<input type='hidden' name='remove_prod_id' value='" . $row['prod_id'] . "'>"; // Use the product ID from the database
                                echo "<button type='submit' class='btn btn-sm btn-outline-danger remove-button'>Remove</button>";
                                echo "</form>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                            }

                            // Calculate total items and total price
                            $result->data_seek(0); // Reset the pointer to the beginning of the result set
                            while ($row = $result->fetch_assoc()) {
                                $totalItems += $row['quantity'];
                                $totalPrice += $row['quantity'] * $row['prod_price'];
                            }
                        } else {
                            echo "<p>Your cart is empty</p>";
                        }

                        // Close prepared statement and database connection
                        $stmt->close();
                        $conn->close();
                    } else {
                        // Handle case when user is not logged in
                        echo "<p>Please log in to view your cart</p>";
                    }
                    ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="cart-summary bg-white shadow-sm p-4 rounded">
                    <h4 class="mb-4">Order Summary</h4>
                    <p class="mb-2">Total Items: <span id="total-items"><?php echo $totalItems; ?></span></p>
                    <!-- Total items -->
                    <p class="mb-4">Total Price: <span id="total-price">Rs. <?php echo number_format($totalPrice, 2); ?></span></p>
                    <!-- Total price -->
                    <form action="checkout-form.php" method="post" class="d-inline">
                        <button type="submit" class="btn btn-primary" id="orderNowBtn">Checkout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
