<?php
include('../includes/connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $category = $_POST['category'];
    $product_price = $_POST['product_price'];
    $product_image = $_FILES['product_image']['name'];
    $target_dir = "./product_images2/";
    $target_file = $target_dir . basename($product_image);

    if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file)) {
        $updateQuery = "
            UPDATE products 
            SET product_name='$product_name', product_description='$product_description', category_id=(SELECT category_id FROM categories WHERE category_title='$category'), product_price='$product_price', product_image1='$product_image' 
            WHERE product_id='$product_id'
        ";
    } else {
        $updateQuery = "
            UPDATE products 
            SET product_name='$product_name', product_description='$product_description', category_id=(SELECT category_id FROM categories WHERE category_title='$category'), product_price='$product_price' 
            WHERE product_id='$product_id'
        ";
    }

    if (mysqli_query($conn, $updateQuery)) {
        header("Location: product.php?message=Product updated successfully.");
        exit();
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
}
?>
