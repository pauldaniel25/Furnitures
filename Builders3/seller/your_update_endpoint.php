<?php
include('../includes/connect.php'); // Include your database connection code

header('Content-Type: application/json'); // Set the Content-Type header

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['order_id'], $data['status'])) {
        $order_id = mysqli_real_escape_string($conn, $data['order_id']);
        $status = mysqli_real_escape_string($conn, $data['status']);
        
        $query = "UPDATE orders SET status='$status' WHERE order_id='$order_id'";
        if (mysqli_query($conn, $query)) {
            echo json_encode(["success" => true, "message" => "Order status updated successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Database error: " . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid request parameters."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>