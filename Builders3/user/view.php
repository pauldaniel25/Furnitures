<?php
ob_start(); 
require_once('function.php');
require_once('classes.php');

$prodobj = new Product();

$id = $product_name = $product_description 
= $product_keywords = $category_id = $product_image1 = 
$product_image2 = $product_image3 
= $product_price = $status = $seller_id
 = $seller_name = $category_name = '';



if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $record = $prodobj->fetchRecord($id);
        if (!empty($record)) {
            $product_name = htmlspecialchars($record['product_name']);
            $product_description = htmlspecialchars($record['product_description']);
            $product_keywords = htmlspecialchars($record['product_keywords']);
            $category_id = htmlspecialchars($record['category_id']);
            $category_name = htmlspecialchars($record['Category']); 
            $product_image1 = htmlspecialchars($record['product_image1']);
            $product_price = htmlspecialchars($record['product_price']);
            $status = htmlspecialchars($record['status']);
            $seller_id = htmlspecialchars($record['seller_id']);
            $product_image2 = htmlspecialchars($record['product_image2']);
            $product_image3 = htmlspecialchars($record['product_image3']);
            $seller_name = htmlspecialchars($record['seller_name']);
        } else {
            echo 'No product found';
            exit;
        }
    } else {
        echo 'No product found';
        exit;
    }

    $array = $prodobj->recommendations($category_id, $id); 
}

ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product View</title>
    <link rel="stylesheet" href="../vendor/bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendor//bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../vendor/datatable-2.1.8/datatables.min.css" >
    <link rel="stylesheet" href="Viewstyle.css"> 
    <link rel="stylesheet" href="includes/header.css"> 
    
</head>
<body>
<?php require_once 'includes/header.php'; ?>
    <!-- header here -->
    <?php
// require_once 'includes/header.php';
?>
<div class="modal-container"></div>

<div class="product-container">
    <div class="image-gallery">
        <div class="main-image">
            <img src="../seller/product_images2/<?= htmlspecialchars($product_image1) ?>" alt="<?= $product_name ?> " class="img-fluid" >
        </div>
        <div class="thumbnail-images">
        <?php if(!empty($product_image2) && !empty($product_image3)){ ?>
            <img src="../seller/product_images2/<?= htmlspecialchars($product_image2) ?>" alt="<?= $product_name ?>" class="img-fluid" >
            <img src="../seller/product_images2/<?= htmlspecialchars($product_image3) ?>" alt="<?= $product_name ?>"class="img-fluid" > 
        <?php }elseif(!empty($product_image2)){
    ?>
      <img src="../seller/product_images2/<?= htmlspecialchars($product_image2) ?>" alt="<?= $product_name ?>" class="img-fluid" >
        <?php }elseif(!empty($product_image3)){
            ?>
            <img src="../seller/product_images2/<?= htmlspecialchars($product_image3) ?>" alt="<?= $product_name ?>" class="img-fluid" >
            <?php }else
         ?>
        </div>
    </div>

    <div class="product-info">
        <h1 class="product-name"><?= $product_name ?></h1>
        <p class="product-description"><?= $product_description ?></p>
        <p class="product-keywords"><strong>Keywords:</strong> <?= $product_keywords ?></p>
        <p class="category"><strong>Category:</strong> <?= htmlspecialchars($category_name) ?></p>
        <p class="price"><strong>Price:</strong> $<?= number_format($product_price, 2) ?></p>
        <p class="status"><strong>Status:</strong> <?= ucfirst($status) ?></p>
        <p class="seller-name"><strong>Seller:</strong> <?= $seller_name ?></p>

        <div class="buttons">
            <button class="btn cancel-btn" onclick="window.location.href='Dashboard.php'">Cancel</button>
                <input type="hidden" name="product_id" value="<?= $id ?>">
                <button type="button" class="btn add-cart-btn" data-id="<?= $id ?>" id="add-to-cart">Add to Cart</button>
        </div>
    </div>
</div>

<div class="recommendation-section">
    <h2>Recommended Products</h2>
    <div class="recommended-products">
        <?php if (!empty($array)): ?>
            <?php foreach ($array as $recommendation): ?>
                <div class="recommended-product">
                    <img src="../seller/product_images2/<?= htmlspecialchars($recommendation['product_image1']) ?>" alt="<?= htmlspecialchars($recommendation['product_name']) ?>">
                    <p class="recommended-product-name"><?= htmlspecialchars($recommendation['product_name']) ?></p>
                    <p class="recommended-product-price">$<?= number_format($recommendation['product_price'], 2) ?></p>
                    <a href="view.php?id=<?= $recommendation ['product_id']?>" class="btn btn-primary">View More</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No recommendations available.</p>
        <?php endif; ?>
    </div>
</div>



<!-- footer here -->
 <?php
 require_once 'includes/footer.php';
 ?>
<script src="ajax.js"></script>

<script>
$(document).ready(function() {
  $('.thumbnail-images img').click(function() {
    var mainImage = $('.main-image img').attr('src');
    var clickedImage = $(this).attr('src');
    $('.main-image img').fadeOut(200, function() {
      $(this).attr('src', clickedImage).fadeIn(200);
    });
    $(this).fadeOut(200, function() {
      $(this).attr('src', mainImage).fadeIn(200);
    });
  });
});
</script>

</body>
</html>
