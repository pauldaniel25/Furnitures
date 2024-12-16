<?php
include('../includes/connect.php');

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    $orderDetailsQuery = mysqli_query($conn, "
        SELECT u.first_name, u.last_name, p.product_name, uod.status, uod.quantity, (p.product_price * uod.quantity) AS total
        FROM user_order_details AS uod
        JOIN products AS p ON uod.product_id = p.product_id
        JOIN user AS u ON uod.user_id = u.id
        WHERE uod.id = '$order_id'
    ");

    if ($orderDetailsQuery && mysqli_num_rows($orderDetailsQuery) > 0) {
        $order = mysqli_fetch_assoc($orderDetailsQuery);
        echo "<h2>Order Details</h2>";
        echo "<p><strong>User Name:</strong> {$order['first_name']} {$order['last_name']}</p>";
        echo "<p><strong>Product Name:</strong> {$order['product_name']}</p>";
        echo "<p><strong>Quantity:</strong> {$order['quantity']}</p>";
        echo "<p><strong>Status:</strong> {$order['status']}</p>";
        echo "<p><strong>Total:</strong> " . number_format($order['total'], 2) . "</p>";

        // Progress bar
        $statuses = ['pending', 'ongoing', 'completed', 'cancelled'];
        echo "<div style='display: flex; align-items: center;'>";
        foreach ($statuses as $index => $status) {
            $active = $status == $order['status'] ? 'green' : 'lightgray';
            echo "<div style='text-align: center; margin-right: 10px;'>";
            echo "<div style='width: 20px; height: 20px; border-radius: 50%; background-color: $active;'></div>";
            echo "<p style='margin: 5px 0;'>$status</p>";
            echo "</div>";
            if ($index < count($statuses) - 1) {
                echo "<div style='flex-grow: 1; height: 2px; background-color: $active;'></div>";
            }
        }
        echo "</div>";
    } else {
        echo "<p>Order not found.</p>";
    }
} else {
    echo "<p>Invalid order ID.</p>";
}
?>