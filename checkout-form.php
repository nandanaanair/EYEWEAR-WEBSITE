<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/checkout-form.css">
    <title>Checkout</title>
</head>
<body>
    <?php
    include 'nav.html';
    ?>

<div class="container mt-5">
    <h2 class="text-center">Shipping Address</h2>
    <br>

    <!-- Checkout Form -->
    <form action="process-order.php" method="post" novalidate>
        <div class="form-group">
            <label class="form-label" for="order_bldg">Building/Street:</label>
            <input type="text" class="form-control" id="order_bldg" name="order_bldg" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="order_city">City:</label>
            <input type="text" class="form-control" id="order_city" name="order_city" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="order_state">State:</label>
            <input type="text" class="form-control" id="order_state" name="order_state" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="order_pincode">Pincode:</label>
            <input type="text" class="form-control" id="order_pincode" name="order_pincode" required>
        </div>

        <h2 class="text-center">Payment</h2>
        <button type="submit" class="btn btn-primary">Place Order</button>
    </form>
</div>

</body>
</html>
