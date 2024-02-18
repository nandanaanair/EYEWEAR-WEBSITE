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

    // Construct the SQL query to search for customers
    $sql = "SELECT * FROM customer WHERE firstName LIKE '%$searchQuery%' OR lastName LIKE '%$searchQuery%' OR cust_email LIKE '%$searchQuery%' OR cust_phno LIKE '%$searchQuery%'";

    // Execute the query
    $result = $conn->query($sql);
}

// Handle delete action
if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['email'])) {
    $email = $_GET['email'];
    // Delete the entry from the database based on email
    $sql_delete = "DELETE FROM customer WHERE cust_email = '$email'";
    if ($conn->query($sql_delete) === TRUE) {
        // Redirect back to the page to reflect changes
        echo "<script> window.location.href='list-customer.php'</script>";
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
// Retrieve all payment details from the database
$sql = "SELECT * FROM customer";
$result = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/list-customer.css">
    <script src="./js/list-customer.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha384-4mOC5PJSq1Yq3Jasv4G1kAqQ6owlsOfQ1uHRzBy6ZYgdT1pef0nGhHPfD5QZbb3J" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.1/spectrum.min.css">
    <title>Customer List</title>
    
    <style>
      .error-message {
    color: red;
    font-size: 14px;
    margin-top: 5px;
}
  </style>
</head>

<body>

<!-- Add this overlay -->
<div id="editCustomerPopupOverlay" onclick="hideEditCustomerPopup()"></div>
    <!-- Search Form -->
    <div class="container mt-3">
        <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="text" name="searchQuery" id="searchQuery" class="search-input" placeholder="Search customers..." value="<?php echo $searchQuery; ?>">
        </form>
    </div>

    <!-- Admin Customers Section -->
    <div class="container mt-5">
        <h2 class="text-center">Customer List</h2>
        <br>
        <!-- Display customer information in a table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Edit/Update</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Check if the search query is set
            if (isset($_GET['searchQuery']) && !empty($_GET['searchQuery'])) {
                // Construct the SQL query to search for customers
                $searchQuery = $_GET['searchQuery'];
                $sql = "SELECT * FROM customer WHERE firstName LIKE '%$searchQuery%' OR lastName LIKE '%$searchQuery%' OR cust_email LIKE '%$searchQuery%' OR cust_phno LIKE '%$searchQuery%'";
                
                // Execute the query
                $result = $conn->query($sql);

                // Check if there are matching customers
                if ($result && $result->num_rows > 0) {
                    // Output HTML markup for the filtered customer list
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['firstName'] . "</td>";
                        echo "<td>" . $row['lastName'] . "</td>";
                        echo "<td>" . $row['cust_email'] . "</td>";
                        echo "<td>" . $row['cust_phno'] . "</td>";
                        echo "<td><a href='javascript:void(0);' onclick='showEditForm(\"" . $row['firstName'] . "\", \"" . $row['lastName'] . "\", \"" . $row['cust_email'] . "\", \"" . $row['cust_phno'] . "\")'>Edit</a></td>";
                        echo "<td><a href='?action=delete&email=" . $row['cust_email'] . "' onclick='return confirm(\"Are you sure you want to delete this customer?\")'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    // No matching customers found
                    echo "<tr><td colspan='6'>No customers found</td></tr>";
                }
            } else {
                // Retrieve all customer data from the database
                $sql = "SELECT * FROM customer";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['firstName'] . "</td>";
                    echo "<td>" . $row['lastName'] . "</td>";
                    echo "<td>" . $row['cust_email'] . "</td>";
                    echo "<td>" . $row['cust_phno'] . "</td>";
                    echo "<td><a href='javascript:void(0);' onclick='showEditForm(\"" . $row['firstName'] . "\", \"" . $row['lastName'] . "\", \"" . $row['cust_email'] . "\", \"" . $row['cust_phno'] . "\")'>Edit</a></td>";
                    echo "<td><a href='?action=delete&email=" . $row['cust_email'] . "' onclick='return confirm(\"Are you sure you want to delete this customer?\")'>Delete</a></td>";
                    echo "</tr>";
                }
            }
            ?>
            </tbody>
        </table>

        <!-- Edit Customer Form -->
        <div id="editCustomerPopupContainer" style="display: none;">
            <h2 class="text-center">Edit Customer</h2>
            <form action="update-customer.php" method="post" id="editCustomerForm" novalidate>
                <!-- Display customer details in form fields for editing -->
                <label for="edit_first_name">First Name:</label>
                <input type="text" id="edit_first_name" name="first_name" required>
                <span id="edit_first_name_error" class="error-message"></span>
                <br>
                <label for="edit_last_name">Last Name:</label>
                <input type="text" id="edit_last_name" name="last_name" required>
                <span id="edit_last_name_error" class="error-message"></span>
                <br>
                <label for="edit_email">Email:</label>
                <input type="email" id="edit_email" name="email" readonly>
                <span id="edit_email_error" class="error-message"></span>
                <br><br>
                <label for="edit_phone">Phone Number:</label>
                <input type="tel" id="edit_phone" name="phone" required>
                <span id="edit_phone_error" class="error-message"></span>
                <br><br>
                <!-- Add more fields if needed -->
                <button type="submit">Update Customer</button><br><br>
                <button type="button" onclick="hideEditCustomerPopup()">Cancel</button>
            </form>
        </div>

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

</script>


</body>

</html>

