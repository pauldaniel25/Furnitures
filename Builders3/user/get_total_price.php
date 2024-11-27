<?php
require_once 'classes.php';

session_start();
$user_id = $_SESSION['user_id'];

$cart = new Cart();
$totalPrice = $cart->getTotalPrice($user_id);
echo number_format($totalPrice, 2);
?>