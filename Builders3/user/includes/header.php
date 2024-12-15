<?php
// Include the necessary classes
require_once 'classes.php';
$Userobj = new User();
$productobj = new Product();

// Initialize the keyword and category variables
$keyword = '';
$category_id = '';  // Using category_id instead of just category for consistency

// Check if the form was submitted for keyword search
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['keyword'])) {
    $keyword = htmlentities($_POST['keyword']);
}

// Check if category ID is set in the GET request (for category filtering)
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
}

// Fetch the products based on the keyword and category filter
$array = $productobj->showproducts($keyword, $category_id);
?>

<header class="header-container">
    <div class="logo">
        <img src="images/LOGO.png" alt="Logo">
    </div>
    <nav class="navbar">
        <ul>
            <div class="links">
            <li><a href="Dashboard.php">Home</a></li>
            <li><a href="product.php">Products</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="cart2.php"><i class="fa-solid fa-cart-shopping"></i><sup></sup></a></li>
            </div>
            <form class="search-form" method="POST" role="search">
                <input class="search-input" type="search" name="keyword" placeholder="Search">
                <button class="search-button" type="submit">Search</button>
            </form>
        </ul>
    </nav>
    <div class="burger-menu">
    <input type="checkbox" id="burger-checkbox">
    <label for="burger-checkbox" class="burger-icon">
        <span></span>
        <span></span>
        <span></span>
    </label>
    <ul class="burger-links">
        <li><a href="profile.php">Edit Profile</a></li>
        <li><a href="order_history.php">Order History</a></li>
        <li><a href="#" onclick="confirmLogout()">Logout</a></li>
    </ul>
</div>
</header>

<script>
function confirmLogout() {
  if (confirm("Are you sure you want to log out?")) {
    window.location.href = 'logout.php';
  }
}
</script>