<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'classes.php';

$order = new Order();
$items_per_page = 5;
$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

$total_orders = count($order->getOrders($_SESSION['user_id']));
$total_pages = ceil($total_orders / $items_per_page);

$orders = $order->getOrders($_SESSION['user_id'], $items_per_page, $offset);
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
<div class="modal fade" id="order-details-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-container"></div>
        </div>
    </div>
</div>

<!-- modal heree -->
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
                                    <span class="status <?= $order['order_status'] ?>">
                                        <?= $order['order_status'] ?>
                                    </span>
                                </td>
                                <td>
                                <button class="btn-cancel" data-id="<?= $order['order_details_id'] ?>">Cancel</button>
                                    <button class="btn-view" data-id="<?= $order['order_details_id'] ?>">View Details</button>
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
            <!-- pagi section -->
            <div class="pagination justify-content-center mt-4">
    <a href="?page=<?= ($page - 1) ?>" class="prev <?= ($page == 1) ? 'disabled' : '' ?>">&lt;</a>
    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
        <?php if ($i == $page) : ?>
            <span class="active"><?= $i ?></span>
        <?php else : ?>
            <a href="?page=<?= $i ?>" class="page"><?= $i ?></a>
        <?php endif; ?>
    <?php endfor; ?>
    <a href="?page=<?= ($page + 1) ?>" class="next <?= ($page == $total_pages) ? 'disabled' : '' ?>">&gt;</a>
</div>
</div>
        </div>
    </div>
    <?php
 require_once 'includes/footer.php';
 ?>
    <script src="ajax.js"></script>

</body>
</html>