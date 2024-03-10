<?php
// Assuming you have a database connection
include "connect.php";

// Retrieve sorting option from AJAX request
$sortBy = $_POST['sort']; // Sorting option
$category = $_POST['category']; // Category of products

// Construct SQL query based on sorting option and category
$sql = "SELECT * FROM products WHERE prod_category = ?";
$params = array($category);

if ($sortBy == 'price_low_high') {
    $sql .= " ORDER BY prod_price ASC";
} elseif ($sortBy == 'price_high_low') {
    $sql .= " ORDER BY prod_price DESC";
}

// Execute SQL query
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param('s', $category);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<div class="row">
    <?php
    // Check if there are products
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="col-md-4">
                        <div class="card">
                            <?php if (!empty($row["prod_img"])) { ?>
                                <img src="<?php echo $row["prod_img"]; ?>" class="card-img-top" alt="Product Image">
                            <?php } else { ?>
                                <!-- Add a placeholder image or default image here -->
                                <img src="placeholder.jpg" class="card-img-top" alt="Product Image">
                            <?php } ?>
                            <div class="card-body">
                                <div style="display: flex; justify-left: space-between;">
                                <h5 class="card-title"><?php echo $row["prod_name"]; ?></h5>
                                <h6 class="card-text"><br><b>₹<?php echo $row["prod_price"]; ?></b></h6>
                                </div>
                                <!-- <p class="card-text"><?php echo $row["prod_description"]; ?></p> -->
                                <p class="card-text"><i><?php echo $row["prod_brand"]; ?></i></p>
                                <hr>
                                <a href="product-details.php?id=<?php echo $row['prod_id']; ?>" style="color: black; text-decoration: underline;"><b>View Details</b></a>
                                <br><br>
                                <form action="add-to-cart.php" method="POST">
                                    <input type="hidden" name="prod_id" value="<?php echo $row['prod_id']; ?>">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-cart-plus"></i> Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
            <?php
        }
    } else {
        echo "No products found";
    }
    ?>
</div>

<?php
// Close the database connection
$conn->close();
?>
