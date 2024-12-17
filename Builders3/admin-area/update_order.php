
<?php
include('../includes/connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'];

    $updateQuery = "
        UPDATE user_order_details
        SET quantity = '$quantity', status = '$status'
        WHERE id = '$order_id'
    ";

    if (mysqli_query($conn, $updateQuery)) {
        echo "Order updated successfully.";
    } else {
        echo "Error updating order: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>