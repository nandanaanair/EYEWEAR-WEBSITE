<?php
include 'authenticate-admin.php';
requireLogin();
?>

<?php
include "connect.php";

// Check if the user is logged in as admin
// if (!isset($_SESSION['admin_email'])) {
//     // Redirect to the admin login page if not logged in
//     header("Location: admin-login.php");
//     exit();
// }

// Handle delete action
if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['email'])) {
    $email = $_GET['email'];
    // Delete the entry from the database based on email
    $sql_delete = "DELETE FROM customer WHERE cust_email = '$email'";
    if ($conn->query($sql_delete) === TRUE) {
        // Redirect back to the page to reflect changes
        // header("Location: ".$_SERVER['PHP_SELF']);
        echo "<script> window.location.href='list-customer.php'</script>";
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const editFirstName = document.getElementById('edit_first_name');
        const editFirstNameError = document.getElementById('edit_first_name_error');

        const editLastName = document.getElementById('edit_last_name');
        const editLastNameError = document.getElementById('edit_last_name_error');

        const editEmail = document.getElementById('edit_email');
        const editEmailError = document.getElementById('edit_email_error');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        const editPhone = document.getElementById('edit_phone');
        const editPhoneError = document.getElementById('edit_phone_error');
        const phoneNumberRegex = /^[6789]\d{9}$/;

        // First Name validation
        editFirstName.addEventListener('input', function () {
            if (editFirstName.value.trim() === '') {
                editFirstNameError.textContent = 'First Name is required.';
            } else {
                editFirstNameError.textContent = '';
            }
        });

        // Last Name validation
        editLastName.addEventListener('input', function () {
            if (editLastName.value.trim() === '') {
                editLastNameError.textContent = 'Last Name is required.';
            } else {
                editLastNameError.textContent = '';
            }
        });

        // Email validation
        editEmail.addEventListener('input', function () {
            if (editEmail.value.trim() === '') {
                editEmailError.textContent = 'Email is required.';
            } else if (!emailRegex.test(editEmail.value)) {
                editEmailError.textContent = 'Enter a valid email address.';
            } else {
                editEmailError.textContent = '';
            }
        });

        // Phone Number validation
        editPhone.addEventListener('input', function () {
            if (editPhone.value.trim() === '') {
                editPhoneError.textContent = 'Phone Number is required.';
            } else if (!phoneNumberRegex.test(editPhone.value)) {
                editPhoneError.textContent = 'Enter a valid phone number.';
            } else {
                editPhoneError.textContent = '';
            }
        });
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

    <!-- Admin Customers Section -->
    <div class="container mt-5">
        <h2 class="text-center">Customer List</h2>
        <br>
    <!-- Add this code to your admin list products page where you want the search bar to appear -->
    <form action="admin_list_products.php" method="GET">
        <input type="text" name="search_query" placeholder="Search products...">
        <button type="submit">Search</button>
    </form>
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
                    echo "<td><a href='?action=delete&email=" . $row['cust_email'] . "' onclick='return confirm(\"Are you sure you want to delete this entry?\")'>Delete</a></td>";
                    // Add more cells if needed
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Edit Customer Form -->
        <div id="editFormContainer" style="display: none;">
            <h2 class="text-center">Edit Customer</h2>
            <form action="update-customer.php" method="post" id="editForm" novalidate> <!-- Change id to 'editForm' -->
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
                <input type="email" id="edit_email" name="email" required>
                <span id="edit_email_error" class="error-message"></span>
                <br>
                <label for="edit_phone">Phone Number:</label>
                <input type="tel" id="edit_phone" name="phone" required>
                <span id="edit_phone_error" class="error-message"></span>
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

