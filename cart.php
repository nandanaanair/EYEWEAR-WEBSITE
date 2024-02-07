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
        include 'nav.html';
    ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8">
                <h2 class="mb-4">Shopping Cart</h2>
                <div class="cart-items">
                    <!-- Cart items will be dynamically added here -->
                    <!-- Example item -->
                    <div class="cart-item bg-white shadow-sm p-3 mb-3 rounded">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <img src="https://static5.lenskart.com/media/catalog/product/pro/1/thumbnail/480x480/9df78eab33525d08d6e5fb8d27136e95//l/i/Gunmetal-Black-Full-Rim-Square-Lenskart-Air-Clip-On-LA-E14400-C2-Eyeglasses_G_7810.jpg" alt="Item 1" class="img-fluid rounded">
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-1">Product Name</h4>
                                <div class="mb-1">Product description Lorem ipsum Lorem Ipsum Lorem Ipsum</div>
                                <div class="row align-items-center mb-1">
                                    <div class="col-auto">
                                        <label class="mr-2">Quantity:</label>
                                    </div>
                                    <div class="col">
                                        <input type="number" class="form-control quantity-input" value="2">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 text-right">
                                <p class="text-muted mb-1">$20</p><br><br>
                                <button class="btn btn-sm btn-outline-danger">Remove</button>
                            </div>
                        </div>
                    </div>
                    <!-- product 2 -->
                    <div class="cart-item bg-white shadow-sm p-3 mb-3 rounded">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <img src="https://static5.lenskart.com/media/catalog/product/pro/1/thumbnail/480x480/9df78eab33525d08d6e5fb8d27136e95//l/i/Gunmetal-Black-Full-Rim-Square-Lenskart-Air-Clip-On-LA-E14400-C2-Eyeglasses_G_7810.jpg" alt="Item 1" class="img-fluid rounded">
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-1">Product Name</h4>
                                <div class="mb-1">Product description Lorem ipsum Lorem Ipsum Lorem Ipsum</div>
                                <div class="row align-items-center mb-1">
                                    <div class="col-auto">
                                        <label class="mr-2">Quantity:</label>
                                    </div>
                                    <div class="col">
                                        <input type="number" class="form-control quantity-input" value="2">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 text-right">
                                <p class="text-muted mb-1">$20</p><br><br>
                                <button class="btn btn-sm btn-outline-danger">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="cart-summary bg-white shadow-sm p-4 rounded">
                    <h4 class="mb-4">Order Summary</h4>
                    <p class="mb-2">Total Items: <span id="total-items">3</span></p>
                    <p class="mb-4">Total Price: $<span id="total-price">60</span></p>
                    <button class="btn btn-primary btn-block">Checkout</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
