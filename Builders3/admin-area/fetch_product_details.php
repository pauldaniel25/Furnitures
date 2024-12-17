<?php
include('../includes/connect.php');

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $query = mysqli_query($conn, "
        SELECT p.product_name, p.product_description, p.product_price, p.product_image1, 
               c.category_title, s.firstName, s.lastName 
        FROM products p 
        JOIN categories c ON p.category_id = c.category_id 
        JOIN seller s ON p.seller_id = s.id
        WHERE p.product_id = '$product_id'
    ");

    if ($query && mysqli_num_rows($query) > 0) {
        $product = mysqli_fetch_assoc($query);
        echo "<p><strong>Product Name:</strong> {$product['product_name']}</p>";
        echo "<p><strong>Description:</strong> {$product['product_description']}</p>";
        echo "<p><strong>Category:</strong> {$product['category_title']}</p>";
        echo "<p><strong>Seller:</strong> {$product['firstName']} {$product['lastName']}</p>";
        echo "<p><strong>Price:</strong> {$product['product_price']}</p>";
        echo "<img src='./product_images2/{$product['product_image1']}' alt='Product Image' width='200'>";
    } else {
        echo "<p>Product not found.</p>";
    }
} else {
    echo "<p>Invalid product ID.</p>";
}
?>
