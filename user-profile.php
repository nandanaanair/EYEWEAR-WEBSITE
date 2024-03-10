<?php
session_start();
include "connect.php";

// Check if the user is logged in
if (!isset($_SESSION['cust_email'])) {
    // Redirect to the login page if not logged in
    echo "<script> window.location.href='index.html'</script>";
    exit();
}

// Assuming you have cust_email stored in the session after login
$cust_email = $_SESSION['cust_email'];

// Fetch user details including address from the database
$stmt = $conn->prepare("SELECT * FROM customer WHERE cust_email = ?");
$stmt->bind_param("s", $cust_email);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists
if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
    $firstName = $user_data['firstName'];
    $lastName = $user_data['lastName'];
    $cust_email = $user_data['cust_email'];
    $cust_phno = $user_data['cust_phno'];
    // Add address fields
    $bldg = $user_data['bldg'];
    $city = $user_data['city'];
    $state = $user_data['state'];
    $pincode = $user_data['pincode'];
} else {
    // Redirect to the login page if the user does not exist
    echo "<script> window.location.href='login.html'</script>";
    exit();
}

// Close the database connection
$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha384-4mOC5PJSq1Yq3Jasv4G1kAqQ6owlsOfQ1uHRzBy6ZYgdT1pef0nGhHPfD5QZbb3J" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/user-profile.css">
    <title>User Profile</title> 
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
        .card {
            border: none;
            border-radius: 15px;
            background-color: #ffffff;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .placeholder-image img {
            width: 100px; 
            height: auto; 
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #2e180b;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }
    </style>
    <script>
        window.onload = function() {
            var urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('success') && urlParams.get('success') == '1') {
                displayMessage("Password Successfully changed!", "success");
            }
        };

        function displayMessage(message, type) {
            var messageContainer = document.createElement('div');
            messageContainer.textContent = message;
            messageContainer.classList.add('message', type);
            document.body.insertBefore(messageContainer, document.body.firstChild);
            setTimeout(function() {
                messageContainer.remove();
            }, 3000); // Remove message after 3 seconds
        }
    </script>
</head>

<body>

    <!-- Navigation Bar -->
    <?php
    include 'nav.php';
    ?>
    <div class="overlay" id="overlay"></div>
    <!-- User Profile Section -->
    <br>
    <h1>Your Profile</h1>
    <div class="profile-container">
        <div class="profile-header">
        <div class="placeholder-image">
        <img src="https://www.shutterstock.com/image-vector/blank-avatar-photo-place-holder-600nw-1095249842.jpg" alt="User Placeholder Image"> <br><br>
        </div>
            
            
        </div>
        <div class="profile-details">
            <h2><?php echo $firstName . ' ' . $lastName; ?></h2>
            <p><b>Email: </b><?php echo $cust_email; ?></p>
            <p><b>Phone: </b><?php echo $cust_phno; ?></p>
            <p><b>Address: </b><?php echo $bldg . ', ' . $city . ', ' . $state . ', ' . $pincode; ?></p>
            <!-- ... Add more user details if needed -->
            <div class="edit-profile-link">
            <a href="#" id="editProfileBtn">Edit Profile</a>
            </div><br>
            <div class="edit-profile-link">
            <a href="change-password.php" id="editProfileBtn">Change Password</a>
            </div><br>
            <!-- Add the delete account link/button -->
            <div class="delete-profile-link">
            <a href="#" id="deleteAccountBtn">Delete Account</a>
            </div>
            
        </div>
    </div>

    
   
    <!-- Edit Profile Form (Initially Hidden) -->
    <form id="editProfileForm" action="update-profile.php" method="POST">
        <label for="editFirstName">First Name:</label>
        <input type="text" id="editFirstName" name="editFirstName" value="<?php echo $firstName; ?>" required>

        <label for="editLastName">Last Name:</label>
        <input type="text" id="editLastName" name="editLastName" value="<?php echo $lastName; ?>" required>

        <label for="editEmail">Email:</label>
        <input type="email" id="editEmail" name="editEmail" value="<?php echo $cust_email; ?>" required disabled>

        <label for="editPhone">Phone:</label>
        <input type="tel" id="editPhone" name="editPhone" value="<?php echo $cust_phno; ?>" required>

        <label for="editBldg">Building:</label>
        <input type="text" id="editBldg" name="editBldg" value="<?php echo $bldg; ?>">

        <label for="editCity">City:</label>
        <input type="text" id="editCity" name="editCity" value="<?php echo $city; ?>">

        <label for="editState">State:</label>
        <input type="text" id="editState" name="editState" value="<?php echo $state; ?>">

        <label for="editPincode">Pincode:</label>
        <input type="text" id="editPincode" name="editPincode" value="<?php echo $pincode; ?>">


        <button type="submit">Save Changes</button>
        <button type="button" id="cancelEditBtn">Cancel</button>
    </form>
    
    <!-- Delete Account Confirmation Modal -->
    <div class="modal" id="deleteAccountModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="cancelDeleteAccount()"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete your account?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="cancelDeleteAccount()">Cancel</button>
                    <a href="delete-account.php" class="btn btn-danger">Delete Account</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <script>
    document.getElementById('editProfileBtn').addEventListener('click', function () {
    document.getElementById('editProfileForm').style.opacity = '1';
    document.getElementById('editProfileForm').style.display = 'block';
    document.getElementById('editProfileBtn').style.display = 'none';
    document.getElementById('cancelEditBtn').style.display = 'block';
    });

    document.getElementById('cancelEditBtn').addEventListener('click', function () {
        document.getElementById('editProfileForm').style.opacity = '0';
        document.getElementById('editProfileBtn').style.display = 'block';
        document.getElementById('cancelEditBtn').style.display = 'none';
        // Delay hiding the form to allow the transition to complete
        setTimeout(() => {
            document.getElementById('editProfileForm').style.display = 'none';
        }, 300); // Adjust the delay to match the transition duration
    });

    // JavaScript to handle showing the delete account modal
    document.getElementById('deleteAccountBtn').addEventListener('click', function () {
        var deleteAccountModal = new bootstrap.Modal(document.getElementById('deleteAccountModal'));
        deleteAccountModal.show();
    });

    // Function to handle modal cancellation
    function cancelDeleteAccount() {
        // Hide the delete account modal
        $('#deleteAccountModal').modal('hide');
    }

    // Function to toggle the visibility of the overlay
function toggleOverlay() {
    var overlay = document.getElementById('overlay');
    overlay.classList.toggle('active');
}

// Call the toggleOverlay function to show/hide the overlay
document.getElementById('editProfileBtn').addEventListener('click', function () {
    toggleOverlay();
    // Your existing code to show the edit profile form goes here
});

document.getElementById('cancelEditBtn').addEventListener('click', function () {
    toggleOverlay();
    // Your existing code to hide the edit profile form goes here
});


    </script>

    <!-- Bootstrap JavaScript and dependencies -->
<script src="https://kit.fontawesome.com/7785e19128.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js" integrity="sha384-7v1vbll1aXQN+/6fkI65f8F6TfT8/zy4PXdMW9sQY3TI4NdIiFqQ0W/gFqgoj3I1" crossorigin="anonymous"></script>
<?php
include "footer.php";
?>
</body>

</html>
