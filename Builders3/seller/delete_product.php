<?php
session_start();
include('../includes/connect.php');

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    
    // Delete product from database
    $deleteQuery = "DELETE FROM products WHERE product_id='$product_id'";
    mysqli_query($conn, $deleteQuery);
    
    // Redirect after deletion
    header("Location: seller.php");
} else {
    header("Location: seller.php");
}
