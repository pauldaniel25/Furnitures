<?php
include('../includes/connect.php');
session_start();

// Check if the seller is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$seller_id = $_SESSION['seller_id'];

// Fetch completed orders for this seller
$orderQuery = "
    SELECT 
        uod.id AS order_id, 
        u.first_name, 
        u.last_name, 
        p.product_name, 
        p.product_image1, 
        uod.quantity, 
        uod.status, 
        p.product_price * uod.quantity AS total
    FROM user_order_details uod
    JOIN user u ON uod.user_id = u.id
    JOIN products p ON uod.product_id = p.product_id
    WHERE uod.seller_id = '$seller_id' AND uod.status = 'completed'
";

$result = mysqli_query($conn, $orderQuery);

// Check if any completed orders exist
if (mysqli_num_rows($result) == 0) {
    $noOrdersMessage = "You have no completed orders.";
} else {
    $noOrdersMessage = "";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Completed Orders</h2>
    <?php if ($noOrdersMessage): ?>
        <p class="alert alert-info"><?php echo $noOrdersMessage; ?></p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display all completed orders
                    while ($order = mysqli_fetch_assoc($result)) {
                        $customerName = $order['first_name'] . ' ' . $order['last_name'];
                        $productName = $order['product_name'];
                        $quantity = $order['quantity'];
                        $total = number_format($order['total'], 2);
                        $status = $order['status'];
                        $productImage = $order['product_image1'];

                        echo "<tr>
                                <td>{$customerName}</td>
                                <td><img src='./product_images2/{$productImage}' alt='{$productName}' width='50'></td>
                                <td>{$quantity}</td>
                                <td>{$status}</td>
                                <td>\${$total}</td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <!-- Button to redirect to seller.php -->
    <div class="mt-4">
        <a href="seller.php" class="btn btn-primary">Go to Seller Dashboard</a>
    </div>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
