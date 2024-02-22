<?php
include 'authenticate-admin.php';
requireLogin();
?>
<?php
include "connect.php";

// Initialize variables
$searchQuery = "";

// Check if the search query is submitted
if(isset($_GET['searchQuery'])) {
    $searchQuery = $_GET['searchQuery'];

    // Construct the SQL query to search for products
    $sql = "SELECT * FROM products WHERE prod_name LIKE '%$searchQuery%' OR prod_description LIKE '%$searchQuery%'";

    // Execute the query
    $result = $conn->query($sql);
}

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
// Handle update action
// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
//     $prod_id = $_POST['prod_id'];
//     $prod_name = $_POST['prod_name'];
//     $prod_description = $_POST['prod_description'];
//     $prod_frametype = $_POST['prod_frametype'];
//     $prod_category = $_POST['prod_category'];
//     $prod_price = $_POST['prod_price'];
//     $prod_brand = $_POST['prod_brand'];
//     $prod_color = $_POST['prod_color'];

//     // Check if a file was uploaded
//     if(isset($_FILES['prod_img']) && $_FILES['prod_img']['error'] === UPLOAD_ERR_OK) {
//         $file_tmp = $_FILES['prod_img']['tmp_name'];
//         $file_name = $_FILES['prod_img']['name'];
//         $file_type = $_FILES['prod_img']['type'];

//         // Move uploaded file to desired location
//         $target_dir = "uploads/";
//         $target_file = $target_dir . basename($file_name);

//         if (move_uploaded_file($file_tmp, $target_file)) {
//             // Update the image path in the database
//             $sql_update_img = "UPDATE products SET prod_name='$prod_name', prod_description='$prod_description', prod_frametype='$prod_frametype', prod_category='$prod_category', prod_price='$prod_price', prod_brand='$prod_brand', prod_color='$prod_color', prod_img='$target_file' WHERE prod_id=$prod_id";

//             if ($conn->query($sql_update_img) === TRUE) {
//                 // Redirect back to the page to reflect changes
//                 echo "<script> window.location.href='edit-products.php'</script>";
//                 exit();
//             } else {
//                 echo "Error updating record: " . $conn->error;
//             }
//         } else {
//             echo "Error uploading file.";
//         }
//     }
// }

// Retrieve all product data from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/edit-products.css">
    <script src="./js/edit-products.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha384-4mOC5PJSq1Yq3Jasv4G1kAqQ6owlsOfQ1uHRzBy6ZYgdT1pef0nGhHPfD5QZbb3J" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.1/spectrum.min.css">
    <title>Product List</title>
</head>

<body>
    <!-- Add this overlay -->
    <div id="editProductPopupOverlay" onclick="hideEditProductPopup()"></div>
    <!-- Search Form -->
    <div class="container mt-3">
        <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="text" name="searchQuery" id="searchQuery" class="search-input" placeholder="Search products..." value="<?php echo $searchQuery; ?>">
        </form>
    </div>

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
                    <th>Image</th>
                    <th>Edit/Update</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
            <tbody>
            <?php
            // Check if the search query is set
            if (isset($_GET['searchQuery']) && !empty($_GET['searchQuery'])) {
                // Construct the SQL query to search for products
                $searchQuery = $_GET['searchQuery'];
                $sql = "SELECT * FROM products WHERE prod_name LIKE '%$searchQuery%' OR prod_description LIKE '%$searchQuery%'";
                
                // Execute the query
                $result = $conn->query($sql);

                // Check if there are matching products
                if ($result && $result->num_rows > 0) {
                    // Output HTML markup for the filtered product list
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
                        echo "<td><img src='" . $row['prod_img'] . "' alt='Product Image' style='width: 100px; height: auto;'></td>";
                        echo "<td><a href='javascript:void(0);' onclick='showEditForm(\"" . $row['prod_id'] . "\", \"" . $row['prod_name'] . "\", \"" . $row['prod_description'] . "\", \"" . $row['prod_frametype'] . "\", \"" . $row['prod_category'] . "\", \"" . $row['prod_price'] . "\", \"" . $row['prod_brand'] . "\", \"" . $row['prod_color'] . "\", \"" . $row['prod_img'] . "\")'>Edit</a></td>";
                        echo "<td><a href='?action=delete&prod_id=" . $row['prod_id'] . "' onclick='return confirm(\"Are you sure you want to delete this product?\")'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    // No matching products found
                    echo "<tr><td colspan='11'>No products found</td></tr>";
                }
            } else {
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
                    echo "<td><img src='" . $row['prod_img'] . "' alt='Product Image' style='width: 100px; height: auto;'></td>";
                    echo "<td><a href='javascript:void(0);' onclick='showEditForm(\"" . $row['prod_id'] . "\", \"" . $row['prod_name'] . "\", \"" . $row['prod_description'] . "\", \"" . $row['prod_frametype'] . "\", \"" . $row['prod_category'] . "\", \"" . $row['prod_price'] . "\", \"" . $row['prod_brand'] . "\", \"" . $row['prod_color'] . "\", \"" . $row['prod_img'] . "\")'>Edit</a></td>";
                    echo "<td><a href='?action=delete&prod_id=" . $row['prod_id'] . "' onclick='return confirm(\"Are you sure you want to delete this product?\")'>Delete</a></td>";
                    echo "</tr>";
                }
            }
            ?>
            </tbody>
        </table>

        <!-- Edit Product Form -->
