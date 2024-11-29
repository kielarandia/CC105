<?php 
ob_start(); 
require 'config.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize user input to prevent XSS and SQL injection
    $view = mysqli_real_escape_string($con, $_POST['view']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $comments = mysqli_real_escape_string($con, $_POST['comments']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $num = mysqli_real_escape_string($con, $_POST['num']);

    // Prepare the SQL query to prevent SQL injection
    $query = "INSERT INTO `poll`(`id`, `name`, `email`, `phone`, `feedback`, `suggestions`) VALUES (NULL, ?, ?, ?, ?, ?)";

    // Initialize prepared statement
    if ($stmt = mysqli_prepare($con, $query)) {
        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, 'sssss', $name, $email, $num, $view, $comments);
        
        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            // Success message
            echo '<script>alert("Thank You..! Your Feedback is Valuable to Us"); location.replace(document.referrer);</script>';
        } else {
            // Error message if query fails
            echo '<script>alert("There was an error submitting your feedback. Please try again later."); location.replace(document.referrer);</script>';
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Error message if query preparation fails
        echo '<script>alert("There was an error with the query. Please try again later."); location.replace(document.referrer);</script>';
    }
}

ob_end_flush();
?>
