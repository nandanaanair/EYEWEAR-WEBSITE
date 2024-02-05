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

    <title>Add Product</title>
</head>

<body>

    <div class="container mt-5">
        <h2 class="text-center">Add Product Details</h2>
        <br>

        <!-- Product Details Form -->
        <form action="add-products.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="form-label" for="prod_name">Name:</label>
                <input type="text" class="form-control" id="prod_name" name="prod_name" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="prod_description">Description:</label>
                <textarea class="form-control" id="prod_description" name="prod_description" rows="4" required></textarea>
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
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="prod_category">Category:</label>
                <select class="form-control" id="prod_category" name="prod_category" required>
                    <option value="eyeglass">Eyeglass</option>
                    <option value="sunglass">Sunglass</option>
                    <option value="screen_glass">Screen Glass</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="prod_price">Price:</label>
                <input type="number" class="form-control" id="prod_price" name="prod_price" step="0.01" required>
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
            </div>

            <div class="form-group">
                <label class="form-label" for="prod_color">Color:</label>
                <input type="text" class="form-control" id="prod_color" name="prod_color" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="prod_img">Image(s):</label>
                <input type="file" class="form-control" id="prod_img" name="prod_img[]" accept="image/*" multiple>
            </div>

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

</body>

</html>
