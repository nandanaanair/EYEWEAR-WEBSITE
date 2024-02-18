document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchQuery');
    const rows = document.querySelectorAll('tbody tr');

    searchInput.addEventListener('input', function () {
        const filter = searchInput.value.trim().toLowerCase();
        rows.forEach(function (row) {
            const emailColumn = row.querySelector('td:nth-child(2)'); // Assuming the email column is the second column
            if (emailColumn) {
                const email = emailColumn.textContent.toLowerCase();
                if (email.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });

    const email = document.querySelector('input[name="edit_cust_email"]');
    // const emailError = document.getElementById('emailError');
    // const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    const date = document.querySelector('input[name="edit_apptmt_date"]');
    const dateError = document.getElementById('dateError');

    const time = document.querySelector('input[name="edit_apptmt_time"]');
    const timeError = document.getElementById('timeError');

    const location = document.querySelector('input[name="edit_apptmt_loc"]');
    const locationError = document.getElementById('locationError');

    // Email validation
    // email.addEventListener('input', function () {
    //     if (email.value.trim() === '') {
    //         emailError.textContent = 'Email is required.';
    //     } else if (!emailRegex.test(email.value)) {
    //         emailError.textContent = 'Enter a valid email address.';
    //     } else {
    //         emailError.textContent = '';
    //     }
    // });

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
document.addEventListener('DOMContentLoaded', function () {
    const selectTime = document.getElementById('edit_apptmt_time');

    // Generate time options
    for (let hour = 1; hour <= 23; hour++) {
        for (let minutes of ['00', '30']) {
            const timeString = `${hour}:${minutes}`;
            const option = new Option(timeString, timeString);
            selectTime.appendChild(option);
        }
    }
});
function showEditForm(apptmt_id, cust_email, apptmt_date, apptmt_time, apptmt_loc, apptmt_status) {
    // Set the values of the form fields
    document.getElementById("edit_apptmt_id").value = apptmt_id;
    document.getElementById("edit_cust_email").value = cust_email;
    document.getElementById("edit_apptmt_date").value = apptmt_date;

    // Format the time to "HH:mm"
    var formattedTime = new Date("2000-01-01T" + apptmt_time);
    var hours = formattedTime.getHours().toString().padStart(2, '0');
    var minutes = formattedTime.getMinutes().toString().padStart(2, '0');
    var formattedTimeString = hours + ":" + minutes;

    document.getElementById("edit_apptmt_time").value = formattedTimeString;
    document.getElementById("edit_apptmt_loc").value = apptmt_loc;
    document.getElementById("edit_apptmt_status").value = apptmt_status; // Set the selected status in the dropdown
    
    // Toggle the display of the edit form
    var editFormContainer = document.getElementById("editFormContainer");
    editFormContainer.style.display = (editFormContainer.style.display === "none") ? "block" : "none";
}

function showEditForm(apptmt_id, cust_email, apptmt_date, apptmt_time, apptmt_loc, apptmt_status) {
    // Set the values of the form fields
    document.getElementById("edit_apptmt_id").value = apptmt_id;
    document.getElementById("edit_cust_email").value = cust_email;
    document.getElementById("edit_apptmt_date").value = apptmt_date;
    document.getElementById("edit_apptmt_time").value = apptmt_time;
    document.getElementById("edit_apptmt_loc").value = apptmt_loc;
    document.getElementById("edit_apptmt_status").value = apptmt_status; // Set the selected status in the dropdown
    
    // Toggle the display of the edit form
    var editFormContainer = document.getElementById("editAppointmentPopupContainer");
    var overlay = document.getElementById("editAppointmentOverlay");
    editFormContainer.style.display = "block";
    overlay.style.display = "block";
}

function hideEditForm() {
    // Reset form fields
    document.getElementById('edit_first_name').value = '';
    document.getElementById('edit_last_name').value = '';
    document.getElementById('edit_email').value = '';
    document.getElementById('edit_phone').value = '';

    // Hide the edit customer form popup and overlay
    document.getElementById('editCustomerPopupContainer').style.display = 'none';
    document.getElementById('editCustomerPopupOverlay').style.display = 'none';
}

function hideEditAppointmentPopup() {
    // Reset form fields if needed
    document.getElementById('edit_apptmt_id').value = '';
    document.getElementById('edit_cust_email').value = '';
    document.getElementById('edit_apptmt_date').value = '';
    document.getElementById('edit_apptmt_time').value = '';
    document.getElementById('edit_apptmt_loc').value = '';
    document.getElementById('edit_apptmt_status').value = '';

    // Hide the edit appointment form popup and overlay
    document.getElementById('editAppointmentPopupContainer').style.display = 'none';
    document.getElementById('editAppointmentOverlay').style.display = 'none';
}

    

