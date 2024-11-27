<?php
require_once('classes.php');

$cart = new Cart();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_item_id = $_POST['cart_item_id'];
    if ($cart->removeCartItem($cart_item_id)) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>