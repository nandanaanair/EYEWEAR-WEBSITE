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
// Close the database connection
$conn->close();
?>
