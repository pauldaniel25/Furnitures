<?php
include('../includes/connect.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $user_order_id = mysqli_real_escape_string($conn, $_POST['user_order_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Update the order status in the database
    $query = "UPDATE user_order_details SET status = '$status' WHERE id = '$user_order_id'";
    if (mysqli_query($conn, $query)) {
        // Redirect back to the seller dashboard or orders page
        header("Location: seller.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
