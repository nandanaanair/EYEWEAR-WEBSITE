<?php
// Assuming you have a database connection
include "connect.php";

// Retrieve filter values from AJAX request
$brands = $_POST['brands'] ?? []; // Array of selected brands, handle undefined value
$price = $_POST['price'] ?? '';   // Selected price range, handle undefined value
$category = $_POST['category']; // Category of products

// Construct SQL query based on filter values
$sql = "SELECT * FROM products WHERE prod_category = ?";
$params = array($category);

// Add conditions for selected brands
if (!empty($brands)) {
    $brandConditions = implode(',', array_fill(0, count($brands), '?'));
    $sql .= " AND prod_brand IN ($brandConditions)";
    $params = array_merge($params, $brands);
}

// Add condition for selected price range
if (!empty($price)) {
    // Parse price range (e.g., 'under_1000')
    list($range, $maxPrice) = explode('_', $price);
    $sql .= " AND prod_price <= ?";
    $params[] = $maxPrice;
}


// Prepare and execute SQL query
$stmt = $conn->prepare($sql);
if ($stmt) {
    // Bind parameters if there are any
    if (!empty($params)) {
        $types = str_repeat('s', count($params)); // Assuming all parameters are strings
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
?>
    <div class="row">
        <?php
        // Fetch and output filtered products
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Output data of each row
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
    // Close the statement
    $stmt->close();
} else {
    echo "Error preparing SQL statement";
}

// Close the database connection
$conn->close();
?>
