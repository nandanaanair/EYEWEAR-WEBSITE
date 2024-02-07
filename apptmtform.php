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

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const email = document.querySelector('input[name="cust_email"]');
        const emailError = document.getElementById('emailError');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        const date = document.querySelector('input[name="apptmt_date"]');
        const dateError = document.getElementById('dateError');

        const time = document.querySelector('input[name="apptmt_time"]');
        const timeError = document.getElementById('timeError');

        const location = document.querySelector('input[name="apptmt_loc"]');
        const locationError = document.getElementById('locationError');

        // Email validation
        email.addEventListener('input', function () {
            if (email.value.trim() === '') {
                emailError.textContent = 'Email is required.';
            } else if (!emailRegex.test(email.value)) {
                emailError.textContent = 'Enter a valid email address.';
            } else {
                emailError.textContent = '';
            }
        });

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
    include 'nav.html';
    ?>
  

<div class="container mt-5 mb-5 d-flex flex-column align-items-center" >
    <div id="apptmt-head" class="mb-4">Schedule Your Eye-Checkup Appointment</div>
    
    <form action="apptmt.php" method="post" novalidate class="card px-1 py-4" style="background-color: rgba(250, 246, 242, 0.315);">
        <!-- Your existing form fields -->
    <!-- <div class="card px-1 py-4" style="background-color: rgba(250, 246, 242, 0.315);"> -->
        <div class="card-body" style="color: white;">
            <h5 class="card-title mb-3">This appointment is for: </h5>
            <div class="d-flex flex-row"> 
                <!-- <label class="radio mr-1"> 
                    <input type="radio" name="add" value="anz" checked> 
                    <span> <i class="fa fa-user"></i> Anz CMK </span> 
                </label> 
                <label class="radio"> 
                    <input type="radio" name="add" value="add"> 
                    <span> <i class="fa fa-plus-circle"></i> Add </span> 
                </label>  -->
                <div class="col-sm-12">
                    <div class="form-group">
                        <div class="input-group"> 
                            <input class="form-control" type="text" placeholder="Email ID" name="cust_email"> <br><br>
                            <div id="emailError" class="error-message"></div>
                        </div>
                    </div>
                </div>
            </div>
            <h5 class="information mt-4" >Please provide the required details below: </h5><br>
            <h6 style="font-weight: 700; font-size: large;">Date</h6>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <!-- <input class="form-control" type="date" placeholder="Date" name="apptmt_date">  -->
                        <input class="form-control" type="date" placeholder="Date" name="apptmt_date" min="<?php echo date('Y-m-d'); ?>" max="<?= date('Y-m-d', strtotime('+2 months')); ?>"><br>
                        <div id="dateError" class="error-message"></div>
                    </div>
                </div>
            </div><br>
            <h6 style="font-weight: 700; font-size: large;">Time</h6>
            <!-- <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <div class="input-group"> 
                            <input class="form-control" type="time" placeholder="Time" name="apptmt_time"> <br>
                            <div id="timeError" class="error-message"></div>
                        </div>
                    </div>
                </div>
            </div><br> -->
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
            <!-- <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <div class="input-group"> 
                            <input class="form-control" type="text" placeholder="Location" name="apptmt_loc"> <br>
                            <div id="locationError" class="error-message"></div>
                        </div>
                    </div>
                </div>
            </div><br> -->
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
