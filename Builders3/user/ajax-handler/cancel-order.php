<?php
header('Content-Type: application/json'); // Explicit JSON header

require_once '../classes.php';

$order = new Order();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents('php://input'), true);
  
  if ($data === null) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON data']);
    exit;
  }
  
  $orderId = $data['orderId'];

  if ($order->cancelOrder($orderId)) {
    echo json_encode(['success' => true, 'message' => 'Order canceled successfully']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Error canceling order']);
  }
} else {
  echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>