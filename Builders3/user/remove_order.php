<?php
// filepath: /c:/xampp/htdocs/git/Furnitures/Builders3/user/remove_order.php
header('Content-Type: application/json');
require_once 'classes.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['order_id']) && is_numeric($data['order_id'])) {
        $order = new Order();
        if ($order->removeOrder((int)$data['order_id'])) {
            echo json_encode(['success' => true, 'message' => 'Order removed successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to remove order.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid order ID.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}