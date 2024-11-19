<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="productstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<!-- header here -->
<?php
require_once 'includes/header.php';
?>
    <nav class="category-links">
  <ul class="d-flex justify-content-around align-items-center">
    <li class="nav-item"><a class="nav-link" href="#">All Categories</a></li>
    <li class="nav-item"><a class="nav-link" href="#">Living Room</a></li>
    <li class="nav-item"><a class="nav-link" href="#">Bedroom</a></li>
    <li class="nav-item"><a class="nav-link" href="#">Bathroom</a></li>
    <li class="nav-item"><a class="nav-link" href="#">Kitchen</a></li>
    <li class="nav-item"><a class="nav-link" href="#">Decorations</a></li>
  </ul>
</nav>

<main class="product-container">
  <?php foreach ($array as $arr) { ?>
    <div class="product-item">
      <div class="image-section">
        <img src="../seller/product_images2/<?= $arr['product_image1']?>" alt="Product Image">
      </div>
      <div class="details-section">
        <h2 class="product-name"><?= htmlspecialchars($arr['product_name']) ?></h2>
        <p class="product-price">$<?= htmlspecialchars($arr['product_price']) ?></p>
        <p class="product-category">Category: <?= htmlspecialchars($arr['Category']) ?></p>
        <p class="product-quantity">Quantity: 5</p>
        <p class="product-seller">Seller: <?= htmlspecialchars($arr['seller_name']) ?></p>
        <div class="button-group">
          <button class="btn btn-custom add-to-cart">Add to Cart</button>
          <button class="btn btn-custom view-more">View More</button>
        </div>
      </div>
    </div>
  <?php } ?>
</main>
</body>
</html>
