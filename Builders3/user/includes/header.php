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

<header>
  <div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg navbar-custom">
      <div class="container-fluid">
        <img src="images/LOGO.png" alt="Logo" class="logo">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <nav>
            <ul class="navbar-nav ms-auto">
              <li><a class="nav-link" href="Dashboard.php" aria-label="Go to Home">Home</a></li>
              <li><a class="nav-link" href="product.php" aria-label="Go to Products">Products</a></li>
              <li><a class="nav-link" href="#" aria-label="Go to Builders">Builders</a></li>
              <li class="nav-item">
                <a class="nav-link" href="addproduct.php" aria-label="View Cart"><i class="fa-solid fa-cart-shopping"></i><sup>1</sup></a>
              </li>
            </ul>
          </nav>
          <form class="Search d-flex" method="POST" role="search" aria-label="Product Search Form">
            <input class="Sbar form-control me-2" type="search" name="keyword" placeholder="Search" value="<?= htmlspecialchars($keyword) ?>" aria-label="Search products" />
            <button class="bt btn btn-outline-success" type="submit" aria-label="Submit search">Search</button>
          </form>
        </div>
      </div>
    </nav>
  </div>
</header>
