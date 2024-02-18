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

    // Construct the SQL query to search for appointments
    $sql = "SELECT * FROM appointment WHERE cust_email LIKE '%$searchQuery%'";

    // Execute the query
    $result = $conn->query($sql);
}

// Handle delete action
if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['apptmt_id'])) {
    $apptmt_id = $_GET['apptmt_id'];
    // Delete the entry from the database based on appointment ID
    $sql_delete = "DELETE FROM appointment WHERE apptmt_id = $apptmt_id";
    if ($conn->query($sql_delete) === TRUE) {
        // Redirect back to the page to reflect changes
        echo "<script> window.location.href='list-appointment.php'</script>";
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Retrieve all appointment data from the database
$sql = "SELECT * FROM appointment";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/list-appointment.css">
    <script src="./js/list-appointment.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha384-4mOC5PJSq1Yq3Jasv4G1kAqQ6owlsOfQ1uHRzBy6ZYgdT1pef0nGhHPfD5QZbb3J" crossorigin="anonymous">
    <title>Admin Appointments</title>
<style>
      .error-message {
    color: rgb(255, 176, 176);
    font-size: 14px;
    margin-top: 5px;
    width: 100%; /* Ensure the error message spans the full width */
    text-align: left; /* Align the error message to the left */
}
  </style>
</head>

<body>
    <!-- Overlay -->
    <div id="editAppointmentOverlay" class="overlay" onclick="hideEditForm()"></div>
    <!-- Search Form -->
    <div class="container mt-3">
        <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="text" name="searchQuery" id="searchQuery" class="search-input" placeholder="Search appointments..." value="<?php echo $searchQuery; ?>">
        </form>
    </div>

    <!-- Admin Appointments Section -->
    <div class="container mt-5">
        <h2 class="text-center">Appointment List</h2>
        <br>

        <!-- Display appointment information in a table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Appointment ID</th>
                    <th>Customer Email</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Edit/Update</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['apptmt_id'] . "</td>";
                echo "<td>" . $row['cust_email'] . "</td>";
                echo "<td>" . $row['apptmt_date'] . "</td>";
                echo "<td>" . $row['apptmt_time'] . "</td>";
                echo "<td>" . $row['apptmt_loc'] . "</td>";
                echo "<td>" . $row['apptmt_status'] . "</td>";
                // Check if the status is "Completed"
                if ($row['apptmt_status'] != "Completed") {
                    // Display the "Edit" link
                    echo "<td><a href='javascript:void(0);' onclick='showEditForm(\"" . $row['apptmt_id'] . "\", \"" . $row['cust_email'] . "\", \"" . $row['apptmt_date'] . "\", \"" . $row['apptmt_time'] . "\", \"" . $row['apptmt_loc'] . "\", \"" . $row['apptmt_status'] . "\")'>Edit</a></td>";
                } else {
                    // Display a disabled "Edit" link
                    echo "<td><a style='color: gray; cursor: not-allowed;'>Edit</a></td>";
                }
                echo "<td><a href='?action=delete&apptmt_id=" . $row['apptmt_id'] . "' onclick='return confirm(\"Are you sure you want to delete this appointment?\")'>Delete</a></td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>


        <!-- Edit Appointment Form Popup Container -->
        <div id="editAppointmentPopupContainer" class="edit-form-container">
            <h2 class="text-center">Edit Appointment</h2>
            <form action="update-appointment.php" method="post" id="editForm" novalidate>
                <!-- Display appointment details in form fields for editing -->
                <label for="edit_apptmt_id">Appointment ID:</label>
                <input type="text" id="edit_apptmt_id" name="apptmt_id" required readonly>
                <br>
                <label for="edit_cust_email">Customer Email:</label>
                <input type="email" id="edit_cust_email" name="cust_email" required readonly>
                <br>
                <label for="edit_apptmt_date">Date:</label>
                <input type="date" id="edit_apptmt_date" name="apptmt_date" required min="<?php echo date('Y-m-d'); ?>" max="<?= date('Y-m-d', strtotime('+2 months')); ?>">
                <div id="dateError" class="error-message"></div>
                <label for="edit_apptmt_time">Time:</label>
                <select id="edit_apptmt_time" name="apptmt_time">
                    <option value="">Select Time</option>
                </select>                
                <br>
                <label for="edit_apptmt_loc">Location:</label>
                <select id="edit_apptmt_loc" name="apptmt_loc">
                            <option value="">Select Location</option>
                            <option value="Mumbai">Mumbai</option>
                            <option value="Thane">Thane</option>
                            <option value="Kalyan">Kalyan</option>
                        </select>
                        <div id="locationError" class="error-message"></div>
                <br>
                <!-- Add the appointment status dropdown -->
                <label for="edit_apptmt_status">Status:</label>
                <select id="edit_apptmt_status" name="apptmt_status">
                    <option value="Pending">Pending</option>
                    <option value="Completed">Completed</option>
                </select>
                <br><br>
                <!-- Add more fields if needed -->
                <button type="submit">Update Appointment</button>
            <button type="button" onclick="hideEditAppointmentPopup()">Cancel</button>
        </form>
    </div>

    <?php
    // Include your admin navigation bar file
    include 'admin-nav.html';
    ?>
    <!-- Bootstrap JavaScript and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/7785e19128.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js" integrity="sha384-7v1vbll1aXQN+/6fkI65f8F6TfT8/zy4PXdMW9sQY3TI4NdIiFqQ0W/gFqgoj3I1" crossorigin="anonymous"></script>


</body>
</html>