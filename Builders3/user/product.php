<?php
session_start();
require_once 'classes.php';

$categoryobj = new Category();
$categories = $categoryobj->getCategories();

$productobj = new Product();

// Initialize the keyword and category variables
$keyword = '';
$category_id = '';

// Check if a keyword is provided from the search
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['keyword'])) {
    $keyword = htmlentities($_POST['keyword']);
}

// Fetch category filter from GET request
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
}

// Fetch the products based on both keyword and category filter
$array = $productobj->showproducts($keyword, $category_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="../vendor/bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendor/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../vendor/datatable-2.1.8/datatables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="productstyle.css">
    <link rel="stylesheet" href="includes/header.css">
</head>

<body>
    <!-- Header -->
    <?php require_once 'includes/header.php'; ?>


    <!-- Modal Container -->
    <div class="modal-container"></div>

    <!-- Category Navigation -->
    <nav class="category-links">
        <ul class="d-flex justify-content-around align-items-center">
            <li class="nav-item"><a class="nav-link <?= !$category_id ? 'active' : '' ?>" href="product.php">All Categories</a></li>
            <?php foreach ($categories as $category) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= ($category_id == $category['category_id']) ? 'active' : '' ?>" 
                       href="product.php?category_id=<?= $category['category_id'] ?>"><?= $category['category_title'] ?></a>
                </li>
            <?php } ?>
        </ul>
    </nav>

    <!-- Product Listing -->
    <main class="product-container" id="product-list">
        <?php if (empty($array)) { ?>
            <p>No products found.</p>
        <?php } else { ?>
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
                            <button type="button" class="btn add-cart-btn btn-custom" data-id="<?= $arr['product_id'] ?>" id="add-to-cart">Add to Cart</button>
                            <a href="view.php?id=<?= $arr['product_id']?>" class="btn btn-custom">View More</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // When a category is clicked, filter products
        $('a[data-category-id]').click(function() {
            var categoryId = $(this).data('category-id');

            // AJAX request to filter products
            $.ajax({
                url: 'filter_products.php',
                method: 'GET',
                data: { category_id: categoryId },
                success: function(response) {
                    // Replace the current product list with the filtered result
                    $('#product-list').html(response);
                }
            });
        });
    });
    </script>
    <!-- Footer -->
    <?php require_once 'includes/footer.php'; ?>

    <script src="ajax.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
