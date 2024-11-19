<?php
include('../includes/connect.php');
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    
    // Fetch order details
    $orderQuery = mysqli_query($conn, "
        SELECT uod.id, u.first_name, u.last_name, p.product_name, uod.quantity, uod.status, p.product_price
        FROM user_order_details AS uod
        JOIN products AS p ON uod.product_id = p.product_id
        JOIN user AS u ON uod.user_id = u.id
        WHERE uod.id = '$order_id'
    ");
    
    $order = mysqli_fetch_assoc($orderQuery);
    
    if (!$order) {
        echo "Order not found.";
        exit();
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $quantity = $_POST['quantity'];
        $status = $_POST['status'];

        $updateQuery = "UPDATE user_order_details SET quantity='$quantity', status='$status' WHERE id='$order_id'";
        
        if (mysqli_query($conn, $updateQuery)) {
            header("Location: admin.php?message=Order updated successfully.");
            exit();
        } else {
            echo "<script>alert('Error updating order: " . mysqli_error($conn) . "');</script>";
        }
    }
} else {
    echo "No order ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 500px;
            margin: auto;
        }

        h2 {
            text-align: center;
            color: #378370; /* Main color */
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box; /* Ensures padding is included in width */
        }

        input[type="text"]:disabled {
            background-color: #f9f9f9; /* Light gray for disabled fields */
        }

        .submit-btn, .cancel-btn {
            display: inline-block;
            width: 48%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 4px;
            text-align: center;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .submit-btn {
            background-color: #378370; /* Main color */
        }

        .submit-btn:hover {
            background-color: #2a6a5c; /* Darker shade for hover */
        }

        .cancel-btn {
            background-color: #dc3545; /* Red for cancel */
            text-decoration: none;
            text-align: center;
        }

        .cancel-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Order</h2>
        <form method="POST">
            <div class="form-group">
                <label for="user">User:</label>
                <input type="text" id="user" value="<?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?>" disabled>
            </div>

            <div class="form-group">
                <label for="product">Product:</label>
                <input type="text" id="product" value="<?php echo htmlspecialchars($order['product_name']); ?>" disabled>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" id="quantity" value="<?php echo htmlspecialchars($order['quantity']); ?>" required>
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" id="status" required>
                    <option value="pending" <?php echo ($order['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="completed" <?php echo ($order['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                    <option value="canceled" <?php echo ($order['status'] == 'canceled') ? 'selected' : ''; ?>>Canceled</option>
                </select>
            </div>

            <button type="submit" class="submit-btn">Update Order</button>
            <a href="admin.php" class="cancel-btn">Cancel</a>
        </form>
    </div>
</body>
</html>
