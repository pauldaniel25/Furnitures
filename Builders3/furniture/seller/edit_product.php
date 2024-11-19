<?php
session_start();
include('../includes/connect.php');

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    
    // Fetch the product details
    $query = mysqli_query($conn, "SELECT * FROM products WHERE product_id='$product_id'");
    $product = mysqli_fetch_assoc($query);
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get updated values from form
        $product_name = $_POST['product_name'];
        $product_description = $_POST['product_description'];
        $product_price = $_POST['product_price'];
        // You can add more fields as needed

        // Update product in database
        $updateQuery = "UPDATE products SET product_name='$product_name', product_description='$product_description', product_price='$product_price' WHERE product_id='$product_id'";
        mysqli_query($conn, $updateQuery);
        
        // Redirect after update
        header("Location: seller.php");
    }
} else {
    header("Location: seller.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>
    <form method="post">
        <label>Product Name:</label>
        <input type="text" name="product_name" value="<?php echo $product['product_name']; ?>" required>
        <br>
        <label>Description:</label>
        <textarea name="product_description" required><?php echo $product['product_description']; ?></textarea>
        <br>
        <label>Price:</label>
        <input type="number" name="product_price" value="<?php echo $product['product_price']; ?>" required>
        <br>
        <input type="submit" value="Update Product">
    </form>
</body>
</html>
