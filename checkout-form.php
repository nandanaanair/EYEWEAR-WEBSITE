<?php
session_start();
// Fetch the product price from the session variable
$prod_price = $_SESSION['prod_price'] ?? 0; // Default to 0 if session variable is not set
// Retrieve session variables for customer email and order ID
$cust_email = $_SESSION['cust_email'] ?? ''; // Retrieve cust_email from session
$order_id = mt_rand(100000, 999999);
$_SESSION['order_id'] = $order_id;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/checkout-form.css">
    <title>Checkout</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
    const orderForm = document.getElementById('paymentForm');
    const orderBldg = document.getElementById('order_bldg');
    const orderCity = document.getElementById('order_city');
    const orderState = document.getElementById('order_state');
    const orderPincode = document.getElementById('order_pincode');

    const orderBldgError = document.getElementById('orderBldgError');
    const orderCityError = document.getElementById('orderCityError');
    const orderStateError = document.getElementById('orderStateError');
    const orderPincodeError = document.getElementById('orderPincodeError');

    function validateOrderBldg() {
        if (orderBldg.value.trim() === '') {
            orderBldgError.textContent = 'Building/Street is required.';
            return false;
        } else {
            orderBldgError.textContent = '';
            return true;
        }
    }

    function validateOrderCity() {
        if (orderCity.value.trim() === '') {
            orderCityError.textContent = 'City is required.';
            return false;
        } else {
            orderCityError.textContent = '';
            return true;
        }
    }

    function validateOrderState() {
        if (orderState.value.trim() === '') {
            orderStateError.textContent = 'State is required.';
            return false;
        } else {
            orderStateError.textContent = '';
            return true;
        }
    }

    function validateOrderPincode() {
        const pincodeValue = orderPincode.value.trim();
        if (pincodeValue === '') {
            orderPincodeError.textContent = 'Pincode is required.';
            return false;
        } else if (!/^\d+$/.test(pincodeValue)) {
            orderPincodeError.textContent = 'Pincode must contain only numbers.';
            return false;
        } else {
            orderPincodeError.textContent = '';
            return true;
        }
    }

    orderBldg.addEventListener('input', validateOrderBldg);
    orderCity.addEventListener('input', validateOrderCity);
    orderState.addEventListener('input', validateOrderState);
    orderPincode.addEventListener('input', validateOrderPincode);

    orderForm.addEventListener('submit', function (event) {
        if (!validateOrderBldg() || !validateOrderCity() || !validateOrderState() || !validateOrderPincode()) {
            event.preventDefault(); // Prevent form submission
            alert("Please fill in all required fields correctly.");
        }
    });

    // Payment button click event
    document.getElementById('rzp-button').onclick = function (e) {
        if (!validateOrderBldg() || !validateOrderCity() || !validateOrderState() || !validateOrderPincode()) {
            e.preventDefault(); // Prevent form submission
            alert("Please fill in all required fields correctly.");
        } else {
            var rzp1 = new Razorpay(options);
            rzp1.open();
            e.preventDefault(); // Prevent form submission
        }
    };
});
</script>


<style>
      .error-message {
        color: red;
        font-size: 14px;
        margin-top: 5px;
    }
  </style>
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
    <form id="paymentForm"  method="post" novalidate>
        <div class="form-group">
            <label class="form-label" for="order_bldg">Building/Street:</label>
            <input type="text" class="form-control" id="order_bldg" name="order_bldg" required>
            <div id="orderBldgError" class="error-message"></div>
        </div>

        <div class="form-group">
            <label class="form-label" for="order_city">City:</label>
            <input type="text" class="form-control" id="order_city" name="order_city" required>
            <div id="orderCityError" class="error-message"></div>
        </div>

        <div class="form-group">
            <label class="form-label" for="order_state">State:</label>
            <input type="text" class="form-control" id="order_state" name="order_state" required>
            <div id="orderStateError" class="error-message"></div>
        </div>

        <div class="form-group">
            <label class="form-label" for="order_pincode">Pincode:</label>
            <input type="text" class="form-control" id="order_pincode" name="order_pincode" required>
            <div id="orderPincodeError" class="error-message"></div>
        </div>

        <!-- Hidden field to store Razorpay order ID -->
        <input type="hidden" id="razorpay_order_id" name="razorpay_order_id">

        <h2 class="text-center">Payment</h2>
        <button type="submit" id="rzp-button" class="btn btn-primary">Proceed to Payment</button>
    </form>
</div>
<!-- Include Razorpay SDK -->
<script>
    var prod_price = <?php echo json_encode($prod_price); ?>;
    var options = {
        "key": "rzp_test_cUE46WfnuayEgH", 
        // "amount": prod_price * 100,
        "amount": 100,
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
                // Handle successful payment
                var paymentData = {
                    trans_id: response.razorpay_payment_id,
                    payment_type: "Netbanking",
                    payment_date: new Date().toISOString().split('T')[0],
                    payment_amt: "<?php echo $prod_price; ?>",
                    cust_email: "<?php echo $cust_email; ?>", // Use cust_email retrieved from session
                    order_id: "<?php echo $order_id; ?>" // Use order_id retrieved from session
                };

                // Send payment data to server using AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'payment-details.php', true);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            console.log('Payment details stored successfully');
                            // Proceed with form submission
                            var paymentForm = document.getElementById('paymentForm');
                            paymentForm.submit();
                        } else {
                            console.error('Failed to store payment details');
                        }
                    }
                };
                xhr.send(JSON.stringify(paymentData));
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
</script>

</body>
</html>
