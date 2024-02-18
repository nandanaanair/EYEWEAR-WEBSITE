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

    // Construct the SQL query to search for payments
    $sql = "SELECT * FROM payment WHERE trans_id LIKE '%$searchQuery%' OR payment_type LIKE '%$searchQuery%' OR payment_date LIKE '%$searchQuery%' OR payment_amount LIKE '%$searchQuery%' OR customer_email LIKE '%$searchQuery%' OR order_id LIKE '%$searchQuery%'";

    // Execute the query
    $result = $conn->query($sql);
}

// Retrieve all payment details from the database
$sql_all_payments = "SELECT * FROM payment";
$result_all_payments = $conn->query($sql_all_payments);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/list-payment.css">
    <script src="./js/list-payment.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha384-4mOC5PJSq1Yq3Jasv4G1kAqQ6owlsOfQ1uHRzBy6ZYgdT1pef0nGhHPfD5QZbb3J" crossorigin="anonymous">
    <title>Payment Details</title>
    <!-- Include any necessary CSS styles here -->
</head>

<body>
    <!-- Add this input field for the search bar above the table -->
    <div class="container mt-3">
        <form>
            <input type="text" id="searchQuery" class="search-input" placeholder="Search payments...">
        </form>
    </div>
    <!-- Display payment details in a table -->
    <div class="container mt-5">
        <h2 class="text-center">Payment Details</h2>
        <br>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Payment Type</th>
                    <th>Payment Date</th>
                    <th>Payment Amount</th>
                    <th>Customer Email</th>
                    <th>Order ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if the search query is set
                if (isset($_GET['searchQuery']) && !empty($_GET['searchQuery'])) {
                    // Check if there are matching payments
                    if ($result && $result->num_rows > 0) {
                        // Output HTML markup for the filtered payment list
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['trans_id'] . "</td>";
                            echo "<td>" . $row['payment_type'] . "</td>";
                            echo "<td>" . $row['payment_date'] . "</td>";
                            echo "<td>" . $row['payment_amt'] . "</td>";
                            echo "<td>" . $row['cust_email'] . "</td>";
                            echo "<td>" . $row['order_id'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        // No matching payments found
                        echo "<tr><td colspan='6'>No payments found</td></tr>";
                    }
                } else {
                    // Output HTML markup for all payments
                    while ($row = $result_all_payments->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['trans_id'] . "</td>";
                        echo "<td>" . $row['payment_type'] . "</td>";
                        echo "<td>" . $row['payment_date'] . "</td>";
                        echo "<td>" . $row['payment_amt'] . "</td>";
                        echo "<td>" . $row['cust_email'] . "</td>";
                        echo "<td>" . $row['order_id'] . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
    include 'admin-nav.html'; // Assuming you have a navigation bar included in the 'nav.html' file
    ?>
    <!-- Bootstrap JavaScript and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/7785e19128.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js" integrity="sha384-7v1vbll1aXQN+/6fkI65f8F6TfT8/zy4PXdMW9sQY3TI4NdIiFqQ0W/gFqgoj3I1" crossorigin="anonymous"></script>

</body>

</html>

<?php
// Close database connection
$conn->close();
?>
