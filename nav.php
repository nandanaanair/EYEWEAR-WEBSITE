<?php
// Function to get the count of items in the cart
function getCartItemCount() {
    // Check if the cart session variable exists and is not empty
    if(isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        // If the cart is not empty, return the count of items in the cart
        return count($_SESSION['cart']);
    } else {
        // If the cart is empty or not set, return 0
        return 0;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/home.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha384-4mOC5PJSq1Yq3Jasv4G1kAqQ6owlsOfQ1uHRzBy6ZYgdT1pef0nGhHPfD5QZbb3J" crossorigin="anonymous">
    <title>nav</title>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
        <a class="navbar-brand" href="home.php"> O⌄O VisionVibes </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="home.php">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Products
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="eyeglasses-prod.php">Eyeglasses</a>
                        <a class="dropdown-item" href="sunglasses-prod.php">Sunglasses</a>
                        <a class="dropdown-item" href="screenglasses-prod.php">Screen Glasses</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view-apptmt.php"">Appointments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact-us.php">Contact us</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i>
                    <?php 
                    // Retrieve the count of items in the cart
                    $cartItemCount = getCartItemCount(); 
                    if ($cartItemCount > 0) {
                        // Display the badge only if there are items in the cart
                        echo '<span class="badge bg-danger">' . $cartItemCount . '</span>';
                    }
                    ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user-profile.php"><i class="fas fa-user"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php"><i class="fa fa-sign-out"></i></a>
                </li>
            </ul>
        </div>
    </nav>


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script> -->
    <script src="https://kit.fontawesome.com/7785e19128.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js" integrity="sha384-7v1vbll1aXQN+/6fkI65f8F6TfT8/zy4PXdMW9sQY3TI4NdIiFqQ0W/gFqgoj3I1" crossorigin="anonymous"></script>

    <script>
        // Initialize Bootstrap components
        $(document).ready(function(){
            $('.dropdown-toggle').dropdown();
        });
    </script>

</body>
</html>
