<?php
session_start();
include('../includes/connect.php');

// Check if the session email variable is set
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $admin_id = $_SESSION['admin_id'];

    // Fetch admin details from the database
    $query = mysqli_query($conn, "SELECT * FROM `admin` WHERE email='$email'");

    if ($query && mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_array($query);
        $fullName = $row['firstName'] . ' ' . $row['lastName'];

        // Fetch all products for all sellers
        $productQuery = mysqli_query($conn, "
            SELECT p.product_id, p.product_name, p.product_description, p.product_price, p.product_image1, 
                   c.category_title, s.firstName, s.lastName 
            FROM products p 
            JOIN categories c ON p.category_id = c.category_id 
            JOIN seller s ON p.seller_id = s.id
        ");
    } else {
        $fullName = 'Admin not found';
        $productQuery = [];
    }
} else {
    $fullName = 'Guest'; // Default if not logged in
    $productQuery = [];
}

// Handle product deletion
if (isset($_GET['delete_product_id'])) {
    $product_id = $_GET['delete_product_id'];
    $deleteQuery = "DELETE FROM products WHERE product_id='$product_id'";

    if (mysqli_query($conn, $deleteQuery)) {
        header("Location: listedproduct.php?message=Product deleted successfully.");
        exit();
    } else {
        $message = "Error deleting product: " . mysqli_error($conn);
    }
}

// Fetching the message if exists
$message = isset($_GET['message']) ? $_GET['message'] : '';
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <title>CH Lumberyard Admin</title>
</head>
<body>

<!-- Header Section -->
<section id="menu">
    <div class="logo">
        <img src="LOGO-removebg-preview.png" alt="CH Lumber">
        <h2>CH Lumber</h2>
    </div>
    <div class="items">
        <li><i class="fa-solid fa-house"></i></i><a href="admin.php">Dashboard</a></li>
        <li><i class="fa-solid fa-cart-plus"></i><a href="insert_product.php">Products</a></li>
        <li><i class="fa-solid fa-cart-shopping"></i><a href="product.php">Listed Products</a></li>
        <li><i class="fa-regular fa-user"></i><a href="user.php">Users</a></li>
        <li><i class="fa-solid fa-user-secret"></i><a href="seller.php">Sellers</a></li>
        <li><i class="fa-solid fa-arrow-right-from-bracket"></i><a href="logout.php">Logout</a></li>
    </div>
</section>

<!-- Main Content Section -->
<section id="interface">
    <h3 class="i-name"><?php echo $fullName; ?></h3>
    
    <?php if ($message): ?>
        <div class="alert"><?php echo $message; ?></div>
    <?php endif; ?>

    <div class="board">
        <h3>All Listed Products</h3>
        <table width="100%">
            <thead>
                <tr>
                    <td>Product Name</td>
                    <td>Description</td>
                    <td>Category</td>
                    <td>Seller</td>
                    <td>Image</td>
                    <td>Price</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                    while ($product = mysqli_fetch_assoc($productQuery)) {
                        echo "<tr>
                                <td>{$product['product_name']}</td>
                                <td>{$product['product_description']}</td>
                                <td>{$product['category_title']}</td>
                                <td>{$product['firstName']} {$product['lastName']}</td>
                                <td><img src='./product_images2/{$product['product_image1']}' alt='Product Image' width='100'></td>
                                <td>{$product['product_price']}</td>
                                <td>
                                    <a href='edit_product.php?product_id={$product['product_id']}' class='edit-btn'>Edit</a>
                                    <a href='listedproduct.php?delete_product_id={$product['product_id']}' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this product?\");'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No products found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</section>

<style>
    .alert {
        margin: 20px 0;
        padding: 10px;
        background-color: #dff0d8;
        color: #3c763d;
        border: 1px solid #d6e9c6;
        border-radius: 5px;
    }
</style>

</body>
</html>
