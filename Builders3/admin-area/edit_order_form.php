<?php
include('../includes/connect.php');

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    $orderDetailsQuery = mysqli_query($conn, "
        SELECT u.first_name, u.last_name, p.product_name, p.product_image1, uod.status, uod.quantity, (p.product_price * uod.quantity) AS total
        FROM user_order_details AS uod
        JOIN products AS p ON uod.product_id = p.product_id
        JOIN user AS u ON uod.user_id = u.id
        WHERE uod.id = '$order_id'
    ");

    if ($orderDetailsQuery && mysqli_num_rows($orderDetailsQuery) > 0) {
        $order = mysqli_fetch_assoc($orderDetailsQuery);
        echo "<h2 style='text-align: center; color: #333;'>Edit Order</h2>";
        echo "<form action='update_order.php' method='POST' enctype='multipart/form-data' style='max-width: 500px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);'>";
        echo "<input type='hidden' name='order_id' value='{$order_id}'>";
        echo "<p><strong>User Name:</strong> {$order['first_name']} {$order['last_name']}</p>";
        echo "<p><strong>Product Name:</strong> <input type='text' name='product_name' value='{$order['product_name']}' style='width: 100%; padding: 10px; margin: 5px 0; border: 1px solid #ccc; border-radius: 5px;'></p>";
        echo "<p><strong>Product Image:</strong><br><input type='file' name='product_image' style='width: 100%; padding: 10px; margin: 5px 0; border: 1px solid #ccc; border-radius: 5px;'></p>";
        echo "<p><strong>Quantity:</strong> <input type='number' name='quantity' value='{$order['quantity']}' style='width: 100%; padding: 10px; margin: 5px 0; border: 1px solid #ccc; border-radius: 5px;'></p>";
        echo "<p><strong>Status:</strong> <select name='status' style='width: 100%; padding: 10px; margin: 5px 0; border: 1px solid #ccc; border-radius: 5px;'>
                <option value='Pending' " . ($order['status'] == 'Pending' ? 'selected' : '') . ">Pending</option>
                <option value='Ongoing' " . ($order['status'] == 'Ongoing' ? 'selected' : '') . ">Ongoing</option>
                <option value='Completed' " . ($order['status'] == 'Completed' ? 'selected' : '') . ">Completed</option>
                <option value='Cancelled' " . ($order['status'] == 'Cancelled' ? 'selected' : '') . ">Cancelled</option>
              </select></p>";
        echo "<p><strong>Total:</strong> " . number_format($order['total'], 2) . "</p>";
        echo "<button type='submit' style='background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; width: 100%;'>Update</button>";
        echo "</form>";
    } else {
        echo "<p>Order not found.</p>";
    }
} else {
    echo "<p>Invalid order ID.</p>";
}
?>
