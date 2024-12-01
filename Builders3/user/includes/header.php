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
            <li><a href="Dashboard.php">Home</a></li>
            <li><a href="product.php">Products</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="cart2.php"><i class="fa-solid fa-cart-shopping"></i><sup>1</sup></a></li>
            <!-- search -->
            <form class="search-form" method="POST" role="search">
                <input class="search-input" type="search" name="keyword" placeholder="Search">
                <button class="search-button" type="submit">Search</button>
            </form>
        </ul>
    </nav>
    <li class="logout"><a href="#" onclick="confirmLogout()"><i class="fa-solid fa-right-from-bracket"></i></a></li>
</header>

<script>
function confirmLogout() {
  if (confirm("Are you sure you want to log out?")) {
    window.location.href = 'logout.php';
  }
}
</script>