<div id="editProductPopupContainer" style="display: none;">
    <h2 class="text-center">Edit Product</h2>
    <form action="update-products.php" method="post" id="editProductForm" novalidate enctype="multipart/form-data">
        <!-- Display product details in form fields for editing -->
        <label for="edit_prod_id">Product ID:</label>
        <input type="text" id="edit_prod_id" name="prod_id" required readonly>
        
        <label for="edit_prod_name">Name:</label>
        <input type="text" id="edit_prod_name" name="prod_name" required>
        <div id="nameError" class="error-message"></div>
        
        <label for="edit_prod_description">Description:</label>
        <textarea id="edit_prod_description" name="prod_description" rows="4" required></textarea>
        <div id="descriptionError" class="error-message"></div>
        
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
        
        <label for="edit_prod_category">Category:</label>
        <select id="edit_prod_category" name="prod_category" required>
            <option value="eyeglass">Eyeglass</option>
            <option value="sunglass">Sunglass</option>
            <option value="screen_glass">Screen Glass</option>
        </select>
        <div id="categoryError" class="error-message"></div>
        
        <label for="edit_prod_price">Price:</label>
        <input type="number" id="edit_prod_price" name="prod_price" step="0.01" required>
        <div id="priceError" class="error-message"></div>
        
        <label for="edit_prod_brand">Brand:</label>
        <select id="edit_prod_brand" name="prod_brand" required>
            <option value="RayBan">RayBan</option>
            <option value="John_Jacobs">John Jacobs</option>
            <option value="Lee_Cooper">Lee Cooper</option>
            <option value="Vincent_Chase">Vincent Chase</option>
            <option value="Oakley">Oakley</option>
        </select>
        <div id="brandError" class="error-message"></div>
        
        <label for="edit_prod_color">Color:</label>
        <input type="text" id="edit_prod_color" name="prod_color" required>
        <div id="colorError" class="error-message"></div>
        <br>
        <label for="edit_prod_img">Image:</label>
        <input type="file" id="edit_prod_img" name="prod_img" accept="image/*" onchange="previewImage(event)">
        <!-- Product Image Preview -->
        <img id="edit_prod_img_preview" src="" alt="Product Image Preview" style="max-width: 200px; max-height: 200px;">
        <br><br>
        <button type="submit">Update Product</button><br><br>
        <button onclick="hideEditProductPopup()">Close</button>
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
    <script>
    $(document).ready(function() {
        $("#edit_prod_color").spectrum({
            showPalette: true,
            palette: [
                ["#000000", "#FFFFFF", "#FF0000"],
                ["#00FF00", "#0000FF", "#FFFF00"],
                ["#FFC0CB", "#FFA500", "#800080"],
                ["#F5CBA7", "#AF601A", "#F8F9F9"],
                ["#D2B4DE", "#F7DC6F", "#ABB2B9"],
                ["#E59866", "#F1948A", "#D0ECE7"]
                
                // Add more hex colors to the palette as needed
            ]
        });
    });
</script> 

</body>

</html>
