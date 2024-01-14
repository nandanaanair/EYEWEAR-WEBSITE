//mobile number validation
$(document).ready(function () {
    // Validation for mobile number
    $('#mobNoID').on('input', function () {
        var mobNoRegex = /^[6789]\d{9}$/;
        var mobNoInput = $(this).val();

        if (!mobNoRegex.test(mobNoInput)) {
            this.setCustomValidity('Please enter a valid 10-digit number starting with 6, 7, 8, or 9.');
        } else {
            this.setCustomValidity('');
        }
    });
});

// function showPopup(message) {
//     var popup = document.getElementById("popup");
//     popup.innerHTML = message;
//     popup.style.display = "block";

//     // Hide the pop-up after 3 seconds (adjust the time as needed)
//     setTimeout(function() {
//         popup.style.display = "none";
//     }, 3000);
// }






