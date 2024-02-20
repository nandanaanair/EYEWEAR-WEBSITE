<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/cart.css"> <!-- Your custom styles -->
    <title>Cart</title>
</head>

<body>
    <!-- Navigation Bar -->
    <?php
        include 'nav.php';
    ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8">
                <h2 class="mb-4">Shopping Cart</h2>
                <div id="cart-items" class="cart-items">
                    <!-- Cart items will be displayed here dynamically using JavaScript -->
                </div>
            </div>
            <div class="col-lg-4">
                <div class="cart-summary bg-white shadow-sm p-4 rounded">
                    <h4 class="mb-4">Order Summary</h4>
                    <p class="mb-2">Total Items: <span id="total-items">0</span></p> <!-- Total items -->
                    <p class="mb-4">Total Price: <span id="total-price">0</span></p> <!-- Total price -->
                    <form action="checkout-form.php" method="post" class="d-inline">
                        <button type="submit" class="btn btn-primary" id="orderNowBtn">Checkout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Function to remove cart item and update local storage
    function removeCartItem(prod_id) {
    // Retrieve cart data from local storage
    var cartData = JSON.parse(localStorage.getItem('cart'));

    // Remove item with the specified prod_id from cartData
    if (cartData && cartData[prod_id]) {
        delete cartData[prod_id]; // This line removes the item from cartData

        // Update local storage with modified cart data
        localStorage.setItem('cart', JSON.stringify(cartData));

        // Re-render cart items
        renderCartItems(); // This line re-renders the cart items after removal
    }
}

    // Function to render cart items dynamically
    function renderCartItems() {
        var cartItemsDiv = document.getElementById('cart-items');
        cartItemsDiv.innerHTML = ''; // Clear previous items

        var totalItems = 0;
        var totalPrice = 0;

        // Retrieve cart data from local storage

        var cartData = JSON.parse(localStorage.getItem('cart'));
        // Filter out removed items from cart data
        cartData = filterRemovedItems(cartData);

        // Loop through cart data and create HTML for each item
        for (var key in cartData) {
            var item = cartData[key];
            var itemHTML = `
                <div class="cart-item bg-white shadow-sm p-3 mb-3 rounded">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <img src="${item.prod_image}" alt="${item.prod_name}" class="img-fluid rounded">
                        </div>
                        <div class="col-md-6">
                            <h4 class="mb-1">${item.prod_name}</h4>
                            <div class="mb-1">${item.prod_description}</div>
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
                        <form action="remove-cartprod.php" method="post" class="remove-form">
                            <input type="hidden" name="remove_prod_id" value="${item.prod_id}">
                            <button type="button" class="btn btn-sm btn-outline-danger remove-button" data-prod-id="${item.prod_id}">Remove</button>
                        </form>
                        </div>
                    </div>
                </div>
            `;
            cartItemsDiv.innerHTML += itemHTML;

            // Update total items and total price
            totalItems++;
            totalPrice += parseFloat(item.prod_price);
        }

        // Update total items and total price in the summary
        document.getElementById('total-items').innerText = totalItems;
        document.getElementById('total-price').innerText = totalPrice.toFixed(2);
    }
        // Function to filter out removed items from cart data
        function filterRemovedItems(cartData) {
            var filteredCartData = {};
            for (var key in cartData) {
                var item = cartData[key];
                // Check if the item exists in the cart
                if (item) {
                    filteredCartData[key] = item;
                }
            }
            return filteredCartData;
        }
        // Attach click event listener to remove buttons
        var removeButtons = document.querySelectorAll('.remove-button');
        removeButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                var prodId = event.target.dataset.prodId;
                removeCartItem(prodId);
            });
        });

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-button')) {
                var prodId = event.target.dataset.prodId;
                removeCartItem(prodId);
            }
        });

    

    // Call the renderCartItems function to display cart items
    renderCartItems();
</script>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
