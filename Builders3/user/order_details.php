
<?php
require_once 'classes.php';

if ($_GET['id']) {
    $order = new Order();
    $order_id = $_GET['id'];
    $order_data = $order->getOrderById($order_id);

    if ($order_data) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
            <link rel="stylesheet" href="order_details.css">
        </head>
        <body>
        <div class="modal-header">
            <h5 class="modal-title">Order Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
  <h2><?= $order_data['product_name'] ?></h2>
  <div class="image-gallery">
    <div class="main-image">
      <img src="../seller/product_images2/<?= htmlspecialchars($order_data['product_image1']) ?>" alt="<?= $order_data['product_name'] ?>" class="img-fluid main-img">
    </div>
    <div class="thumbnail-images">
      <?php if (!empty($order_data['product_image2'])) { ?>
        <img src="../seller/product_images2/<?= htmlspecialchars($order_data['product_image2']) ?>" alt="<?= $order_data['product_name'] ?>" class="thumb-img">
      <?php } ?>
      <?php if (!empty($order_data['product_image3'])) { ?>
        <img src="../seller/product_images2/<?= htmlspecialchars($order_data['product_image3']) ?>" alt="<?= $order_data['product_name'] ?>" class="thumb-img">
      <?php } ?>
    </div>
  </div>
  <p>Quantity: <?= $order_data['quantity'] ?></p>
  <p>Date Ordered: <?= $order_data['date_ordered'] ?></p>
  <p class="status">
  Status: <span class="<?= strtolower($order_data['order_status']) ?>"><?= $order_data['order_status']?></span>
  <?= var_dump($order_data['order_status']) ?>
</p>
  <p>Total Amount: $<?= number_format($order_data['total'], 2) ?></p>
</div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <?php
    } else {
        echo 'Order not found.';
    }
} else {
    echo 'Invalid request.';
}
?>

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
       