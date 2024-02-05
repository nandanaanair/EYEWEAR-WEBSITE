<?php
    session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha384-4mOC5PJSq1Yq3Jasv4G1kAqQ6owlsOfQ1uHRzBy6ZYgdT1pef0nGhHPfD5QZbb3J" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/view-apptmt.css">
    <title>Appointments</title> <!-- Set the web page title here -->
</head>

<body>
    
<div class="container mt-5">
    <br><br>
    <h2 class="text-center">Your Eye-Checkup Appointments</h2>
    <br>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Appointment ID</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Location</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include "connect.php";

                if (isset($_SESSION['cust_email'])) {
                    $user_email = $_SESSION['cust_email'];

                    $getAppointmentsQuery = "SELECT * FROM appointment WHERE cust_email = '$user_email'";
                    $result = mysqli_query($conn, $getAppointmentsQuery);

                    if (!$result) {
                        die("Error retrieving appointments: " . mysqli_error($conn));
                    }

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['apptmt_id'] . "</td>";
                            echo "<td>" . $row['apptmt_date'] . "</td>";
                            echo "<td>" . $row['apptmt_time'] . "</td>";
                            echo "<td>" . $row['apptmt_loc'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center'>No appointments found.</td></tr>";
                    }

                    mysqli_close($conn);
                } else {
                    echo "<tr><td colspan='4' class='text-center'>User not logged in. Redirect to login page.</td></tr>";
                    exit();
                }
                ?>
            </tbody>
        </table>
    </div>
    
    <!-- Add Appointment Button -->
    <div class="text-center mt-3">
        <a href="apptmtform.php" class="btn btn-primary">
            Get Appointment
        </a>
    </div>
</div>
<?php
    include 'nav.html';
    ?>
<!-- Bootstrap JavaScript and dependencies -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/7785e19128.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js" integrity="sha384-7v1vbll1aXQN+/6fkI65f8F6TfT8/zy4PXdMW9sQY3TI4NdIiFqQ0W/gFqgoj3I1" crossorigin="anonymous"></script>
</body>

</html>
