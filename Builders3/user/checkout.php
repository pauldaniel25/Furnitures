<?php
require_once 'classes.php';

session_start();
$user_id = $_SESSION['user_id'];

$cart = new Cart();

// Get cart items
$cart_items = $cart->getCartItems($user_id);

// Calculate total price
$total_price = 0;
foreach ($cart_items as $item) {
    $total_price += $item['product_price'] * $item['quantity'];
}

// Handle checkout
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create order
    $order = new Order();
    $order_id = $order->createOrder($total_price);

    // Add order items
    foreach ($cart_items as $item) {
        $order->addOrderItem($order_id, $item['product_id'], $item['quantity'], $item['product_price'], $item['seller_id']);
    }

    // Clear cart
    $cart->clearCart($user_id);

      // Insert into order_status_history
      $order->updateOrderStatus($order_id, 'pending');

    header('Location: cart2.php?success=true');
    exit;
}
$user = new User();
$user_data = $user->getUserData($_SESSION['user_id']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../vendor/bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendor/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../vendor/datatable-2.1.8/datatables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="includes/header.css">
    <link rel="stylesheet" href="checkout.css">
</head>
<body>
    <?php require_once 'includes/header.php'; ?>

  
    <div class="container mt-5">
  <div class="row">
    <div class="col-md-4">
      <div class="order-summary card mb-4">
        <h5 class="card-header">Order Summary</h5>
        <div class="card-body">
          <div class="product-list" style="max-height: 300px; overflow-y: auto;">
            <?php foreach ($cart_items as $item) : ?>
              <div class="list-group-item d-flex justify-content-between align-items-center">
                <span><?= $item['product_name'] ?> x <?= $item['quantity'] ?></span>
                <span>$<?= number_format($item['product_price'] * $item['quantity'], 2) ?></span>
              </div>
            <?php endforeach; ?>
            <div class="list-group-item d-flex justify-content-between align-items-center">
              <strong>Subtotal:</strong>
              <span>$<?= number_format($total_price, 2) ?></span>
            </div>
            <div class="list-group-item d-flex justify-content-between align-items-center">
              <strong>Total:</strong>
              <span>$<?= number_format($total_price, 2) ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>

   <div class="col-md-8">
    <div class="checkout-form card mb-4">
        <h5 class="card-header">Checkout Information</h5>
        <div class="card-body">
            <form method="post" id="checkout-form">
                
            <div class="mb-3">
    <label for="name">Full Name:</label>
    <input type="text" id="name" name="name" class="form-control" value="<?= $user_data['First_Name'] . ' ' . $user_data['Last_Name'] ?>" required>
</div>
<div class="mb-3">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" class="form-control" value="<?= $user_data['Email'] ?>" required>
</div>
<div class="mb-3">
    <label for="address">Address:</label>
    <select id="address" name="address" class="form-control" required>
        <?php
        $barangays = $user->getbarangay();
        foreach ($barangays as $barangay) {
            $selected = ($barangay['id'] == $user_data['barangay_id']) ? 'selected' : '';
            echo "<option value='{$barangay['id']}' $selected>{$barangay['Brgy_Name']}</option>";
        }
        ?>
    </select>
</div>
                <div class="mb-3">
                    <label for="address-details">Detailed Address (Optional):</label>
                    <input id="address-details" name="address-details" class="form-control"></input>
                </div>
                <div class="mb-3">
                    <label for="order-notes">Order Notes (Optional):</label>
                    <textarea id="order-notes" name="order-notes" class="form-control"></textarea>
                </div>
            </form>
        </div>
    </div>
</div>
    <div class="payment-method card mb-4">
        <h5 class="card-header">Payment Method</h5>
        <div class="card-body">
            <p>Cash on Delivery (COD)</p>
            <p>Please pay upon delivery.</p>
        </div>
    </div>
    <div class="actions">
        <button class="btn btn-secondary me-2" onclick="location.href='cart2.php'">Back to Cart</button>
        <button form="checkout-form" type="submit" class="btn btn-primary">Confirm Order</button>
    </div>
</div>