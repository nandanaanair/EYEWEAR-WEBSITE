// Function to show the edit customer form popup
function showEditForm(firstName, lastName, email, phone) {
    // Populate form fields with customer data
    document.getElementById('edit_first_name').value = firstName;
    document.getElementById('edit_last_name').value = lastName;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_phone').value = phone;

    // Display the edit customer form popup
    document.getElementById('editCustomerPopupContainer').style.display = 'block';
    document.getElementById('editCustomerPopupOverlay').style.display = 'block';
}

// Function to hide the edit customer form popup
function hideEditCustomerPopup() {
    // Reset form fields
    document.getElementById('edit_first_name').value = '';
    document.getElementById('edit_last_name').value = '';
    document.getElementById('edit_email').value = '';
    document.getElementById('edit_phone').value = '';

    // Hide the edit customer form popup
    document.getElementById('editCustomerPopupContainer').style.display = 'none';
    document.getElementById('editCustomerPopupOverlay').style.display = 'none';
}
// Function to show the edit customer form popup
function showEditForm(firstName, lastName, email, phone) {
    // Populate form fields with customer data
    document.getElementById('edit_first_name').value = firstName;
    document.getElementById('edit_last_name').value = lastName;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_phone').value = phone;

    // Display the edit customer form popup
    document.getElementById('editCustomerPopupContainer').style.display = 'block';
    document.getElementById('editCustomerPopupOverlay').style.display = 'block';
}

// Function to hide the edit customer form popup
function hideEditCustomerPopup() {
    // Reset form fields
    document.getElementById('edit_first_name').value = '';
    document.getElementById('edit_last_name').value = '';
    document.getElementById('edit_email').value = '';
    document.getElementById('edit_phone').value = '';

    // Hide the edit customer form popup
    document.getElementById('editCustomerPopupContainer').style.display = 'none';
    document.getElementById('editCustomerPopupOverlay').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function () {
    // Add event listener to the search input for dynamic filtering
    const searchInput = document.getElementById('searchQuery');
    const rows = document.querySelectorAll('tbody tr');

    searchInput.addEventListener('input', function () {
        const filter = searchInput.value.trim().toLowerCase();
        rows.forEach(function (row) {
            const firstNameColumn = row.querySelector('td:nth-child(1)');
            const lastNameColumn = row.querySelector('td:nth-child(2)');
            const emailColumn = row.querySelector('td:nth-child(3)');
            const phoneColumn = row.querySelector('td:nth-child(4)');
            if (firstNameColumn && lastNameColumn && emailColumn && phoneColumn) {
                const firstName = firstNameColumn.textContent.toLowerCase();
                const lastName = lastNameColumn.textContent.toLowerCase();
                const email = emailColumn.textContent.toLowerCase();
                const phone = phoneColumn.textContent.toLowerCase();
                if (firstName.includes(filter) || lastName.includes(filter) || email.includes(filter) || phone.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });
});



// Event listener for edit form submission
document.getElementById('editCustomerForm').addEventListener('submit', function (event) {
    // Prevent the default form submission
    event.preventDefault();

    // Validate form fields before submission
    var firstName = document.getElementById('edit_first_name').value.trim();
    var lastName = document.getElementById('edit_last_name').value.trim();
    var email = document.getElementById('edit_email').value.trim();
    var phone = document.getElementById('edit_phone').value.trim();
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var phoneNumberRegex = /^[6789]\d{9}$/;

    // Validate first name
    if (firstName === '') {
        document.getElementById('edit_first_name_error').textContent = 'First Name is required.';
        return;
    } else {
        document.getElementById('edit_first_name_error').textContent = '';
    }

    // Validate last name
    if (lastName === '') {
        document.getElementById('edit_last_name_error').textContent = 'Last Name is required.';
        return;
    } else {
        document.getElementById('edit_last_name_error').textContent = '';
    }

    // Validate email
    if (email === '') {
        document.getElementById('edit_email_error').textContent = 'Email is required.';
        return;
    } else if (!emailRegex.test(email)) {
        document.getElementById('edit_email_error').textContent = 'Enter a valid email address.';
        return;
    } else {
        document.getElementById('edit_email_error').textContent = '';
    }

    // Validate phone number
    if (phone === '') {
        document.getElementById('edit_phone_error').textContent = 'Phone Number is required.';
        return;
    } else if (!phoneNumberRegex.test(phone)) {
        document.getElementById('edit_phone_error').textContent = 'Enter a valid phone number.';
        return;
    } else {
        document.getElementById('edit_phone_error').textContent = '';
    }

    // If all fields are valid, submit the form
    this.submit();
});
