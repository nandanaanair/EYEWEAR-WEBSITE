// Function to show the edit order form popup
function showEditForm(orderId, custEmail, orderDetails, orderBldg, orderCity, orderState, orderPincode, orderStatus) {
    // Populate form fields with order data
    document.getElementById('edit_order_id').value = orderId;
    document.getElementById('edit_cust_email').value = custEmail;
    document.getElementById('edit_order_details').value = orderDetails;
    document.getElementById('edit_order_bldg').value = orderBldg;
    document.getElementById('edit_order_city').value = orderCity;
    document.getElementById('edit_order_state').value = orderState;
    document.getElementById('edit_order_pincode').value = orderPincode;
    document.getElementById('edit_order_status').value = orderStatus;

    // Display the edit order form popup
    document.getElementById('editOrderPopupContainer').style.display = 'block';
    document.getElementById('editOrderPopupOverlay').style.display = 'block';
}

// Function to hide the edit order form popup
function hideEditOrderPopup() {
    // Reset form fields
    document.getElementById('edit_order_id').value = '';
    document.getElementById('edit_cust_email').value = '';
    document.getElementById('edit_order_details').value = '';
    document.getElementById('edit_order_bldg').value = '';
    document.getElementById('edit_order_city').value = '';
    document.getElementById('edit_order_state').value = '';
    document.getElementById('edit_order_pincode').value = '';
    document.getElementById('edit_order_status').value = '';

    // Hide the edit order form popup
    document.getElementById('editOrderPopupContainer').style.display = 'none';
    document.getElementById('editOrderPopupOverlay').style.display = 'none';
}

// Add event listener for edit form submission
document.getElementById('editOrderForm').addEventListener('submit', function (event) {
    // Prevent the default form submission
    event.preventDefault();

    // Validate form fields before submission
    var orderStatus = document.getElementById('edit_order_status').value.trim();

    // Perform additional validation if needed

    // If all fields are valid, submit the form
    this.submit();
});


