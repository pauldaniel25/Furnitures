<?php
ob_start();
session_start();
require_once('function.php');
require_once('classes.php');
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$prodobj = new Product();
$errorMessage = '';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false) {
    $errorMessage = 'Invalid product ID';
} else {
    $record = $prodobj->fetchRecord($id);
    if (empty($record)) {
        $errorMessage = 'No product found';
    } else {
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

        $arrayrecommend = $prodobj->recommendations($category_name, $id);
        $ratings = $prodobj->getProductRatings($id);
        $average_rating = $ratings['average_rating'];
        $rating_count = $ratings['rating_count'];
        $review_count = isset($ratings['review_count']) ? $ratings['review_count'] : 0;
        $reviews = $prodobj->getProductReviews($id);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
    $user_id = $_SESSION['user_id'];
    $rating = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);
    $review = filter_input(INPUT_POST, 'review', FILTER_SANITIZE_STRING);
;
    
    if (empty($rating) || empty($review)) {
        $errorMessage = "Please select a rating and write a review.";
    } else {
        $result = $prodobj->addProductReview($product_id, $user_id, $rating, $review);
        $errorMessage = $result ? "Review added successfully!" : "Failed to add review!";
        header("Location: view.php?id=$id");
        exit;
    }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="Viewstyle.css"> 
    <link rel="stylesheet" href="Includes/header.css">
    
</head>
<body>
<!-- header here -->
<?php
require_once 'includes/header.php';
?>
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

    
        <div class="rating">
  <p>
    Ratings: 
    <?= ($average_rating % 1 == 0) ? (int) $average_rating : number_format($average_rating, 2) ?>/5
  </p>
  (<span id="rating-count"><?= $rating_count ?></span> reviews)
</div>
<div class="review-section">
  <h2 class="reviews-header">Leave a Review</h2>
  <form action="" method="post">
    <input type="hidden" name="product_id" value="<?= $id ?>">
    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
    
    <div class="rating-container">
      <span class="rating-label">Rating:</span>
      <select name="rating" id="rating-input" required>
        <option value="">Select Rating</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
      </select>
    </div>
    
    <textarea 
      name="review" 
      placeholder="Write your review" 
      maxlength="500"
      class="review-textarea"
    ></textarea>

    <button type="submit" class="submit-btn">Submit Review</button>
    <div class="error-message"></div>
  </form>
</div>

        <div class="buttons">
            <button class="btn cancel-btn" onclick="window.location.href='Dashboard.php'">Cancel</button>
                <input type="hidden" name="product_id" value="<?= $id ?>">
                <button type="button" class="btn add-cart-btn" data-id="<?= $id ?>" id="add-to-cart">Add to Cart</button>
        </div>
    </div>
</div>
<div class="existing-reviews">
    <h2>Reviews (<span id="review-count"><?= $review_count ?></span>)</h2>
    <div id="reviews-container">
        <?php 
        $reviews = $prodobj->getProductReviews($id);
        if (count($reviews) > 0) {
            foreach ($reviews as $review) {
                echo '<div class="review">';
                echo '<div class="review-header">';
                echo '<strong>' . htmlspecialchars($review['username']) . '</strong> - ' . htmlspecialchars($review['rating']) . '/5';
                echo '</div>';
                echo '<p>' . htmlspecialchars($review['review']) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p class="no-reviews">There are no reviews.</p>';
        }
        ?>
    </div>
</div>

<div class="recommendation-section">
  <h2>Recommended Products</h2>
  <div class="recommended-products">
    <?php if (!empty($arrayrecommend)):?>
      <?php foreach ($arrayrecommend as $recommendation): ?>
        <div class="recommended-product">
          <img src="../seller/product_images2/<?= htmlspecialchars($recommendation['product_image1']) ?>" alt="<?= htmlspecialchars($recommendation['product_name']) ?>">
          <p class="recommended-product-name"><?= htmlspecialchars($recommendation['product_name']) ?></p>
          <p class="recommended-product-price">$<?= number_format($recommendation['product_price'], 2) ?></p>
          <div class="btn-container">
            <a href="view.php?id=<?= $recommendation ['product_id']?>" class="btn btn-primary">View More</a>
          </div>
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
