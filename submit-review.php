<?php
session_start();
include "connect.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from form
    $firstName = $_POST['firstName']; // Retrieved from hidden field
    $prod_id = $_POST['prod_id']; // Retrieved from hidden field
    $review_content = $_POST['review_content'];
    $review_rating = $_POST['review_rating'];

    // Prepare SQL statement to insert review into database
    $sql_insert_review = "INSERT INTO reviews (cust_fname, prod_id, rev_comment, rev_rating) VALUES ('$firstName', '$prod_id', '$review_content', '$review_rating')";

    // Execute SQL statement
    if ($conn->query($sql_insert_review) === TRUE) {
        // echo "Review submitted successfully";
        echo "<script> window.location.href='product-details.php'</script>";
    } else {
        echo "Error: " . $sql_insert_review . "<br>" . $conn->error;
    }
} else {
    echo "Form submission error";
}

// Close the database connection
$conn->close();
?>
