<?php
include('../includes/connect.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seller_id = $_POST['seller_id'];

    // Prepare the delete query
    $deleteQuery = "DELETE FROM `seller` WHERE id='$seller_id'";

    // Execute the query
    if (mysqli_query($conn, $deleteQuery)) {
        header('Location: sellers.php'); // Redirect to the sellers management page
        exit();
    } else {
        echo "<div style='color: #dc3545;'>Error deleting seller: " . mysqli_error($conn) . "</div>";
    }
} else {
    // Redirect if accessed without POST request
    header('Location: sellers.php');
    exit();
}
?>
