<?php
session_start();
// Fetch the product price from the session variable
$prod_price = $_SESSION['prod_price'] ?? 0; // Default to 0 if session variable is not set
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/checkout-form.css">
    <title>Checkout</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

</head>
<body>
    <?php
    include 'nav.html';
    ?>

<div class="container mt-5">
    <h2 class="text-center">Shipping Address</h2>
    <br>
    <!-- <input type="button" id="razorGateway" name="submit" class="submit action-button"
                                    value="Pay" /> -->
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
<script>
    var prod_price = <?php echo json_encode($prod_price); ?>;
    var options = {
        "key": "rzp_test_cUE46WfnuayEgH", 
        "amount": prod_price * 100,
        "currency": "INR",
        "description": "VisionVibes",
        "image": "https://visionvibes.000webhostapp.com/logo2.png",
        "notes": {
            "address": "note value"
        },
        "theme": {
            "color": "#644432"
        },
        "config": {
            "display": {
                "blocks": {
                    "upi": {
                        "name": "Pay via UPI",
                        "instruments": [
                            {
                                "method": "upi"
                            }
                        ]
                    }
                },
                "sequence": ["block.upi"] // Corrected sequence
            }
        },
        "handler": function (response) {
            alert(response.razorpay_payment_id);
        },
        "modal": {
            "ondismiss": function () {
                if (confirm("Are you sure you want to close the form?")) {
                    txt = "You pressed OK!";
                    console.log("Checkout form closed by the user");
                } else {
                    txt = "You pressed Cancel!";
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

<!-- <script type="text/javascript"> 
    var options = {
        "key": "rzp_test_cUE46WfnuayEgH", // Enter the Key ID generated from the Dashboard
        "amount": "50000", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise or INR 500.
        "currency": "INR",
        "name": "Acme Corp",
        "description": "Ecommerce",
        "image": "image",
        //This is a sample Order ID. Create an Order using Orders API. (https://razorpay.com/docs/payment-gateway/orders/integration/#step-1-create-an-order). Refer the Checkout form table given below
        "handler": function (response){
            alert(response.razorpay_payment_id);
        },
        "prefill": {
            "name": "Gaurav Kumar",
            "email": "gaurav.kumar@example.com",
            "contact": "9999999999"
        },
        "notes": {
            "address": "note value"
        },
        "theme": {
            "color": "#EA5B29"
        },
        "config": {
            "display": {
                "blocks": {
                    "upi": {
                        "name": "Pay via UPI",
                        "instruments": [
                            {
                                "method": "upi"
                            }
                        ]
                    }
                },
                "sequence": ["block.upi"] // Corrected sequence
            }
        }
    };
    var rzp1 = new window.Razorpay(options);
    document.getElementById('razorGateway').onclick = function(e){
        rzp1.open();
        e.preventDefault();
    }
</script> -->


</body>
</html>
