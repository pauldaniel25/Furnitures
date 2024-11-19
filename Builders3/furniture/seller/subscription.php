<?php
session_start();
include('../includes/connect.php');

// Check if the session email variable is set
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $seller_id = $_SESSION['seller_id']; // Assuming seller_id is stored in the session

    // Fetch user details
    $query = mysqli_query($conn, "SELECT * FROM `seller` WHERE `email`='$email'");
    
    if ($query && mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_array($query);
        $fullName = $row['firstName'] . ' ' . $row['lastName'];

        // Fetch products for the specific seller
        $productQuery = mysqli_query($conn, "SELECT p.product_id, p.product_name, p.product_description, p.product_price, p.product_image1, c.category_title 
                                              FROM products p 
                                              JOIN categories c ON p.category_id = c.category_id 
                                              WHERE p.seller_id='$seller_id'");
    } else {
        $fullName = 'User not found';
        $productQuery = [];
    }
} else {
    $fullName = 'Guest'; // Default if not logged in
    $productQuery = [];
}


$isSubscribed = !is_null($row['subscription_id']) && 
strtotime($row['start_date']) <= time() && 
strtotime($row['end_date']) >= time();
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
    <li><i class="fa-solid fa-chart-pie"></i><a href="seller.php">Dashboard</a></li>
        <?php if ($isSubscribed): ?>
            <li><i class="fa-solid fa-chart-pie"></i><a href="insert_product.php">Create Listing</a></li>
        <?php else: ?>
            <li><i class="fa-solid fa-chart-pie"></i><a href="#" style="color:gray; cursor:not-allowed;" title="You must subscribe to add a product">Create Listing (Unavailable)</a></li>
        <?php endif; ?>
        <li><i class="fa-solid fa-chart-pie"></i><a href="listedproduct.php">Listed Products</a></li>
        <li><i class="fa-solid fa-chart-pie"></i><a href="logout.php">Logout</a></li>
    </div>
    </div>
</section>

<!-- Main Content Section -->
<section id="interface">
    <h3 class="i-name"><?php echo $fullName; ?></h3> <!-- Display user name -->
    
    <div class="board">
        <h3>Your Products</h3>
        <table width="100%">
            <thead>
                <tr>
                    <td>Product Name</td>
                    <td>Description</td>
                    <td>Category</td>
                    <td>Image</td>
                    <td>Price</td>
                    <td>Actions</td> <!-- Added Actions column -->
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
                                <td><img src='./product_images copy/{$product['product_image1']}' alt='Product Image' width='100'></td>
                                <td>{$product['product_price']}</td>
                                <td>
                                    <a href='edit_product.php?product_id={$product['product_id']}' class='edit-btn'>Edit</a>
                                    <a href='delete_product.php?product_id={$product['product_id']}' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this product?\");'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No products found.</td></tr>"; // Updated colspan to 6
                }
                ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Footer Section -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.49.0/apexcharts.min.js"></script>
</body>
</html>

