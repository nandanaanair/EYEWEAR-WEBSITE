<?php
// Include file to authenticate user
include 'authenticate-user.php';
// Check if user is logged in, otherwise redirect to login page
requireLogin();
?>

<?php
// Include database connection
include "connect.php";

// Fetch the product price from the session variable
$prod_price = $_SESSION['prod_price'] ?? 0;

// Retrieve customer email and generate order ID
$cust_email = $_SESSION['cust_email'] ?? '';
$order_id = mt_rand(100000, 999999);
$_SESSION['order_id'] = $order_id;

// Initialize total price
$total_price = 0;

// Check if product ID is provided in the URL
if(isset($_GET['id'])) {
    // Fetch product price from the database based on product ID
    $prod_id = $_GET['id'];
    $product_sql = "SELECT prod_price FROM products WHERE prod_id = '$prod_id'";
    $product_result = $conn->query($product_sql);
    if ($product_result && $product_result->num_rows > 0) {
        $product_row = $product_result->fetch_assoc();
        $total_price = $product_row['prod_price'];
    } else {
        // Set default price if price not found
        $total_price = 0;
    }
} else {
    // If product ID not provided, fetch cart items for the customer
    if($cust_email) {
        $sql = "SELECT * FROM cart WHERE cust_email = '$cust_email'";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            // Iterate through cart items to calculate total price
            while($row = $result->fetch_assoc()) {
                // Fetch product price from products table based on product ID
                $product_id = $row['product_id'];
                $product_sql = "SELECT prod_price FROM products WHERE prod_id = '$product_id'";
                $product_result = $conn->query($product_sql);
                if ($product_result && $product_result->num_rows > 0) {
                    $product_row = $product_result->fetch_assoc();
                    $product_price = $product_row['prod_price'];
                    $total_price += $product_price * $row['quantity'];
                }
            }
        }
    }
}

// Store total price in session variable
$_SESSION['total_price'] = $total_price;

// Retrieve saved address data from the database based on the user's email
$user_address_sql = "SELECT * FROM customer WHERE cust_email = '$cust_email'";
$user_address_result = $conn->query($user_address_sql);

// Check if address data is found
if ($user_address_result && $user_address_result->num_rows > 0) {
    // Fetch the address data
    $user_address_row = $user_address_result->fetch_assoc();
    $saved_bldg = $user_address_row['bldg'];
    $saved_city = $user_address_row['city'];
    $saved_state = $user_address_row['state'];
    $saved_pincode = $user_address_row['pincode'];
} else {
    // Set default values if no address data is found
    $saved_bldg = '';
    $saved_city = '';
    $saved_state = '';
    $saved_pincode = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/checkout-form.css">
    <title>Checkout</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    


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
    include 'nav.php';
    ?>

<div class="container mt-5">
    <h2 class="text-center">Shipping Address</h2>
    <br>
    <!-- <input type="button" id="razorGateway" name="submit" class="submit action-button"
                                    value="Pay" /> -->


    <!-- Checkout Form -->
    <form id="paymentForm" action="process-order.php" method="post">
        <div class="form-group">
            <label class="form-label" for="order_bldg">Building/Street:</label>
            <input type="text" class="form-control" id="order_bldg" name="order_bldg" value="<?php echo $saved_bldg; ?>" required>
            <div id="orderBldgError" class="error-message"></div>
        </div>

        <div class="form-group">
            <label class="form-label" for="order_city">City:</label>
            <input type="text" class="form-control" id="order_city" name="order_city" value="<?php echo $saved_city; ?>" required>
            <div id="orderCityError" class="error-message"></div>
        </div>

        <div class="form-group">
            <label class="form-label" for="order_state">State:</label>
            <input type="text" class="form-control" id="order_state" name="order_state" value="<?php echo $saved_state; ?>" required>
            <div id="orderStateError" class="error-message"></div>
        </div>

        <div class="form-group">
            <label class="form-label" for="order_pincode">Pincode:</label>
            <input type="text" class="form-control" id="order_pincode" name="order_pincode" value="<?php echo $saved_pincode; ?>" required>
            <div id="orderPincodeError" class="error-message"></div>
        </div>
    <!-- <h2 class="text-center">Prescription Details</h2>
        <div class="form-group">
            <label class="form-label" for="pdf_file">Upload PDF of your eye prescription:</label>
            <input type="file" class="form-control" id="pdf_file" name="pdf_file" accept=".pdf">
        </div> -->

        <!-- Prescription Option Checkbox -->
        <div class="form-group" style="padding-left:20px;">
            <label class="form-check-label">
                <h4><input type="checkbox" class="form-check-input" id="prescriptionOption"></h4> <h4> I   Fill prescription details</h4>
            </label>
        </div>
        <!-- Prescription Details -->
        <div id="prescriptionDetails">
        <h2 class="text-center">Prescription Details</h2>
        
        <div class="form-group">
            <label class="form-label" for="l_sph">Left Sphere (L_SPH):</label>
            <input type="text" class="form-control" id="l_sph" name="l_sph" required>
        </div>
        <div class="form-group">
            <label class="form-label" for="r_sph">Right Sphere (R_SPH):</label>
            <input type="text" class="form-control" id="r_sph" name="r_sph" required>
        </div>
        <div class="form-group">
            <label class="form-label" for="l_cyl">Left Cylinder (L_CYL):</label>
            <input type="text" class="form-control" id="l_cyl" name="l_cyl" required>
        </div>
        <div class="form-group">
            <label class="form-label" for="r_cyl">Right Cylinder (R_CYL):</label>
            <input type="text" class="form-control" id="r_cyl" name="r_cyl" required>
        </div>
        <div class="form-group">
            <label class="form-label" for="l_axis">Left Axis (L_AXIS):</label>
            <input type="text" class="form-control" id="l_axis" name="l_axis" required>
        </div>
        <div class="form-group">
            <label class="form-label" for="r_axis">Right Axis (R_AXIS):</label>
            <input type="text" class="form-control" id="r_axis" name="r_axis" required>
        </div>
        <div class="form-group">
            <label class="form-label" for="l_addn">Left Addition (L_ADDN):</label>
            <input type="text" class="form-control" id="l_addn" name="l_addn" required>
        </div>
        <div class="form-group">
            <label class="form-label" for="r_addn">Right Addition (R_ADDN):</label>
            <input type="text" class="form-control" id="r_addn" name="r_addn" required>
        </div>

      
    </form>
</div>
<!-- Payment Button -->
<div class="form-group">
      <!-- Hidden field to store Razorpay order ID -->
      <input type="hidden" id="razorpay_order_id" name="razorpay_order_id">
    <button type="submit" id="rzp-button" class="btn btn-primary">Proceed to Payment</button>
</div>
</div>
<!-- Include Razorpay SDK -->
<script>
    var prod_price = <?php echo json_encode($_SESSION['total_price']); ?>;
    var options = {
        "key": "rzp_test_cUE46WfnuayEgH", 
        "amount": prod_price * 100,
        // "amount": 100,
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
                    payment_amt: "<?php echo $total_price; ?>", //THE PRODUCT PRICE OF $prod_price defined
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
<script src="./js/checkout-form.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
