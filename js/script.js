<<<<<<< HEAD
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


//dropdown

/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
// function myFunction() {
//     document.getElementById("myDropdown").classList.toggle("show");
//   }
  
//   // Close the dropdown if the user clicks outside of it
//   window.onclick = function(e) {
//     if (!e.target.matches('.dropbtn')) {
//     var myDropdown = document.getElementById("myDropdown");
//       if (myDropdown.classList.contains('show')) {
//         myDropdown.classList.remove('show');
//       }
//     }
//   }



=======
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


//dropdown

/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
// function myFunction() {
//     document.getElementById("myDropdown").classList.toggle("show");
//   }
  
//   // Close the dropdown if the user clicks outside of it
//   window.onclick = function(e) {
//     if (!e.target.matches('.dropbtn')) {
//     var myDropdown = document.getElementById("myDropdown");
//       if (myDropdown.classList.contains('show')) {
//         myDropdown.classList.remove('show');
//       }
//     }
//   }



>>>>>>> 578a0b26f5671bfa122584699edb4f56b0384a45
