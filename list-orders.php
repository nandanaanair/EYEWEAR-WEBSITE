<?php
include 'authenticate-admin.php';
requireLogin();
?>
<?php
include "connect.php";

// Initialize variables
$searchQuery = "";

// Check if the search query is submitted
if(isset($_GET['searchQuery'])) {
    $searchQuery = $_GET['searchQuery'];

    // Construct the SQL query to search for orders
    $sql = "SELECT * FROM orders WHERE order_id LIKE '%$searchQuery%' OR cust_email LIKE '%$searchQuery%' OR order_bldg LIKE '%$searchQuery%' OR order_city LIKE '%$searchQuery%' OR order_state LIKE '%$searchQuery%' OR order_pincode LIKE '%$searchQuery%' OR order_status LIKE '%$searchQuery%' OR order_date LIKE '%$searchQuery%' OR total_price LIKE '%$searchQuery%'";

    // Execute the query
    $result = $conn->query($sql);
}

// Retrieve all order details from the database
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Orders</title>
    <link rel="stylesheet" type="text/css" href="./css/list-orders.css">
    <script src="./js/list-orders.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
</head>

<body>
    <?php include "admin-nav.html"; ?>
    <!-- Add this overlay -->
    <div id="editOrderPopupOverlay" onclick="hideEditOrderPopup()"></div>
    <!-- Search Form -->
    <div class="container mt-3">
        <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="text" name="searchQuery" id="searchQuery" class="search-input" placeholder="Search orders...">
        </form>
    </div>

    <!-- Orders Section -->
    <div class="container mt-5">
        <h2 class="text-center">Order List</h2>
        <br>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Email</th>
                    <th>Order Address</th>
                    <th>Order Status</th>
                    <th>Order Date</th>
                    <th>Total Price</th>
                    <th>Edit Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                // Check if the search query is set
                if (isset($_GET['searchQuery']) && !empty($_GET['searchQuery'])) {
                    // Construct the SQL query to search for orders
                    $searchQuery = $_GET['searchQuery'];
                    $sql = "SELECT * FROM orders WHERE order_id LIKE '%$searchQuery%' OR cust_email LIKE '%$searchQuery%' OR order_bldg LIKE '%$searchQuery%' OR order_city LIKE '%$searchQuery%' OR order_state LIKE '%$searchQuery%' OR order_pincode LIKE '%$searchQuery%' OR order_status LIKE '%$searchQuery%' OR order_date LIKE '%$searchQuery%' OR total_price LIKE '%$searchQuery%'";

                    // Execute the query
                    $result = $conn->query($sql);

                    // Check if there are matching orders
                    if ($result && $result->num_rows > 0) {
                        // Output HTML markup for the filtered order list
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['order_id'] . "</td>";
                            echo "<td>" . $row['cust_email'] . "</td>";
                            echo "<td>" . $row['order_bldg'] . ", " . $row['order_city'] . ", " . $row['order_state'] . ", " . $row['order_pincode'] . "</td>";
                            echo "<td>" . $row['order_status'] . "</td>";
                            echo "<td>" . $row['order_date'] . "</td>";
                            echo "<td>" . $row['total_price'] . "</td>";
                            echo "<td><a href='javascript:void(0);' onclick='showEditForm(\"" . $row['order_id'] . "\", \"" . $row['cust_email'] . "\", \"" . $row['order_bldg'] . "\", \"" . $row['order_city'] . "\", \"" . $row['order_state'] . "\", \"" . $row['order_pincode'] . "\", \"" . $row['order_status'] . "\", \"" . $row['order_date'] . "\", \"" . $row['total_price'] . "\")'>Edit</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        // No matching orders found
                        echo "<tr><td colspan='8'>No orders found</td></tr>";
                    }
                } else {
                    // Retrieve all order data from the database
                    $sql = "SELECT * FROM orders";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['order_id'] . "</td>";
                        echo "<td>" . $row['cust_email'] . "</td>";
                        echo "<td>" . $row['order_bldg'] . ", " . $row['order_city'] . ", " . $row['order_state'] . ", " . $row['order_pincode'] . "</td>";
                        echo "<td>" . $row['order_status'] . "</td>";
                        echo "<td>" . $row['order_date'] . "</td>";
                        echo "<td>" . $row['total_price'] . "</td>";
                        echo "<td><a href='javascript:void(0);' onclick='showEditForm(\"" . $row['order_id'] . "\", \"" . $row['cust_email'] . "\", \"" . $row['order_bldg'] . "\", \"" . $row['order_city'] . "\", \"" . $row['order_state'] . "\", \"" . $row['order_pincode'] . "\", \"" . $row['order_status'] . "\", \"" . $row['order_date'] . "\", \"" . $row['total_price'] . "\")'>Edit</a></td>";
                        echo "</tr>";
                    }
                }
            ?>

            </tbody>
        </table>
    </div>

    <!-- Edit Form Section -->
    <div id="editOrderPopupContainer" class="container mt-5" style="display: none;">
        <h2>Edit Order</h2>
        <form method="post" action="update-orders.php">
            <input type="hidden" id="edit_order_id" name="edit_order_id">
            <div class="form-group">
                <label for="edit_cust_email">Customer Email:</label>
                <input type="text" class="form-control" id="edit_cust_email" name="edit_cust_email" readonly>
            </div>
            <div class="form-group">
                <label for="edit_order_bldg">Order Building:</label>
                <input type="text" class="form-control" id="edit_order_bldg" name="edit_order_bldg" readonly>
            </div>
            <div class="form-group">
                <label for="edit_order_city">Order City:</label>
                <input type="text" class="form-control" id="edit_order_city" name="edit_order_city" readonly>
            </div>
            <div class="form-group">
                <label for="edit_order_state">Order State:</label>
                <input type="text" class="form-control" id="edit_order_state" name="edit_order_state" readonly>
            </div>
            <div class="form-group">
                <label for="edit_order_pincode">Order Pincode:</label>
                <input type="text" class="form-control" id="edit_order_pincode" name="edit_order_pincode" readonly>
            </div>
            <div class="form-group">
                <label for="edit_order_status">Order Status:</label>
                <select class="form-control" id="edit_order_status" name="edit_order_status" height="10%">
                    <option value="Pending">Pending</option>
                    <option value="Processing">Processing</option>
                    <option value="Shipped">Shipped</option>
                    <option value="Delivered">Delivered</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button> <br><br>
            <button type="button" onclick="hideEditOrderPopup()">Cancel</button>
        </form>
    </div>

    <!-- Bootstrap JavaScript and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchQuery');
    const rows = document.querySelectorAll('tbody tr');

    searchInput.addEventListener('input', function () {
        const filter = searchInput.value.trim().toLowerCase();

        rows.forEach(function (row) {
            const cells = row.querySelectorAll('td');
            let found = false;

            cells.forEach(function (cell) {
                const text = cell.textContent.trim().toLowerCase();
                if (text.includes(filter)) {
                    found = true;
                }
            });

            if (found) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});

    </script> 
</body>

</html>
