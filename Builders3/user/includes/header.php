<?php
// Include the necessary classes
require_once 'classes.php';
$Userobj = new User();
$productobj = new Product();

// Initialize the keyword variable
$keyword = '';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['keyword'])) {
    // Sanitize the input to prevent XSS attacks
    $keyword = htmlentities($_POST['keyword']);
}

// Fetch the products based on the keyword search
$array = $productobj->showproducts($keyword);
?>
<header class="header-container">
    <div class="logo">
        <img src="images/LOGO.png" alt="Logo">
    </div>
    <nav class="navbar">
        <ul>
            <li><a href="Dashboard.php">Home</a></li>
            <li><a href="product.php">Products</a></li>
            <li><a href="#">Orders</a></li>
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