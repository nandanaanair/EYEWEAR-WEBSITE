document.addEventListener('DOMContentLoaded', function () {
    const prescriptionOption = document.getElementById('prescriptionOption');
    const prescriptionDetails = document.getElementById('prescriptionDetails');
    const paymentButton = document.getElementById('rzp-button');
    const form = document.getElementById('paymentForm');

    // Function to toggle visibility and required attribute of prescription details fields
    function togglePrescriptionDetails() {
        if (prescriptionOption.checked) {
            prescriptionDetails.style.display = 'block';
            // Make prescription details fields required
            document.querySelectorAll('#prescriptionDetails input').forEach(function(input) {
                input.required = true;
            });
        } else {
            prescriptionDetails.style.display = 'none';
            // Make prescription details fields not required
            document.querySelectorAll('#prescriptionDetails input').forEach(function(input) {
                input.required = false;
            });
        }
    }

    // Call the function initially to set the state based on checkbox
    togglePrescriptionDetails();

    // Function to handle form submission
    function handleFormSubmission(event) {
        console.log("Form submitted");
        // If prescription details are required and not provided, prevent form submission
        if (prescriptionOption.checked && !arePrescriptionDetailsValid()) {
            event.preventDefault(); // Prevent form submission
            alert("Please fill all the fields.");
            console.log("Prescription details invalid");
        } else {
            console.log("Form submission allowed");
        }
    }

    // Function to check if prescription details are valid
    function arePrescriptionDetailsValid() {
        // Check if prescription details fields are required and not empty
        const prescriptionInputs = document.querySelectorAll('#prescriptionDetails input');
        for (const input of prescriptionInputs) {
            if (input.required && input.value.trim() === '') {
                return false; // Prescription details are not valid
            }
        }
        return true; // Prescription details are valid
    }

    // Add event listener to the form submission
    form.addEventListener('submit', handleFormSubmission);

    // Add event listener to the "Proceed to Payment" button
    paymentButton.addEventListener('click', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault(); // Prevent form submission if the form is invalid
            alert("Please fill all the required fields.");
        }
    });

    // Add event listener to the checkbox to toggle prescription details fields
    prescriptionOption.addEventListener('change', togglePrescriptionDetails);
});
