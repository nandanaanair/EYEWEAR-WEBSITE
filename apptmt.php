<?php
session_start();
include "connect.php";

require 'phpmailer2/SMTP.php';
require 'phpmailer2/POP3.php';
require 'phpmailer2/PHPMailer.php';
require 'phpmailer2/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    // $cust_email = isset($_POST['cust_email']) ? mysqli_real_escape_string($conn, trim($_POST['cust_email'])) : '';
    $cust_email = $_SESSION['cust_email'];
    $date = isset($_POST['apptmt_date']) ? mysqli_real_escape_string($conn, trim($_POST['apptmt_date'])) : '';
    $time = isset($_POST['apptmt_time']) ? mysqli_real_escape_string($conn, trim($_POST['apptmt_time'])) : '';
    $location = isset($_POST['apptmt_loc']) ? mysqli_real_escape_string($conn, trim($_POST['apptmt_loc'])) : '';

    // Generate a random ID
    $apptmt_id = rand(1000000, 9999999);

    // Check if the appointment slot is available
    $checkAvailabilityQuery = "SELECT * FROM appointment WHERE apptmt_date = '$date' AND apptmt_time = '$time'";
    $result = mysqli_query($conn, $checkAvailabilityQuery);

    if (mysqli_num_rows($result) > 0) {
        // echo "Sorry, the selected date and time are not available. Please choose another slot.";
        echo "<script>window.location.href = 'apptmtform.php?error=1';</script>";
    } else {
        // Insert the appointment details into the database
        $insertAppointmentQuery = "INSERT INTO appointment (apptmt_id, cust_email, apptmt_date, apptmt_time, apptmt_loc) VALUES ('$apptmt_id', '$cust_email', '$date', '$time', '$location')";

        if (mysqli_query($conn, $insertAppointmentQuery)) {
            // echo "Appointment booked successfully! Check your email to view the appointment details.";
            echo "<script>window.location.href = 'apptmtform.php?success=1';</script>";

            // Send appointment details via email using PHPMailer
            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'editwithcharms@gmail.com'; // Replace with your Gmail email
                $mail->Password   = 'yomq apbp rkcq ktly'; // Use the App Password here
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                $mail->setFrom('editwithcharms@gmail.com');
                $mail->addAddress($cust_email);

                $mail->isHTML(true);
                $mail->Subject = 'Appointment Confirmation';
                $mail->Body    = 'Your appointment has been booked successfully! 
                                  Appointment ID: ' . $apptmt_id . '<br>
                                  Date: ' . $date . '<br>
                                  Time: ' . $time . '<br>
                                  Location: ' . $location;

                $mail->send();
            } catch (Exception $e) {
                exit('Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
            }
        } else {
            // echo "Error booking appointment: " . mysqli_error($conn);
            echo "<script>window.location.href = 'apptmtform.php?error=2';</script>";
        }
    }
} else {
    // echo "Invalid request method.";
    echo "<script>window.location.href = 'apptmtform.php?error=2';</script>";
}

mysqli_close($conn);
?>


