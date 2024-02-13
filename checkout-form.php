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
    <form id="paymentForm" action="process-order.php" method="post" novalidate>
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

        <!-- Hidden field to store Razorpay order ID -->
        <input type="hidden" id="razorpay_order_id" name="razorpay_order_id">

        <h2 class="text-center">Payment</h2>
        <button type="button" id="rzp-button" class="btn btn-primary">Place Order</button>
    </form>
</div>
<!-- Include Razorpay SDK -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "rzp_test_cUE46WfnuayEgH", // Enter the Key ID generated from the Dashboard
            "amount": "100",
            "currency": "INR",
            "description": "VisionVibes",
            "image": "https://s3.amazonaws.com/rzp-mobile/images/rzp.jpg",
            "prefill": {
            "email": "nan@gmail.com",
            "contact": "9372828399", // Make sure to enclose the contact number in quotes
            },
            "config": {
            "display": {
                "blocks": {
                "card": { // Name for Card block
                    "name": "Pay using Card",
                    "instruments": [
                    {
                        "method": "card",
                    }
                    ]
                },
                "netbanking": { // Name for Netbanking block
                    "name": "Pay using Netbanking",
                    "instruments": [
                    {
                        "method": "netbanking",
                    }
                    ]
                },
                "upi": { // Name for UPI block
                    "name": "Pay using UPI",
                    "instruments": [
                    {
                        "method": "upi",
                    }
                    ]
                }
                },
                "sequence": ["block.card", "block.netbanking", "block.upi"], // Define the sequence of payment methods
                "preferences": {
                "show_default_blocks": false // Should Checkout show its default blocks?
                }
            }
            },
            "handler": function (response) {
            alert(response.razorpay_payment_id);
            },
            "modal": {
            "ondismiss": function () {
                if (confirm("Are you sure you want to close the form?")) {
                console.log("Checkout form closed by the user");
                } else {
                console.log("Complete the Payment");
                }
            }
            }
        };
        var rzp1 = new Razorpay(options);
        document.getElementById('rzp-button').onclick = function (e) {
            rzp1.open();
            e.preventDefault();
        }
        </script>

</body>
</html>
