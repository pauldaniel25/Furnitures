<?php
require_once 'classes.php';

session_start();
$user_id = $_SESSION['user_id'];
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
$cart = new Cart();

$cart_items = $cart->getCartItems($user_id);
$total_price = 0;

foreach ($cart_items as $item) {
    $total_price += $item['product_price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="../vendor/bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendor/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../vendor/datatable-2.1.8/datatables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="cart2style.css">
    <link rel="stylesheet" href="includes/header.css">
</head>

<body>
    <?php require_once 'includes/header.php'; 

if (isset($_GET['success'])): ?>
    <div class="alert alert-success position-absolute top-50 start-50 translate-middle" id="success-message">
        Ordered successfully!
    </div>

    <script>
        // Remove query parameter immediately
        window.history.replaceState({}, '', window.location.href.split('?')[0]);

        setTimeout(() => {
            document.getElementById("success-message").remove();
        }, 1000);
    </script>
<?php endif; ?>

    <div class="cart-container">
        <div class="cart-header">
            <h2>Cart</h2>
        </div>

        <div class="cart-body">
            <?php if (empty($cart_items)) : ?>
                <p>Cart is empty</p>
            <?php else : ?>
                <?php foreach ($cart_items as $item) : ?>
                    <div class="cart-product">
                        <p class="cart-item-id" style="display:none;"><?= $item['cart_item_id'] ?></p>
                        <div class="product-image">
                            <img src="../seller/product_images2/<?= $item['product_image1'] ?>" alt="<?= $item['product_name'] ?>" class="image">
                        </div>
                        <div class="product-details">
                            <h4><?= $item['product_name'] ?></h4>
                        </div>
                        <div class="unit-price">
                            <p>$<?= number_format($item['product_price'], 2) ?></p>
                        </div>
                        <div class="quantity">
                            <input type="number" value="<?= $item['quantity'] ?>" min="1">
                        </div>
                        <div class="total-price">
                            <p>$<?= number_format($item['product_price'] * $item['quantity'], 2) ?></p>
                        </div>
                        <div class="action">
                            <button class="remove action_btn">Remove</button>
                            <button class="action_btn view-btn" id="<?= $item['product_id']?>" onclick="location.href='view.php?id=<?= $item['product_id']?>'">View</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="cart-footer">
    <p class="total">Total: $<?= number_format($total_price, 2) ?></p>
    
    <?php if (empty($cart_items)): ?>
        <button class="checkout" onclick="showErrorMessage()">Checkout</button>
        <p id="error-message" class="text-danger" style="display:none;">You have no items to checkout.</p>
    <?php else: ?>
        <a href="checkout.php"><button class="checkout">Checkout</button></a>
    <?php endif; ?>
</div>

    <script src="cart2script.js"></script>
</body>
</html>