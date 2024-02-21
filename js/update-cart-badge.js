document.addEventListener('DOMContentLoaded', function() {
    // Fetch the cart count from the server using AJAX
    fetch('get-cart-count.php')
        .then(response => response.text())
        .then(data => {
            // Update the cart badge with the fetched count
            const cartBadge = document.getElementById('cart-badge');
            cartBadge.textContent = data;
            // Show or hide the badge based on the cart count
            if (parseInt(data) > 0) {
                cartBadge.style.display = 'inline-block';
            } else {
                cartBadge.style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error fetching cart count:', error);
        });
});
