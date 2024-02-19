// Filter and sort products
$(document).ready(function () {
    // Apply filters
    $('#applyFiltersBtn').click(function () {
        // Get selected filter values
        var brandFilters = [];
        $('input[name="brand"]:checked').each(function () {
            brandFilters.push($(this).val());
        });
        var priceFilter = $('#price').val();
        
        // Determine the category based on the context
        var category = getCategory(); // Implement this function to dynamically determine the category
        
        // Make AJAX request to filter products
        $.ajax({
            type: 'POST',
            url: 'filter-products.php',
            data: {
                category: category,
                brands: brandFilters,
                price: priceFilter
            },
            success: function (response) {
                $('#productContainer').html(response);
            }
        });
    });

    // Apply sorting
    $('#sort').change(function () {
        // Get selected sorting option
        var sortBy = $(this).val();
        
        // Determine the category based on the context
        var category = getCategory(); // Implement this function to dynamically determine the category

        // Make AJAX request to sort products
        $.ajax({
            type: 'POST',
            url: 'sort-products.php',
            data: {
                category: category,
                sort: sortBy
            },
            success: function (response) {
                $('#productContainer').html(response);
            }
        });
    });

    // Function to dynamically determine the category based on the context
    function getCategory() {
        // Get the current page URL
        var currentPageUrl = window.location.href;

        // Check if the URL contains keywords or patterns that identify the category
        if (currentPageUrl.indexOf('/eyeglasses') !== -1) {
            return 'eyeglass';
        } else if (currentPageUrl.indexOf('/sunglasses') !== -1) {
            return 'sunglass';
        } else if (currentPageUrl.indexOf('/screenglasses') !== -1) {
            return 'screen_glass';
        }

        // If the category cannot be determined from the URL, you can add additional logic here
        // For example, you can check other page elements or attributes to identify the category

        // If no category is determined, you can return a default value or handle it accordingly
        return 'unknown';
    }

});
