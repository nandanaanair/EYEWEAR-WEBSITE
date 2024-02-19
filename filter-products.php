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
                <div class="col-md-4"> <!-- Adjust the grid size as needed -->
                    <div class="card mb-3"> <!-- Add margin bottom to space the cards -->
                        <?php if (!empty($row["prod_img"])) { ?>
                            <img src="<?php echo $row["prod_img"]; ?>" class="card-img-top" alt="Product Image">
                        <?php } else { ?>
                            <!-- Add a placeholder image or default image here -->
                            <img src="placeholder.jpg" class="card-img-top" alt="Product Image">
                        <?php } ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row["prod_name"]; ?></h5>
                            <p class="card-text"><?php echo $row["prod_description"]; ?></p>
                            <p class="card-text">Price: <?php echo $row["prod_price"]; ?></p>
                            <p class="card-text">Brand: <?php echo $row["prod_brand"]; ?></p>
                            <!-- Add link to view product details -->
                            <a href="product-details.php?id=<?php echo $row['prod_id']; ?>" class="btn btn-primary">View Details</a>
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
