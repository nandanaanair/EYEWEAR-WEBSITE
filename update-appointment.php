<?php
session_start();
include "connect.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $apptmt_id = $_POST['apptmt_id'];
    $apptmt_date = $_POST['apptmt_date'];
    $apptmt_time = $_POST['apptmt_time'];
    $apptmt_loc = $_POST['apptmt_loc'];
    $apptmt_status = $_POST['apptmt_status'];

    // Update the appointment in the database
    $sql = "UPDATE appointment SET apptmt_date='$apptmt_date', apptmt_time='$apptmt_time', apptmt_loc='$apptmt_loc', apptmt_status='$apptmt_status' WHERE apptmt_id='$apptmt_id'";

    if ($conn->query($sql) === TRUE) {
        // header("Location: list-appointment.php");
        echo "<script> window.location.href='list-appointment.php'</script>";
    } else {
        echo "Error updating appointment: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
