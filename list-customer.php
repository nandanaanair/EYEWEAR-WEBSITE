<?php
session_start();
include "connect.php";

// Check if the user is logged in as admin
// if (!isset($_SESSION['admin_email'])) {
//     // Redirect to the admin login page if not logged in
//     header("Location: admin-login.php");
//     exit();
// }

// Retrieve all customer data from the database
$sql = "SELECT * FROM customer";
$result = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha384-4mOC5PJSq1Yq3Jasv4G1kAqQ6owlsOfQ1uHRzBy6ZYgdT1pef0nGhHPfD5QZbb3J" crossorigin="anonymous">
    <title>Customer List</title>
    <link rel="stylesheet" href="list-customer.css">
</head>

<body>

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
                    <th>Action</th>
                    <!-- Add more columns if needed -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through each row of customer data
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['firstName'] . "</td>";
                    echo "<td>" . $row['lastName'] . "</td>";
                    echo "<td>" . $row['cust_email'] . "</td>";
                    echo "<td>" . $row['cust_phno'] . "</td>";
                    echo "<td><a href='javascript:void(0);' onclick='showEditForm(\"" . $row['firstName'] . "\", \"" . $row['lastName'] . "\", \"" . $row['cust_email'] . "\", \"" . $row['cust_phno'] . "\")'>Edit</a></td>";
                    // Add more cells if needed
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Edit Customer Form -->
        <div id="editFormContainer" style="display: none;">
            <h2 class="text-center">Edit Customer</h2>
            <form action="update-customer.php" method="post" id="editForm"> <!-- Change id to 'editForm' -->
                <!-- Display customer details in form fields for editing -->
                <label for="edit_first_name">First Name:</label>
                <input type="text" id="edit_first_name" name="first_name" required>
                <br>
                <label for="edit_last_name">Last Name:</label>
                <input type="text" id="edit_last_name" name="last_name" required>
                <br>
                <label for="edit_email">Email:</label>
                <input type="email" id="edit_email" name="email" required>
                <br>
                <label for="edit_phone">Phone Number:</label>
                <input type="tel" id="edit_phone" name="phone" required>
                <br>
                <!-- Add more fields if needed -->
                <button type="submit">Update Customer</button>
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

    <script>
    function showEditForm(firstName, lastName, email, phone) {
    // Set the values of the form fields
    document.getElementById("edit_first_name").value = firstName;
    document.getElementById("edit_last_name").value = lastName;
    document.getElementById("edit_email").value = email;
    document.getElementById("edit_phone").value = phone;

    // Toggle the display of the edit form
    var editFormContainer = document.getElementById("editFormContainer");
    editFormContainer.style.display = (editFormContainer.style.display === "none") ? "block" : "none";
}

</script>


</body>

</html>

