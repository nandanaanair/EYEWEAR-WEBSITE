 // Get the input element and add an input event listener
 document.getElementById('searchInput').addEventListener('input', function() {
    // Get the value of the input
    var searchText = this.value.toLowerCase().trim();
    // Get all product cards
    var productCards = document.querySelectorAll('.card');
    // Loop through each product card
    productCards.forEach(function(card) {
        // Get the product name and description from the card
        var productName = card.querySelector('.card-title').textContent.toLowerCase();
        var productDescription = card.querySelector('.card-text').textContent.toLowerCase();
        // Check if the search text matches the product name or description
        if (productName.includes(searchText) || productDescription.includes(searchText)) {
            // If there's a match, show the card
            card.style.display = 'block';
        } else {
            // If there's no match, hide the card
            card.style.display = 'none';
        }
    });
});