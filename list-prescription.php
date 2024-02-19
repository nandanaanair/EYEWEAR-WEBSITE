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

    // Construct the SQL query to search for prescriptions
    $sql = "SELECT * FROM prescription WHERE order_id LIKE '%$searchQuery%' OR l_sph LIKE '%$searchQuery%' OR r_sph LIKE '%$searchQuery%' OR l_cyl LIKE '%$searchQuery%' OR r_cyl LIKE '%$searchQuery%' OR l_axis LIKE '%$searchQuery%' OR r_axis LIKE '%$searchQuery%' OR l_addn LIKE '%$searchQuery%' OR r_addn LIKE '%$searchQuery%'";

    // Execute the query
    $result = $conn->query($sql);
}

// Retrieve all prescription details from the database
$sql_all_prescriptions = "SELECT * FROM prescription";
$result_all_prescriptions = $conn->query($sql_all_prescriptions);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/list-prescription.css">
    <script src="./js/list-prescription.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha384-4mOC5PJSq1Yq3Jasv4G1kAqQ6owlsOfQ1uHRzBy6ZYgdT1pef0nGhHPfD5QZbb3J" crossorigin="anonymous">
    <title>Prescription Details</title>
    <!-- Include any necessary CSS styles here -->
</head>

<body>
    <!-- Add this input field for the search bar above the table -->
    <div class="container mt-3">
        <form>
            <input type="text" id="searchQuery" class="search-input" placeholder="Search prescriptions...">
        </form>
    </div>
    <!-- Display prescription details in a table -->
    <div class="container mt-5">
        <h2 class="text-center">Prescription Details</h2>
        <br>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Prescription ID</th>
                    <th>Order ID</th>
                    <th>Left Sphere</th>
                    <th>Right Sphere</th>
                    <th>Left Cylinder</th>
                    <th>Right Cylinder</th>
                    <th>Left Axis</th>
                    <th>Right Axis</th>
                    <th>Left Addition</th>
                    <th>Right Addition</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if the search query is set
                if (isset($_GET['searchQuery']) && !empty($_GET['searchQuery'])) {
                    // Check if there are matching prescriptions
                    if ($result && $result->num_rows > 0) {
                        // Output HTML markup for the filtered prescription list
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['prescription_id'] . "</td>";
                            echo "<td>" . $row['order_id'] . "</td>";
                            echo "<td>" . $row['l_sph'] . "</td>";
                            echo "<td>" . $row['r_sph'] . "</td>";
                            echo "<td>" . $row['l_cyl'] . "</td>";
                            echo "<td>" . $row['r_cyl'] . "</td>";
                            echo "<td>" . $row['l_axis'] . "</td>";
                            echo "<td>" . $row['r_axis'] . "</td>";
                            echo "<td>" . $row['l_addn'] . "</td>";
                            echo "<td>" . $row['r_addn'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        // No matching prescriptions found
                        echo "<tr><td colspan='10'>No prescriptions found</td></tr>";
                    }
                } else {
                    // Output HTML markup for all prescriptions
                    while ($row = $result_all_prescriptions->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['prescription_id'] . "</td>";
                        echo "<td>" . $row['order_id'] . "</td>";
                        echo "<td>" . $row['l_sph'] . "</td>";
                        echo "<td>" . $row['r_sph'] . "</td>";
                        echo "<td>" . $row['l_cyl'] . "</td>";
                        echo "<td>" . $row['r_cyl'] . "</td>";
                        echo "<td>" . $row['l_axis'] . "</td>";
                        echo "<td>" . $row['r_axis'] . "</td>";
                        echo "<td>" . $row['l_addn'] . "</td>";
                        echo "<td>" . $row['r_addn'] . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
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

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchQuery');
        const rows = document.querySelectorAll('tbody tr');

        searchInput.addEventListener('input', function () {
            const filter = searchInput.value.trim().toLowerCase();

            rows.forEach(function (row) {
                const cells = row.querySelectorAll('td');
                let found = false;

                cells.forEach(function (cell) {
                    const text = cell.textContent.trim().toLowerCase();
                    if (text.includes(filter)) {
                        found = true;
                    }
                });

                if (found) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>

</body>

</html>

<?php
// Close database connection
$conn->close();
?>
