<?php
// Assuming you have a database connection
include "connect.php";

// Retrieve product details based on the product ID from the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE prod_id = '$product_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Product not found";
    }
} else {
    echo "Product ID not provided";
}

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

<body>

    <div class="container">
        <h2 class="mt-2 mb-3">Product Details</h2>
        <br>
        <?php if (isset($product)) : ?>
            <div class="card product-card">
                <div class="product-image-container">
                    <img src="<?php echo $product['prod_image']; ?>" class="card-img-top product-image" alt="Product Image">
                </div>
                <div class="card-body product-details">
                    <h5 class="card-title"><?php echo $product["prod_name"]; ?></h5>
                    <p class="card-text"> <?php echo $product["prod_description"]; ?></p>
                    <p class="card-text"><strong>₹<?php echo $product["prod_price"]; ?></strong> </p>
                    <p class="card-text"><strong>Frame Type:</strong> <?php echo $product["prod_frametype"]; ?></p>
                    <p class="card-text"><strong>Category:</strong> <?php echo $product["prod_category"]; ?></p>
                    <p class="card-text"><strong>Brand:</strong> <?php echo $product["prod_brand"]; ?></p>
                    <!-- Display color as a colored box -->
                    <p class="card-text"><strong>Color:</strong> <span class="color-box" style="background-color: <?php echo $product['prod_color']; ?>;"></span></p>
                    <!-- Add more details here -->
                    <div class="mt-4">
                        <button class="btn btn-order-now mr-2">Order Now</button>
                        <form action="add-to-cart.php" method="post" class="d-inline">
                            <input type="hidden" name="product_id" value="<?php echo $product['prod_id']; ?>">
                            <button type="submit" class="btn btn-add-to-cart">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Review Section -->
            <div class="card mt-4">
                <h5 class="card-header">Add Review</h5>
                <div class="card-body">
                    <!-- Form to add a review -->
                    <form action="add-review.php" method="post">
                        <div class="form-group">
                            <label for="review_title">Title</label>
                            <input type="text" class="form-control" id="review_title" name="review_title" required>
                        </div>
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
        <?php endif; ?>
    </div>

</body>

</html>
