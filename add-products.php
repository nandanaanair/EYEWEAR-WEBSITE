<?php
// Assuming you have a database connection
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $prod_name = $_POST["prod_name"];
    $prod_description = $_POST["prod_description"];
    $prod_frametype = $_POST["prod_frametype"];
    $prod_category = $_POST["prod_category"];
    $prod_price = $_POST["prod_price"];
    $prod_brand = $_POST["prod_brand"];
    $prod_color = $_POST["prod_color"];

    // Generate a random 5-digit prod_id
    $prod_id = rand(10000, 99999);

    // Handle image upload (commented out for now)
    // $imageFiles = $_FILES["prod_img"];
    // $imagePaths = [];

    // foreach ($imageFiles["tmp_name"] as $key => $tmpName) {
    //     $fileName = $imageFiles["name"][$key];
    //     $imagePath = "path/to/upload/directory/" . $fileName; // Set your upload directory
    //     move_uploaded_file($tmpName, $imagePath);
    //     $imagePaths[] = $imagePath;
    // }

    // Insert product details into the 'product' table
    $sql = "INSERT INTO products (prod_id, prod_name, prod_description, prod_frametype, prod_category, prod_price, prod_brand, prod_color) 
            VALUES ('$prod_id', '$prod_name', '$prod_description', '$prod_frametype', '$prod_category', '$prod_price', '$prod_brand', '$prod_color')";

    if ($conn->query($sql) === TRUE) {
        // Insert image paths into the 'prod_images' table (commented out for now)
        // foreach ($imagePaths as $imagePath) {
        //     $sql = "INSERT INTO prod_images (prod_id, image_path) VALUES ('$prod_id', '$imagePath')";
        //     $conn->query($sql);
        // }

        echo "Product added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/add-products.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha384-4mOC5PJSq1Yq3Jasv4G1kAqQ6owlsOfQ1uHRzBy6ZYgdT1pef0nGhHPfD5QZbb3J" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.1/spectrum.min.css">
    <title>Add Product</title>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const name = document.getElementById('prod_name');
            const nameError = document.getElementById('nameError');

            const description = document.getElementById('prod_description');
            const descriptionError = document.getElementById('descriptionError');

            const frameType = document.getElementById('prod_frametype');
            const frameTypeError = document.getElementById('frameTypeError');

            const category = document.getElementById('prod_category');
            const categoryError = document.getElementById('categoryError');

            const price = document.getElementById('prod_price');
            const priceError = document.getElementById('priceError');

            const brand = document.getElementById('prod_brand');
            const brandError = document.getElementById('brandError');

            const color = document.getElementById('prod_color');
            const colorError = document.getElementById('colorError');

            const image = document.getElementById('prod_img');
            const imageError = document.getElementById('imageError');

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

    <div class="container mt-5">
        <h2 class="text-center">Add Product Details</h2>
        <br>

        <!-- Product Details Form -->
        <form action="add-products.php" method="post" enctype="multipart/form-data" novalidate>
            <div class="form-group">
                <label class="form-label" for="prod_name">Name:</label>
                <input type="text" class="form-control" id="prod_name" name="prod_name" required>
                <div id="nameError" class="error-message"></div>
            </div>

            <div class="form-group">
                <label class="form-label" for="prod_description">Description:</label>
                <textarea class="form-control" id="prod_description" name="prod_description" rows="4" required></textarea>
                <div id="descriptionError" class="error-message"></div>
            </div>

            <div class="form-group">
                <label class="form-label" for="prod_frametype"> Select Frame Type:</label>
                <div class="dropdown">
                    <select class="form-control" id="prod_frametype" name="prod_frametype" required>
                        <option value="round">Round</option>
                        <option value="square">Square</option>
                        <option value="rectangle">Rectangle</option>
                        <option value="aviator">Aviator</option>
                        <option value="cat_eye">Cat Eye</option>
                        <option value="transparent">Transparent</option>
                    </select>
                    <div id="frameTypeError" class="error-message"></div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="prod_category">Category:</label>
                <select class="form-control" id="prod_category" name="prod_category" required>
                    <option value="eyeglass">Eyeglass</option>
                    <option value="sunglass">Sunglass</option>
                    <option value="screen_glass">Screen Glass</option>
                </select>
                <div id="categoryError" class="error-message"></div>
            </div>

            <div class="form-group">
                <label class="form-label" for="prod_price">Price:</label>
                <input type="number" class="form-control" id="prod_price" name="prod_price" step="0.01" required>
                <div id="priceError" class="error-message"></div>
            </div>

            <div class="form-group">
                <label class="form-label" for="prod_brand">Brand:</label>
                <select class="form-control" id="prod_brand" name="prod_brand" required>
                    <option value="RayBan">RayBan</option>
                    <option value="John_Jacobs">John Jacobs</option>
                    <option value="Lee_Cooper">Lee Cooper</option>
                    <option value="Vincent_Chase">Vincent Chase</option>
                    <option value="Oakley">Oakley</option>
                </select>
                <div id="brandError" class="error-message"></div>
            </div>

            <div class="form-group">
                <label class="form-label" for="prod_color">Color:</label>
                <input type="text" class="form-control" id="prod_color" name="prod_color" required>
                <div id="colorError" class="error-message"></div>
            </div>

            <!-- <div class="form-group">
                <label class="form-label" for="prod_img">Image(s):</label>
                <input type="file" class="form-control" id="prod_img" name="prod_img[]" accept="image/*" multiple>
                <div id="imageError" class="error-message"></div>
            </div> -->

            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>

    </div>

    <?php
    include 'admin-nav.html'; // Assuming you have a navigation bar included in the 'nav.html' file
    ?>
    
    <!-- Bootstrap JavaScript and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-o3U9eTl7XNByA6s8g6ZlfMELWeQkPK++vaqTTccVcLQ84aLjO20ZddQPKhy4e6oB" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.1/spectrum.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#prod_color").spectrum({
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
