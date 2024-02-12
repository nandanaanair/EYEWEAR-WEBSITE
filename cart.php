<?php
session_start();

// Check if the cart session variable exists
if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
} else {
    // If the cart is empty, initialize an empty array
    $cart = array();
}

// Function to remove a product from the cart
function removeProduct($cart, $prod_id) {
    foreach($cart as $key => $item) {
        if($item['prod_id'] == $prod_id) {
            unset($cart[$key]); // Remove the product from the cart array
            break;
        }
    }
    return $cart;
}

// Check if the remove product action is triggered
if(isset($_POST['remove_prod_id'])) {
    $remove_prod_id = $_POST['remove_prod_id'];
    $cart = removeProduct($cart, $remove_prod_id);
    $_SESSION['cart'] = $cart; // Update the cart session variable
    header("Location: cart.php"); // Redirect back to the cart page to reflect changes
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/cart.css"> <!-- Your custom styles -->
    <title>Cart</title>
    <!-- <script>
        // Function to display cart details from local storage
        function displayCart() {
            var cart = JSON.parse(localStorage.getItem('cart'));
            var cartItemsContainer = document.getElementById('cart-items');
            var totalPrice = 0;
            var totalItems = 0;

            if (cart && cart.length > 0) {
                cart.forEach(function(item) {
                    var cartItemDiv = document.createElement('div');
                    cartItemDiv.classList.add('cart-item');
                    cartItemDiv.classList.add('bg-white');
                    cartItemDiv.classList.add('shadow-sm');
                    cartItemDiv.classList.add('p-3');
                    cartItemDiv.classList.add('mb-3');
                    cartItemDiv.classList.add('rounded');

                    var productName = document.createElement('h4');
                    productName.textContent = item.prod_name;
                    cartItemDiv.appendChild(productName);

                    var productDescription = document.createElement('div');
                    productDescription.textContent = item.prod_description;
                    cartItemDiv.appendChild(productDescription);

                    var productPrice = document.createElement('p');
                    productPrice.textContent = '$' + item.prod_price;
                    cartItemDiv.appendChild(productPrice);

                    cartItemsContainer.appendChild(cartItemDiv);

                    totalPrice += parseFloat(item.prod_price);
                    totalItems++;
                });
            } else {
                cartItemsContainer.textContent = 'Cart is empty';
            }

            document.getElementById('total-items').textContent = totalItems;
            document.getElementById('total-price').textContent = totalPrice.toFixed(2);
        }

        // Call the displayCart function when the page loads
        window.onload = function() {
            displayCart();
        };
    </script> -->
</head>

<body>
    <!-- Navigation Bar -->
    <?php
        include 'nav.html';
    ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8">
                <h2 class="mb-4">Shopping Cart</h2>
                <div id="cart-items" class="cart-items">
                    <!-- Loop through cart items -->
                    <?php foreach($cart as $item) : ?>
                        <div class="cart-item bg-white shadow-sm p-3 mb-3 rounded">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <img src="<?php echo $item['prod_image']; ?>" alt="<?php echo $item['prod_name']; ?>" class="img-fluid rounded">
                                </div>
                                <div class="col-md-6">
                                    <h4 class="mb-1"><?php echo $item['prod_name']; ?></h4>
                                    <div class="mb-1"><?php echo $item['prod_description']; ?></div>
                                    <div class="row align-items-center mb-1">
                                        <div class="col-auto">
                                            <label class="mr-2">Quantity:</label>
                                        </div>
                                        <div class="col">
                                            <input type="number" class="form-control quantity-input" value="1"> <!-- Quantity input -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 text-right">
                                    <p class="text-muted mb-1"><?php echo $item['prod_price']; ?></p><br><br>
                                    <form action="" method="post">
                                        <input type="hidden" name="remove_prod_id" value="<?php echo $item['prod_id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="cart-summary bg-white shadow-sm p-4 rounded">
                    <h4 class="mb-4">Order Summary</h4>
                    <p class="mb-2">Total Items: <span id="total-items"><?php echo count($cart); ?></span></p> <!-- Total items -->
                    <p class="mb-4">Total Price: <span id="total-price">
                        <?php 
                            $totalPrice = 0;
                            foreach($cart as $item) {
                                $totalPrice += $item['prod_price'];
                            }
                            echo $totalPrice; 
                        ?>
                    </span></p> <!-- Total price -->
                    <button id="checkout-btn" class="btn btn-primary btn-block">Checkout</button>
                </div>
            </div>
        </div>
    </div>

    

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
