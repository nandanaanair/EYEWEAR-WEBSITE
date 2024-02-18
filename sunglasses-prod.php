<?php
    session_start(); 
?>
<?php
// Assuming you have a database connection
include "connect.php";

// Retrieve products from the database
$sql = "SELECT * FROM products WHERE prod_category = 'sunglass'";
$result = $conn->query($sql);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha384-4mOC5PJSq1Yq3Jasv4G1kAqQ6owlsOfQ1uHRzBy6ZYgdT1pef0nGhHPfD5QZbb3J" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/view-apptmt.css">
    <!-- <script src="./js/products.js"></script> -->
    <title>Sunglasses</title> <!-- Set the web page title here -->
    <style>
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    

<?php
    include 'nav.php';
    ?>
<br>
<div class="container">
            <div class="row mb-3">
                <div class="col-md-12 mt-3">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search products...">
                </div>
            </div>
        <h2 class="mt-4 mb-3">Sunglasses</h2>
        <br>
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
    </div>



<!-- Bootstrap JavaScript and dependencies -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/7785e19128.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js" integrity="sha384-7v1vbll1aXQN+/6fkI65f8F6TfT8/zy4PXdMW9sQY3TI4NdIiFqQ0W/gFqgoj3I1" crossorigin="anonymous"></script>
<script src="./js/products.js"></script>
</body>

</html>
