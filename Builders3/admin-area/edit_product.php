<?php
include('../includes/connect.php');
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$product_id = $_GET['product_id'];
$productQuery = mysqli_query($conn, "SELECT * FROM `products` WHERE product_id='$product_id'");
$product = mysqli_fetch_assoc($productQuery);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['product_name'];
    $image = $_POST['image']; // Handle file upload separately if needed
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['product_price'];

    $updateQuery = "UPDATE `products` SET product_name='$name', product_image1='$image', category_id='$category', product_description='$description', product_price='$price' WHERE product_id='$product_id'";
    
    if (mysqli_query($conn, $updateQuery)) {
        header('Location: listedproduct.php');
        exit();
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Edit Product</title>
</head>
<body>

<!-- Header Section -->
<section id="menu">
    <div class="logo">
        <img src="LOGO-removebg-preview.png" alt="CH Lumber">
        <h2>CH Lumber</h2>
    </div>
    <div class="items">
        <li><i class="fa-solid fa-chart-pie"></i><a href="admin.php">Dashboard</a></li>
        <li><i class="fa-solid fa-chart-pie"></i><a href="insert_product.php">Create Listing</a></li>
        <li><i class="fa-solid fa-chart-pie"></i><a href="listedproduct.php">Listed Products</a></li>
        <li><i class="fa-solid fa-chart-pie"></i><a href="users.php">Users</a></li>
        <li><i class="fa-solid fa-chart-pie"></i><a href="sellers.php">Sellers</a></li>
        <li><i class="fa-solid fa-chart-pie"></i><a href="logout.php">Logout</a></li>
    </div>
</section>

<!-- Main Content Section -->
<section id="interface">
    <h3>Edit Product</h3>
    <form method="POST" class="edit-form">
        <label>Product Name:</label>
        <input type="text" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
        
        <label>Image URL:</label>
        <input type="text" name="image" value="<?php echo htmlspecialchars($product['product_image1']); ?>" required>
        
        <label>Category ID:</label>
        <input type="number" name="category" value="<?php echo htmlspecialchars($product['category_id']); ?>" required>
        
        <label>Description:</label>
        <textarea name="description" required><?php echo htmlspecialchars($product['product_description']); ?></textarea>
        
        <label>Price:</label>
        <input type="number" name="product_price" value="<?php echo htmlspecialchars($product['product_price']); ?>" required>

        <button type="submit" class="update-btn">Update Product</button>
    </form>
</section>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        color: #333;
    }

    #menu {
        background-color: #378370;
        padding: 20px;
        color: white;
    }

    .logo img {
        width: 50px;
        height: auto;
    }

    .items {
        list-style-type: none;
        padding: 0;
    }

    .items li {
        margin: 10px 0;
    }

    .items a {
        color: white;
        text-decoration: none;
        font-size: 16px;
    }

    #interface {
        padding: 20px;
    }

    h3 {
        margin-bottom: 20px;
    }

    .edit-form {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .edit-form label {
        display: block;
        margin: 10px 0 5px;
    }

    .edit-form input, .edit-form textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .update-btn {
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .update-btn:hover {
        background-color: #45a049;
    }
</style>

</body>
</html>
