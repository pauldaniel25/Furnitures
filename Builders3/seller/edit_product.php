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

        // Update product in database
        $updateQuery = "UPDATE products SET product_name='$product_name', product_description='$product_description', product_price='$product_price' WHERE product_id='$product_id'";
        mysqli_query($conn, $updateQuery);
        
        // Redirect after update
        header("Location: seller.php");
        exit();
    }
} else {
    header("Location: seller.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css"> <!-- Link to your main stylesheet -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }
        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background: #28a745;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        input[type="submit"]:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Product</h2>
        <form method="post">
            <label>Product Name:</label>
            <input type="text" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
            
            <label>Description:</label>
            <textarea name="product_description" required><?php echo htmlspecialchars($product['product_description']); ?></textarea>
            
            <label>Price:</label>
            <input type="number" name="product_price" value="<?php echo htmlspecialchars($product['product_price']); ?>" required>
            
            <input type="submit" value="Update Product">
        </form>
    </div>
</body>
</html>
