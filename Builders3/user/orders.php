<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'classes.php';

$order = new Order();
$orders = $order->getOrders($_SESSION['user_id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="../vendor/bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendor/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../vendor/datatable-2.1.8/datatables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="includes/header.css">
    <link rel="stylesheet" href="orders.css">
</head>

<body>
    <?php require_once 'includes/header.php'; ?>
    <div class="container">
        <h1 class="mb-4">My Orders</h1>
        <div class="order-list">
            <table id="order-table" class="table table-striped">
                            <thead>
                    <tr>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Date Ordered</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (count($orders) > 0) : ?>
                        <?php foreach ($orders as $order) : ?>
                            <tr>
                                <td><img src="../seller/product_images2/<?= $order['product_image1']?>" alt="Product Image" class="product-image"></td>
                                <td><?= $order['product_name']?></td>
                                <td><?= $order['quantity']?></td>
                                <td><?= $order['date_ordered']?></td>
                                <td>$<?= number_format($order['total'], 2)?></td>
                                <td>
                                    <span class="status <?= $order['status'] ?>">
                                        <?= $order['status'] ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn-cancel">Cancel</button>
                                    <button class="btn-view">View Details</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">No orders found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>