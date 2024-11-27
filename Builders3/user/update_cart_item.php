<?php
require_once('classes.php');

$cart = new Cart();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_item_id = $_POST['cart_item_id'];
    $quantity = $_POST['quantity'];
    try {
        if ($cart->updateQuantity($cart_item_id, $quantity)) {
            echo 'success';
        } else {
            echo 'error';
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>