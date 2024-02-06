<!-- list-appointment.php -->
<?php
session_start();
include "connect.php";

// Check if the user is logged in as admin
// if (!isset($_SESSION['admin_email'])) {
//     // Redirect to the admin login page if not logged in
//     header("Location: admin-login.php");
//     exit();
// }

// Retrieve all appointment data from the database
$sql = "SELECT * FROM appointment";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha384-4mOC5PJSq1Yq3Jasv4G1kAqQ6owlsOfQ1uHRzBy6ZYgdT1pef0nGhHPfD5QZbb3J" crossorigin="anonymous">
    <title>Admin Appointments</title>
    <link rel="stylesheet" href="list-appointment.css">
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const email = document.querySelector('input[name="edit_cust_email"]');
        // const emailError = document.getElementById('emailError');
        // const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        const date = document.querySelector('input[name="edit_apptmt_date"]');
        const dateError = document.getElementById('dateError');

        const time = document.querySelector('input[name="edit_apptmt_time"]');
        const timeError = document.getElementById('timeError');

        const location = document.querySelector('input[name="edit_apptmt_loc"]');
        const locationError = document.getElementById('locationError');

        // Email validation
        // email.addEventListener('input', function () {
        //     if (email.value.trim() === '') {
        //         emailError.textContent = 'Email is required.';
        //     } else if (!emailRegex.test(email.value)) {
        //         emailError.textContent = 'Enter a valid email address.';
        //     } else {
        //         emailError.textContent = '';
        //     }
        // });

        // Date validation
        date.addEventListener('input', function () {
            const currentDate = new Date();
            const selectedDate = new Date(date.value);

            if (selectedDate < currentDate) {
                dateError.textContent = 'Select a future date between 2 months from today.';
            } else {
                dateError.textContent = '';
            }
        });

        // Time validation
        time.addEventListener('input', function () {
            // You can add time validation logic here if needed
            // For example, checking if the selected time is within your business hours
            // Currently, it's left empty as a placeholder
        });

        // Location validation
        location.addEventListener('input', function () {
            if (location.value.trim() === '') {
                locationError.textContent = 'Location is required.';
            } else {
                locationError.textContent = '';
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectTime = document.getElementById('edit_apptmt_time');

        // Generate time options
        for (let hour = 1; hour <= 23; hour++) {
            for (let minutes of ['00', '30']) {
                const timeString = `${hour}:${minutes}`;
                const option = new Option(timeString, timeString);
                selectTime.appendChild(option);
            }
        }
    });
</script>
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

    <!-- Admin Appointments Section -->
    <div class="container mt-5">
        <h2 class="text-center">Appointment List</h2>
        <br>

        <!-- Display appointment information in a table -->
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
                    <th>Action</th>
                    <!-- Add more columns if needed -->
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
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>


        <!-- Edit Appointment Form -->
        <div id="editFormContainer" style="display: none;">
            <h2 class="text-center">Edit Appointment</h2>
            <form action="update-appointment.php" method="post" id="editForm" novalidate>
                <!-- Display appointment details in form fields for editing -->
                <label for="edit_apptmt_id">Appointment ID:</label>
                <input type="text" id="edit_apptmt_id" name="apptmt_id" required readonly>
                <br><br>
                <label for="edit_cust_email">Customer Email:</label>
                <input type="email" id="edit_cust_email" name="cust_email" required readonly>
                <br><br>
                <label for="edit_apptmt_date">Date:</label>
                <input type="date" id="edit_apptmt_date" name="apptmt_date" required min="<?php echo date('Y-m-d'); ?>" max="<?= date('Y-m-d', strtotime('+2 months')); ?>">
                <div id="dateError" class="error-message"></div>
                <br><br>
                <label for="edit_apptmt_time">Time:</label>
                <select id="edit_apptmt_time" name="apptmt_time">
                    <option value="">Select Time</option>
                </select>                
                <br><br>
                <label for="edit_apptmt_loc">Location:</label>
                <select id="edit_apptmt_loc" name="apptmt_loc">
                            <option value="">Select Location</option>
                            <option value="Mumbai">Mumbai</option>
                            <option value="Thane">Thane</option>
                            <option value="Kalyan">Kalyan</option>
                        </select>
                        <div id="locationError" class="error-message"></div>
                <br><br>
                <!-- Add the appointment status dropdown -->
                <label for="edit_apptmt_status">Status:</label>
                <select id="edit_apptmt_status" name="apptmt_status">
                    <option value="Pending">Pending</option>
                    <option value="Completed">Completed</option>
                </select>
                <br><br>
                <!-- Add more fields if needed -->
                <button type="submit">Update Appointment</button>
            </form>
        </div>

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

    <!-- Add this part inside the showEditForm function -->
<script>
    function showEditForm(apptmt_id, cust_email, apptmt_date, apptmt_time, apptmt_loc, apptmt_status) {
        // Set the values of the form fields
        document.getElementById("edit_apptmt_id").value = apptmt_id;
        document.getElementById("edit_cust_email").value = cust_email;
        document.getElementById("edit_apptmt_date").value = apptmt_date;

        // Format the time to "HH:mm"
        var formattedTime = new Date("2000-01-01T" + apptmt_time);
        var hours = formattedTime.getHours().toString().padStart(2, '0');
        var minutes = formattedTime.getMinutes().toString().padStart(2, '0');
        var formattedTimeString = hours + ":" + minutes;

        document.getElementById("edit_apptmt_time").value = formattedTimeString;
        document.getElementById("edit_apptmt_loc").value = apptmt_loc;
        document.getElementById("edit_apptmt_status").value = apptmt_status; // Set the selected status in the dropdown
        
        // Toggle the display of the edit form
        var editFormContainer = document.getElementById("editFormContainer");
        editFormContainer.style.display = (editFormContainer.style.display === "none") ? "block" : "none";
    }
        
</script>


</body>

</html>