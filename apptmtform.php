<?php
include 'authenticate-user.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/apptmt.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="js/script.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <title>Appointment</title>
    <style>
        .message {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .success {
            background-color: #7caf4c;
            color: white;
        }
        .error {
            background-color: #943726;
            color: white;
        }
    </style>
    <script>
        window.onload = function() {
            var urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('error') && urlParams.get('error') == '1') {
                displayMessage("Appointment slot not available. Please choose another slot.", "error");
            }else if (urlParams.has('error') && urlParams.get('error') == '2') {
                displayMessage("Booking failed please try again.", "error");
            }
        };

        function displayMessage(message, type) {
            var messageContainer = document.createElement('div');
            messageContainer.textContent = message;
            messageContainer.classList.add('message', type);
            document.body.insertBefore(messageContainer, document.body.firstChild);
            setTimeout(function() {
                messageContainer.remove();
            }, 5000); // Remove message after 3 seconds
        }

    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        const date = document.querySelector('input[name="apptmt_date"]');
        const dateError = document.getElementById('dateError');

        const time = document.querySelector('input[name="apptmt_time"]');
        const timeError = document.getElementById('timeError');

        const location = document.querySelector('input[name="apptmt_loc"]');
        const locationError = document.getElementById('locationError');

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
        const selectTime = document.getElementById('apptmt_time');

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
    <!-- Navigation Bar -->
    <?php
    include 'nav.php';
    ?>
  

<div class="container mt-5 mb-5 d-flex flex-column align-items-center" >
    <div id="apptmt-head" class="mb-4">Schedule Your Eye-Checkup Appointment</div>
    
    <form action="apptmt.php" method="post" novalidate class="card px-1 py-4" style="background-color: rgba(250, 246, 242, 0.315);">

        <div class="card-body" style="color: white;">
            <h5 class="information mt-1" >Please provide the required details below: </h5><br>
            <h6 style="font-weight: 700; font-size: large;">Date</h6>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <!-- <input class="form-control" type="date" placeholder="Date" name="apptmt_date">  -->
                        <input class="form-control" type="date" placeholder="Date" name="apptmt_date" min="<?php echo date('Y-m-d'); ?>" max="<?= date('Y-m-d', strtotime('+2 months')); ?>"><br>
                        <div id="dateError" class="error-message"></div>
                    </div>
                </div>
            </div>
            <h6 style="font-weight: 700; font-size: large;">Time</h6>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <select class="form-control" id="apptmt_time" name="apptmt_time">
                            <option value="">Select Time</option>
                        </select>
                    </div>
                </div>
            </div><br>
            <h6 style="font-weight: 700; font-size: large;">Location</h6>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <select class="form-control" id="apptmt_loc" name="apptmt_loc">
                            <option value="">Select Location</option>
                            <option value="Mumbai">Mumbai</option>
                            <option value="Thane">Thane</option>
                            <option value="Kalyan">Kalyan</option>
                        </select>
                        <div id="locationError" class="error-message"></div>
                    </div>
                </div>
            </div><br>

            <button class="btn btn-block confirm-button" id="brownBtn">Confirm</button>
        </div>
    </div>
</div>
</body>
</html>
