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
    <title>Sunglasses</title> 
    <style>
        .card {
            margin-bottom: 20px;
        }
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
</head>

<body>
    

<?php
    // include 'nav.php';
    if (isset($_SESSION['cust_email'])) {
        include 'nav.php';
    }else{
        include 'index-nav.php';
    }
?>
<br>
<div class="container">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <?php include 'side-bar.php'; ?>
        </div>
                <div class="col-md-12 mt-3">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search products...">
                </div>
            </div>

        <div class="col-md-9">
        <div class="row">
        <h2 class="mt-4 mb-5">Sunglasses</h2>
        <br><br><br>
        <div id="productContainer">
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
