<?php
include '../classes.php';

$order = new Order;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['order_id'])) {
        $order_id = (int) $_POST['order_id'];
        
        if ($order->cancelOrder($order_id)) {
            echo json_encode(['success' => true, 'message' => 'Order cancelled']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Cancellation failed']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Missing order ID']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method Not Allowed']);
}