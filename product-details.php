<?php
session_start();
include "connect.php";


// Retrieve product details based on the product ID from the URL
if (isset($_GET['id'])) {
    $prod_id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE prod_id = '$prod_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        // Set session variables after retrieving product details
        $_SESSION['prod_price'] = $product['prod_price'];
        $_SESSION['prod_id'] = $product['prod_id'];
    } else {
        echo "Product not found";
    }
} else {
    echo "Product ID not provided";
}

// Fetch customer's first name from the customer table based on their email
if (isset($_SESSION['cust_email'])) {
    $cust_email = $_SESSION['cust_email'];
    $sql_customer = "SELECT firstName FROM customer WHERE cust_email = '$cust_email'";
    $result_customer = $conn->query($sql_customer);

    if ($result_customer->num_rows > 0) {
        $customer = $result_customer->fetch_assoc();
        $customer_fname = $customer['firstName'];
    } else {
        echo "Customer not found";
    }
} else {
    echo "<script> window.location.href='login.html'</script>";
}

// Retrieve existing reviews for the product
$reviews_sql = "SELECT * FROM reviews WHERE prod_id = '$prod_id'";
$reviews_result = $conn->query($reviews_sql);


// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/product-details.css">
</head>
<style>
        .message {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .success {
            background-color: #7caf4c;
            color: white;
        }
        .error {
            background-color: #943726;
            color: white;
        }
</style>
<script>
window.onload = function() {
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('success') && urlParams.get('success') == '1') {
        displayMessage("Product added to cart successfully!", "success");
    }
    if (urlParams.has('success') && urlParams.get('success') == '2') {
        displayMessage("Order placed successfully. Shop more! Thankyou!", "success");
    }
    if (urlParams.has('error') && urlParams.get('error') == '1') {
        displayMessage("Product not found!", "error");
    }
    if (urlParams.has('error') && urlParams.get('error') == '2') {
        displayMessage("Product ID not provided!", "error");
    }
    if (urlParams.has('error') && urlParams.get('error') == '3') {
        displayMessage("Payment Failed!", "error");
    }
};

function displayMessage(message, type) {
    var messageContainer = document.createElement('div');
    messageContainer.textContent = message;
    messageContainer.classList.add('message', type);
    document.body.insertBefore(messageContainer, document.body.firstChild);
    setTimeout(function() {
        messageContainer.remove();
    }, 3000); // Remove message after 3 seconds
}

</script>
<body>
    <!-- Navigation Bar -->
    <?php include 'nav.php'; ?>

    <div class="container mt-2">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">Product Details</h2>
            </div>
        </div>
        <div class="row">
            <?php if (isset($product)) : ?>
                <div class="col-lg-6">
                    <div class="card product-card">
                        <div class="product-image-container">
                            <!-- Display product image -->
                            <img src="<?php echo $product['prod_img']; ?>" class="card-img-top product-image" alt="Product Image">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card product-details">
                        <div class="card-body">
                            <h2 class="card-title"><?php echo $product["prod_name"]; ?></h2>
                            <!-- Display other product details -->
                            <p class="card-text"><?php echo $product["prod_description"]; ?></p>
                            <p class="card-text"><strong>₹<?php echo $product["prod_price"]; ?></strong></p>
                            <!-- Display other product details -->
                            <p class="card-text"><strong>Frame Type:</strong> <?php echo $product["prod_frametype"]; ?></p>
                            <p class="card-text"><strong>Category:</strong> <?php echo $product["prod_category"]; ?></p>
                            <p class="card-text"><strong>Brand:</strong> <?php echo $product["prod_brand"]; ?></p>
                            <p class="card-text"><strong>Color:</strong> <span class="color-box" style="background-color: <?php echo $product['prod_color']; ?>;"></span></p>
                            <!-- Add to cart and order now buttons -->
                            <div class="mt-4">
                                <form action="checkout-form.php?id=<?php echo $_GET['id']; ?>" method="post" class="d-inline">
                                    <button type="submit" class="btn btn-primary" id="orderNowBtn">Order Now</button>
                                </form>
                                <form action="add-to-cart.php" method="post" class="d-inline">
                                    <input type="hidden" name="prod_id" value="<?php echo $product['prod_id']; ?>">
                                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Review Section -->
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="card">
                    <h5 class="card-header">Reviews</h5>
                    <div class="card-body">
                        <?php if ($reviews_result->num_rows > 0) : ?>
                            <ul class="list-group">
                                <?php while ($review = $reviews_result->fetch_assoc()) : ?>
                                    <li class="list-group-item">
                                        <h6><?php echo $review['cust_fname']; ?></h6>
                                        <p><?php echo $review['rev_comment']; ?></p>
                                        <p>Rating: <?php echo $review['rev_rating']; ?></p>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        <?php else : ?>
                            <p>No reviews yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Review Section -->
        <div class="row mt-3" id="addReviewSection" style="display: none;">
            <div class="col-lg-12">
                <div class="card">
                    <h5 class="card-header">Add Review</h5>
                    <div class="card-body">
                    <form action="submit-review.php?id=<?php echo $prod_id; ?>" method="post">
                            <!-- Hide the input fields for customer's first name and prod ID -->
                            <input type="hidden" name="firstName" value="<?php echo $customer_fname; ?>">
                            <div class="form-group">
                                <label for="review_content">Content</label>
                                <textarea class="form-control" id="review_content" name="review_content" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="review_rating">Rating</label>
                                <select class="form-control" id="review_rating" name="review_rating" required>
                                    <option value="5">5 stars</option>
                                    <option value="4">4 stars</option>
                                    <option value="3">3 stars</option>
                                    <option value="2">2 stars</option>
                                    <option value="1">1 star</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Review</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Review Button -->
        <div class="row mt-3" id="addReviewBtnRow">
            <div class="col-lg-12">
                <button class="btn btn-primary" id="addReviewBtn">Add a Review</button>
            </div>
        </div>
    </div>
    <br><br><br><br>
    <?php
include "footer.php";
?>
    <script>
        // Toggle visibility of add review section and scroll to it
        document.getElementById('addReviewBtn').addEventListener('click', function() {
            document.getElementById('addReviewSection').style.display = 'block';
            document.getElementById('addReviewBtnRow').style.display = 'none'; // Hide the button
            document.getElementById('addReviewSection').scrollIntoView({ behavior: 'smooth' }); // Scroll to the form
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
