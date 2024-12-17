<?php
include('../includes/connect.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];

    // Prepare the delete query
    $deleteQuery = "DELETE FROM `user` WHERE id='$user_id'";

    // Execute the query
    if (mysqli_query($conn, $deleteQuery)) {
        header('Location: users.php'); // Redirect to the users management page
        exit();
    } else {
        echo "<div style='color: #dc3545;'>Error deleting user: " . mysqli_error($conn) . "</div>";
    }
} else {
    // Redirect if accessed without POST request
    header('Location: users.php');
    exit();
}
?>
