<?php
include('../includes/connect.php');
session_start();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the submitted data
    $order_id = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
    $new_status = isset($_POST['status']) ? mysqli_real_escape_string($conn, $_POST['status']) : '';

    // Ensure we have a valid order ID and status
    if ($order_id && in_array($new_status, ['pending', 'completed', 'canceled'])) {
        // Update the order status in the database
        $updateQuery = "UPDATE user_order_details SET status = '$new_status' WHERE user_order_id = $order_id";

        if (mysqli_query($conn, $updateQuery)) {
            // If update is successful, redirect back to the dashboard or orders page
            header('Location: seller.php?status=success');
        } else {
            // If there's an error, set the error message and redirect
            header('Location: seller.php?status=error');
        }
    } else {
        // Invalid input, redirect with an error message
        header('Location: seller.php?status=invalid');
    }
} else {
    // Redirect to the dashboard if no POST request
    header('Location: seller.php');
}
?>
