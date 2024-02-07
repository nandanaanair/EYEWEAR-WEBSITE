<?php
session_start();
include "connect.php";

// Handle delete action
if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['prod_id'])) {
    $prod_id = $_GET['prod_id'];
    // Delete the entry from the database based on product ID
    $sql_delete = "DELETE FROM products WHERE prod_id = $prod_id";
    if ($conn->query($sql_delete) === TRUE) {
        // Redirect back to the page to reflect changes
        // header("Location: ".$_SERVER['PHP_SELF']);
        echo "<script> window.location.href='edit-products.php'</script>";
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Retrieve all product data from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha384-4mOC5PJSq1Yq3Jasv4G1kAqQ6owlsOfQ1uHRzBy6ZYgdT1pef0nGhHPfD5QZbb3J" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.1/spectrum.min.css">
    <title>Product List</title>
    <link rel="stylesheet" href="edit-products.css">
    <script>
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

            // const image = document.getElementById('edit_prod_img');
            // const imageError = document.getElementById('imageError');

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
        });
    </script>

    <style>
      .error-message {
        color: red;
        font-size: 14px;
        margin-top: 5px;
        font-weight:bold;
    }
  </style>
</head>

<body>

    <!-- Product List Section -->
    <div class="container mt-5">
        <h2 class="text-center">Product List</h2>
        <br>

        <!-- Display product information in a table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Frame Type</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Brand</th>
                    <th>Color</th>
                    <!-- <th>Images</th> -->
                    <th>Edit/Update</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['prod_id'] . "</td>";
                    echo "<td>" . $row['prod_name'] . "</td>";
                    echo "<td>" . $row['prod_description'] . "</td>";
                    echo "<td>" . $row['prod_frametype'] . "</td>";
                    echo "<td>" . $row['prod_category'] . "</td>";
                    echo "<td>" . $row['prod_price'] . "</td>";
                    echo "<td>" . $row['prod_brand'] . "</td>";
                    echo "<td>" . $row['prod_color'] . "</td>";
                    // echo "<td>" . $row['prod_img'] . "</td>";
                    echo "<td><a href='javascript:void(0);' onclick='showEditForm(\"" . $row['prod_id'] . "\", \"" . $row['prod_name'] . "\", \"" . $row['prod_description'] . "\", \"" . $row['prod_frametype'] . "\", \"" . $row['prod_category'] . "\", \"" . $row['prod_price'] . "\", \"" . $row['prod_brand'] . "\", \"" . $row['prod_color'] . "\")'>Edit</a></td>";
                    echo "<td><a href='?action=delete&prod_id=" . $row['prod_id'] . "' onclick='return confirm(\"Are you sure you want to delete this product?\")'>Delete</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Edit Product Form -->
        <div id="editProductFormContainer" style="display: none;">
            <h2 class="text-center">Edit Product</h2>
            <form action="update-products.php" method="post" id="editProductForm" novalidate>
                <!-- Display product details in form fields for editing -->
                <label for="edit_prod_id">Product ID:</label>
                <input type="text" id="edit_prod_id" name="prod_id" required readonly>
                <br><br>
                <label for="edit_prod_name">Name:</label>
                <input type="text" id="edit_prod_name" name="prod_name" required>
                <div id="nameError" class="error-message"></div>
                <br><br>
                <label for="edit_prod_description">Description:</label>
                <textarea id="edit_prod_description" name="prod_description" rows="4" required></textarea>
                <div id="descriptionError" class="error-message"></div>
                <br><br>
                <label for="edit_prod_frametype">Frame Type:</label>
                <select id="edit_prod_frametype" name="prod_frametype" required>
                    <option value="round">Round</option>
                    <option value="square">Square</option>
                    <option value="rectangle">Rectangle</option>
                    <option value="aviator">Aviator</option>
                    <option value="cat_eye">Cat Eye</option>
                    <option value="transparent">Transparent</option>
                </select>
                <div id="frameTypeError" class="error-message"></div>
                <br><br>
                <label for="edit_prod_category">Category:</label>
                <select id="edit_prod_category" name="prod_category" required>
                    <option value="eyeglass">Eyeglass</option>
                    <option value="sunglass">Sunglass</option>
                    <option value="screen_glass">Screen Glass</option>
                </select>
                <div id="categoryError" class="error-message"></div>
                <br><br>
                <label for="edit_prod_price">Price:</label>
                <input type="number" id="edit_prod_price" name="prod_price" step="0.01" required>
                <div id="priceError" class="error-message"></div>
                <br><br>
                <label for="edit_prod_brand">Brand:</label>
                <select id="edit_prod_brand" name="prod_brand" required>
                    <option value="RayBan">RayBan</option>
                    <option value="John_Jacobs">John Jacobs</option>
                    <option value="Lee_Cooper">Lee Cooper</option>
                    <option value="Vincent_Chase">Vincent Chase</option>
                    <option value="Oakley">Oakley</option>
                </select>
                <div id="brandError" class="error-message"></div>
                <br><br>
                <label for="edit_prod_color">Color:</label>
                <input type="text" id="edit_prod_color" name="prod_color" required>
                <div id="colorError" class="error-message"></div>
                <br><br>
                <!-- <label for="edit_prod_img">Image(s):</label>
                <input type="file" id="edit_prod_img" name="prod_img[]" accept="image/*" multiple>
                <br><br> -->
                <!-- Add more fields if needed -->
                <button type="submit">Update Product</button>
            </form>
        </div>

    </div>

    <?php
    include 'admin-nav.html'; // Assuming you have a navigation bar included in the 'nav.html' file
    ?>

    <!-- Bootstrap JavaScript and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/7785e19128.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js" integrity="sha384-7v1vbll1aXQN+/6fkI65f8F6TfT8/zy4PXdMW9sQY3TI4NdIiFqQ0W/gFqgoj3I1" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.1/spectrum.min.js"></script>

    <!-- Add this part inside the showEditForm function -->
    <script>
        function showEditForm(prod_id, prod_name, prod_description, prod_frametype, prod_category, prod_price, prod_brand, prod_color) {
    // Set the values of the form fields
    document.getElementById("edit_prod_id").value = prod_id;
    document.getElementById("edit_prod_name").value = prod_name;
    document.getElementById("edit_prod_description").value = prod_description;
    document.getElementById("edit_prod_frametype").value = prod_frametype;
    document.getElementById("edit_prod_category").value = prod_category;
    document.getElementById("edit_prod_price").value = prod_price;
    document.getElementById("edit_prod_brand").value = prod_brand;
    document.getElementById("edit_prod_color").value = prod_color;

    // // Display the selected image(s) - you may need a different approach for handling images
    // document.getElementById("edit_prod_img").innerHTML = prod_img;

    // Toggle the display of the edit form
    var editProductFormContainer = document.getElementById("editProductFormContainer");
    editProductFormContainer.style.display = (editProductFormContainer.style.display === "none") ? "block" : "none";
}

    </script>

    <script>
        $(document).ready(function() {
            $("#edit_prod_color").spectrum({
                showPalette: true,
                palette: [
                    ["black", "white", "red"],
                    ["green", "blue", "yellow"],
                    ["pink", "orange", "purple"]
                    // Add more colors to the palette as needed
                ]
            });
        });
    </script>

</body>

</html>
