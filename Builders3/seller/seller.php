<?php
include('../includes/connect.php');
session_start();

// Check if the session email variable is set
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $seller_id = $_SESSION['seller_id'];

    // Fetch user details and subscription status from the database
    $query = mysqli_query($conn, "SELECT s.*, sub.start_date, sub.end_date 
                                   FROM `seller` s 
                                   LEFT JOIN `subscription` sub ON s.subscription_id = sub.id 
                                   WHERE s.email='$email'");

    if ($query && mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_array($query);
        $fullName = $row['firstName'] . ' ' . $row['lastName'];
        $isSubscribed = !is_null($row['subscription_id']);

        // Count the number of listed products for the specific seller
        $productCountQuery = mysqli_query($conn, "SELECT COUNT(*) as total_products FROM `products` WHERE `seller_id`='$seller_id'");
        $productCount = mysqli_fetch_assoc($productCountQuery)['total_products'] ?? 0;

        // Count the number of orders for the specific seller
        $orderCountQuery = mysqli_query($conn, "SELECT COUNT(*) as total_orders FROM `user_order_details` WHERE `seller_id`='$seller_id'");
        $orderCount = mysqli_fetch_assoc($orderCountQuery)['total_orders'] ?? 0;

        // Calculate total revenue for the specific seller from completed orders
        $revenueQuery = mysqli_query($conn, "
            SELECT SUM(p.product_price * uod.quantity) AS total_revenue
            FROM user_order_details AS uod
            JOIN products AS p ON uod.product_id = p.product_id
            WHERE uod.seller_id = '$seller_id' AND uod.status = 'completed'
        ");
        $revenue = mysqli_fetch_assoc($revenueQuery)['total_revenue'] ?? 0;



        $completedProductsQuery = mysqli_query($conn, "
            SELECT COUNT(DISTINCT uod.product_id) AS total_completed_products
            FROM user_order_details AS uod
            WHERE uod.seller_id = '$seller_id' AND uod.status = 'completed'
        ");
        $completedProductsCount = mysqli_fetch_assoc($completedProductsQuery)['total_completed_products'] ?? 0;

        // Initialize search parameters
        $searchTerm = isset($_GET['search_term']) ? mysqli_real_escape_string($conn, $_GET['search_term']) : '';
        $searchStatus = isset($_GET['search_status']) ? mysqli_real_escape_string($conn, $_GET['search_status']) : '';

        // Build the orders query
        $queryConditions = "WHERE uod.seller_id = '$seller_id'";
        if ($searchTerm) {
            $queryConditions .= " AND (u.first_name LIKE '%$searchTerm%' OR u.last_name LIKE '%$searchTerm%' OR p.product_name LIKE '%$searchTerm%')";
        }
        if ($searchStatus) {
            $queryConditions .= " AND uod.status = '$searchStatus'";
        }

        // Fetch orders for the specific seller
        $ordersQuery = mysqli_query($conn, "
            SELECT u.first_name, u.last_name, p.product_name, uod.status, uod.quantity, (p.product_price * uod.quantity) AS total, uod.id AS order_id
            FROM user_order_details AS uod
            JOIN products AS p ON uod.product_id = p.product_id
            JOIN user AS u ON uod.user_id = u.id
            $queryConditions
        ");

        // Handle order status update
        if (isset($_POST['update_status'])) {
            $order_id = $_POST['order_id'];
            $new_status = $_POST['status'];

            $updateStatusQuery = "UPDATE `user_order_details` SET `status`='$new_status' WHERE `id`='$order_id'";
            if (mysqli_query($conn, $updateStatusQuery)) {
                echo "<script>alert('Order status updated successfully');</script>";
                // Refresh the page to see updated status
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                echo "<script>alert('Error updating order status: " . mysqli_error($conn) . "');</script>";
            }
        }
    } else {
        $fullName = 'User not found';
        $productCount = 0;
    }
} else {
    $fullName = 'Guest';
    $productCount = 0;
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <title>CH Lumberyard Admin</title>
</head>
<body>

<!-- Header Section -->
<section id="menu">
    <div class="logo">
        <img src="LOGO-removebg-preview.png" alt="CH Lumber">
        <h2>CH Lumber</h2>
    </div>
    <div class="items">
        <li><i class="fa-solid fa-chart-pie"></i><a href="seller.php">Dashboard</a></li>
        <?php if ($isSubscribed): ?>
            <li><i class="fa-solid fa-chart-pie"></i><a href="insert_product.php">Create Listing</a></li>
        <?php else: ?>
            <li><i class="fa-solid fa-chart-pie"></i><a href="#" style="color:gray; cursor:not-allowed;" title="You must subscribe to add a product">Create Listing (Unavailable)</a></li>
        <?php endif; ?>
        <li><i class="fa-solid fa-chart-pie"></i><a href="listedproduct.php">Listed Products</a></li>
        <li><i class="fa-solid fa-chart-pie"></i><a href="Subscription.php">Subscription</a></li>
        <li><i class="fa-solid fa-chart-pie"></i><a href="logout.php">Logout</a></li>
    </div>
</section>

<!-- Main Content Section -->
<section id="interface">
    <div class="navigation">
        <div class="n1">
            <div>
                <i id="menu-btn" class="fa-solid fa-bars"></i>
            </div>
            <div class="search">
                <form action="" method="GET" style="display: flex; gap: 10px; align-items: center;">
                    <input type="text" name="search_term" placeholder="search names or products" value="<?php echo isset($_GET['search_term']) ? htmlspecialchars($_GET['search_term']) : ''; ?>" />
                    <button class="search_button" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
            <div class="status-filter">
                <form action="" method="GET" style="display: flex; align-items: center;">
                    <select name="search_status" onchange="this.form.submit()">
                        <option value="">Status</option>
                        <option value="pending" <?php echo (isset($_GET['search_status']) && $_GET['search_status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                        <option value="completed" <?php echo (isset($_GET['search_status']) && $_GET['search_status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                        <option value="canceled" <?php echo (isset($_GET['search_status']) && $_GET['search_status'] == 'canceled') ? 'selected' : ''; ?>>Canceled</option>
                    </select>
                </form>
            </div>
        </div>
        <div class="profile">
            <i class="fa-solid fa-bell"></i>
            <img src="penguin.avif" alt="Profile Picture">
        </div>
    </div>
    <h3 class="i-name">Welcome</h3>
    <h3 class="i-name"><?php echo $fullName; ?></h3> <!-- Display user name -->
    
    <div class="values">
        <div class="val-box">
            <i class="fa-solid fa-users"></i>
            <div>
                <h3><?php echo $productCount; ?></h3> <!-- Display number of listed products -->
                <span>Listed Products</span>
            </div>
        </div>
        <div class="val-box">
            <i class="fa-solid fa-cart-shopping"></i>
            <div>
                <h3><?php echo $orderCount; ?></h3>
                <span>Orders</span>
            </div>
        </div>
        <div class="val-box">
            <i class="fa-solid fa-money-bill"></i>
            <div>
                <h3><?php echo number_format($revenue, 2); ?></h3> <!-- Display total revenue -->
                <span>Revenue</span>
            </div>
        </div>
        <div class="val-box">
            <i class="fa-solid fa-truck-fast"></i>
            <div>
                <h3><?php echo $completedProductsCount; ?></h3>
                <span>completed orders</span>
            </div>
        </div>
    </div>

    <div class="board">
        <h1>Orders</h1>
        <table width="100%">
            <thead>
                <tr>
                    <td>User Name</td>
                    <td>Product Name</td>
                    <td>Quantity</td>
                    <td>Status</td>
                    <td>Total</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($ordersQuery && mysqli_num_rows($ordersQuery) > 0) {
                    while ($order = mysqli_fetch_assoc($ordersQuery)) {
                        echo "<tr>
                                <td>{$order['first_name']} {$order['last_name']}</td>
                                <td>{$order['product_name']}</td>
                                <td>{$order['quantity']}</td>
                                <td>{$order['status']}</td>
                                <td>" . number_format($order['total'], 2) . "</td>
                                <td>
                                    <form action='' method='POST' style='display:inline;'>
                                        <input type='hidden' name='order_id' value='{$order['order_id']}'>
                                        <select name='status' required>
                                            <option value='pending' " . ($order['status'] == 'pending' ? 'selected' : '') . ">Pending</option>
                                            <option value='completed' " . ($order['status'] == 'completed' ? 'selected' : '') . ">Completed</option>
                                            <option value='canceled' " . ($order['status'] == 'canceled' ? 'selected' : '') . ">Canceled</option>
                                        </select>
                                        <button type='submit' name='update_status'>Update</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No orders found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Footer Section -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.49.0/apexcharts.min.js"></script>
</body>
</html>
