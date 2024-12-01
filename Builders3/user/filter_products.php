<?php
session_start();
require_once 'classes.php';

$productobj = new Product();

// Default: show all products
$keyword = '';
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';

// Fetch products based on the selected category
$array = $productobj->showproducts($keyword, $category_id);

if (empty($array)) {
    echo '<p>No products found in this category.</p>';
} else {
    foreach ($array as $arr) {
        ?>
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
                    <button type="button" class="btn add-cart-btn btn-custom" data-id="<?= $arr['product_id'] ?>" id="add-to-cart">Add to Cart</button>
                    <a href="view.php?id=<?= $arr['product_id']?>" class="btn btn-custom">View More</a>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
