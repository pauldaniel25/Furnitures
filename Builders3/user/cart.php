<?php
require_once 'classes.php';
$Userobj = new User();
$productobj = new Product();

$keyword = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input from the search form
    $keyword = htmlentities($_POST['keyword']);
}

$array = $productobj->showproducts($keyword);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="cart.style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    <div class="grid-container">
        <div class="grid-item-title" id="prod"><h5>Product</h5></div>
        <div class="grid-item-title"></div>
        <div class="grid-item-title"><h5>Unit Price</h5></div>
        <div class="grid-item-title"><h5>Quantity</h5></div>
        <div class="grid-item-title"><h5>Total Price</h5></div>
        <div class="grid-item-title"><h5>Actions</h5></div>
    </div>
    <main>
    <?php foreach ($array as $arr) { ?>
      <div class="grid-container">
            <div class="grid-item" id="prodimg">
                <input type="checkbox" class ="checkbox">
                <img src="seller/furniture/image_asset/<?= $arr['Category'] ?>/<?= $arr['product_image1'] ?>" class="product-image" alt="Product Image">
            </div>
            <div class="grid-item"> <?= $arr['product_name']?></div>
            <div class="grid-item">$<?= htmlspecialchars($arr['product_price']) ?></div>
            <div class="grid-item">5</div> <!-- Example quantity -->
            <div class="grid-item">$500</div>
            <div class="grid-item-actions">
    <button class="btn add-to-cart">Remove</button>
    <button class="btn view-more">View</button>
</div>


            </div>

            </div>
<hr>
            <?php } ?>  
    </main>
  
</body>

</html> 