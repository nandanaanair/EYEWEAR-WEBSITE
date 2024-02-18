// JavaScript for edit-products page

document.addEventListener('DOMContentLoaded', function () {
    const name = document.getElementById('edit_prod_name');
    const nameError = document.getElementById('nameError');

    const description = document.getElementById('edit_prod_description');
    const descriptionError = document.getElementById('descriptionError');

    const frameType = document.getElementById('edit_prod_frametype');
    const frameTypeError = document.getElementById('frameTypeError');

    const category = document.getElementById('edit_prod_category');
    const categoryError = document.getElementById('categoryError');

    const price = document.getElementById('edit_prod_price');
    const priceError = document.getElementById('priceError');

    const brand = document.getElementById('edit_prod_brand');
    const brandError = document.getElementById('brandError');

    const color = document.getElementById('edit_prod_color');
    const colorError = document.getElementById('colorError');

    // Add event listener for name input
    name.addEventListener('input', function () {
        if (name.value.trim() === '') {
            nameError.textContent = 'Name is required.';
        } else {
            nameError.textContent = '';
        }
    });

    // Add event listener for description input
    description.addEventListener('input', function () {
        if (description.value.trim() === '') {
            descriptionError.textContent = 'Description is required.';
        } else {
            descriptionError.textContent = '';
        }
    });

    // Add event listener for frame type selection
    frameType.addEventListener('change', function () {
        if (frameType.value === '') {
            frameTypeError.textContent = 'Frame type is required.';
        } else {
            frameTypeError.textContent = '';
        }
    });

    // Add event listener for category selection
    category.addEventListener('change', function () {
        if (category.value === '') {
            categoryError.textContent = 'Category is required.';
        } else {
            categoryError.textContent = '';
        }
    });

    // Add event listener for price input
    price.addEventListener('input', function () {
        if (price.value.trim() === '') {
            priceError.textContent = 'Price is required.';
        } else {
            priceError.textContent = '';
        }
    });

    // Add event listener for brand selection
    brand.addEventListener('change', function () {
        if (brand.value === '') {
            brandError.textContent = 'Brand is required.';
        } else {
            brandError.textContent = '';
        }
    });

    // Add event listener for color input
    color.addEventListener('input', function () {
        if (color.value.trim() === '') {
            colorError.textContent = 'Color is required.';
        } else {
            colorError.textContent = '';
        }
    });

    // Add event listener for image input
    image.addEventListener('change', function () {
        if (image.files.length === 0) {
            imageError.textContent = 'Image is required.';
        } else {
            imageError.textContent = '';
        }
    });

    // Add event listener to the search input for dynamic filtering
    const searchInput = document.getElementById('searchQuery');
    const rows = document.querySelectorAll('tbody tr');

    // Add event listener to the search input
    searchInput.addEventListener('input', function () {
        const filter = searchInput.value.toLowerCase();
        // Iterate through all rows in the table
        rows.forEach(function (row) {
            const nameColumn = row.querySelector('td:nth-child(2)'); // Assuming product name is in the second column
            const descriptionColumn = row.querySelector('td:nth-child(3)'); // Assuming product description is in the third column
            if (nameColumn && descriptionColumn) {
                const name = nameColumn.textContent.toLowerCase();
                const description = descriptionColumn.textContent.toLowerCase();
                // Toggle row display based on whether the product name or description matches the search query
                if (name.includes(filter) || description.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });
});

function showEditForm(prod_id, prod_name, prod_description, prod_frametype, prod_category, prod_price, prod_brand, prod_color, prod_img) {
    // Call a function to set the form field values
    setEditFormValues(prod_id, prod_name, prod_description, prod_frametype, prod_category, prod_price, prod_brand, prod_color, prod_img);

    // Toggle the display of the popup container
    showEditProductPopup();
}


    // Function to set the form field values
    function setEditFormValues(prod_id, prod_name, prod_description, prod_frametype, prod_category, prod_price, prod_brand, prod_color, prod_img) {
        document.getElementById("edit_prod_id").value = prod_id;
        document.getElementById("edit_prod_name").value = prod_name;
        document.getElementById("edit_prod_description").value = prod_description;
        document.getElementById("edit_prod_frametype").value = prod_frametype;
        document.getElementById("edit_prod_category").value = prod_category;
        document.getElementById("edit_prod_price").value = prod_price;
        document.getElementById("edit_prod_brand").value = prod_brand;
        document.getElementById("edit_prod_color").value = prod_color;
        // document.getElementById("edit_prod_img").src = prod_img;
        // Update image preview
        document.getElementById('edit_prod_img_preview').src = prod_img;
    }
    // Function to show the edit product form popup
    function showEditProductPopup() {
        document.getElementById("editProductPopupOverlay").style.display = "block";
        document.getElementById("editProductPopupContainer").style.display = "block";
        document.body.classList.add("popup-open"); // Disable scrolling
    }

    // Function to hide the edit product form popup
    function hideEditProductPopup() {
        document.getElementById("editProductPopupOverlay").style.display = "none";
        document.getElementById("editProductPopupContainer").style.display = "none";
        document.body.classList.remove("popup-open"); // Enable scrolling
    }

    // Function to handle image preview
    function previewImage(input) {
        // Check if any file is selected
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                // Set the src attribute of the image element to the data URL
                document.getElementById('edit_prod_img_preview').src = e.target.result;
            };

            // Read the file as a data URL
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Add event listener to the file input element
    document.getElementById('edit_prod_img').addEventListener('change', function () {
        // Call the previewImage function when a file is selected
        previewImage(this);
    });
