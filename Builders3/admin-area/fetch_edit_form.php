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
        echo "<form action='update_product.php' method='POST' enctype='multipart/form-data'>
                <input type='hidden' name='product_id' value='{$product_id}'>
                <label for='product_name'>Product Name:</label>
                <input type='text' id='product_name' name='product_name' value='{$product['product_name']}' required>
                
                <label for='product_description'>Description:</label>
                <textarea id='product_description' name='product_description' required>{$product['product_description']}</textarea>
                
                <label for='category'>Category:</label>
                <select id='category' name='category' required>
                    <option value='{$product['category_title']}' selected>{$product['category_title']}</option>
                    <!-- Add other categories here -->
                </select>
                
                <label for='seller'>Seller:</label>
                <input type='text' id='seller' name='seller' value='{$product['firstName']} {$product['lastName']}' readonly>
                
                <label for='product_price'>Price:</label>
                <input type='number' id='product_price' name='product_price' value='{$product['product_price']}' required>
                
                <label for='product_image'>Image:</label>
                <input type='file' id='product_image' name='product_image'>
                <img src='./product_images2/{$product['product_image1']}' alt='Product Image' width='100'>
                
                <button type='submit'>Update Product</button>
              </form>";
    } else {
        echo "<p>Product not found.</p>";
    }
} else {
    echo "<p>Invalid product ID.</p>";
}
?>
