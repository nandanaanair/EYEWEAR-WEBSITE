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
    <title>Contact Us</title>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const email = document.getElementById('email');
        const emailError = document.getElementById('emailError');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        const message = document.getElementById('message');
        const messageError = document.getElementById('messageError');
        const maxMessageLength = 50;

        email.addEventListener('input', function () {
            if (email.value.trim() === '') {
                emailError.textContent = 'Email is required.';
            } else if (!emailRegex.test(email.value)) {
                emailError.textContent = 'Enter a valid email address.';
            } else {
                emailError.textContent = '';
            }
        });

        message.addEventListener('input', function () {
            if (message.value.trim() === '') {
                messageError.textContent = 'Message is required.';
            } else if (message.value.length > maxMessageLength) {
                messageError.textContent = 'Message length exceeded. Maximum ' + maxMessageLength + ' characters allowed.';
            } else {
                messageError.textContent = '';
            }
        });
    });
</script>

<style>
    .error-message {
        color: rgb(255, 176, 176);
        font-size: 14px;
        margin-top: 5px;
    }
</style>
</head>
<body>
  <!-- logo -->
  <!-- <header>
    <h4 class="logo">
        <img src="path/to/your-logo.png" alt="Your Logo"> -->
        <!-- <a href="landing-page.html"  id="logoLink"> O⌄O VisionVibes </a>
    </h4>
</header> -->

    <!-- Navigation Bar -->
    <?php
    include 'nav.html';
    ?>

<div class="container mt-5 mb-5 d-flex flex-column align-items-center" >
    <div id="apptmt-head" class="mb-4">Contact Us Form</div>
    
    <form action="apptmt.php" method="post" class="card px-1 py-4" style="background-color: rgba(250, 246, 242, 0.315);" novalidate>
        <!-- Your existing form fields -->
        <div class="card-body" style="color: white;">
            <h6 style="font-weight: 700; font-size: large;">Email</h6>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="" name="email" id="email">
                        <div id="emailError" class="error-message"></div>
                    </div>
                </div>
            </div><br>
            <h6 style="font-weight: 700; font-size: large;">Message</h6>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <!-- Use textarea instead of input for multiline text -->
                        <textarea class="form-control" style="height: 100px;" rows="4" name="message" id="message"></textarea>
                        <div id="messageError" class="error-message"></div>
                    </div>
                </div>
            </div><br>
            <button class="btn btn-block confirm-button" id="brownBtn">Confirm</button>
        </div>
    </form>
</div>
</body>
</html>
