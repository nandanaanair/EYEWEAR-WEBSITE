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
    
    <form action="apptmt.php" method="post" class="card px-1 py-4" style="background-color: rgba(250, 246, 242, 0.315);">
        <!-- Your existing form fields -->
        <div class="card-body" style="color: white;">
            <h6 style="font-weight: 700; font-size: large;">Email</h6>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="" name="email"> 
                    </div>
                </div>
            </div><br>
            <h6 style="font-weight: 700; font-size: large;">Message</h6>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <!-- Use textarea instead of input for multiline text -->
                        <textarea class="form-control" style="height: 100px;" rows="4" name="message"></textarea>
                    </div>
                </div>
            </div><br>
            <button class="btn btn-block confirm-button" id="brownBtn">Confirm</button>
        </div>
    </form>
</div>
</body>
</html>
