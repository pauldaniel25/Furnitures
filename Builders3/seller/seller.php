<?php
include('../includes/connect.php');
session_start();
include('seller.class.php');

// Check if the session email variable is set
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $seller_id = $_SESSION['seller_id'];

    // Initialize SellerDashboard object
    $sellerDashboard = new SellerDashboard($conn);

    // Fetch seller details
    $sellerDetails = $sellerDashboard->getSellerDetails($email);

    if ($sellerDetails) {
        $fullName = $sellerDetails['firstName'] . ' ' . $sellerDetails['lastName'];
        $isSubscribed = !is_null($sellerDetails['subscription_id']);
        $current_subscription_id = $sellerDetails['subscription_id'];
        $profileImg = $sellerDetails['profile_img']; // Fetch the profile image URL

        // Fetch product count, order count, revenue, and completed products count
        $productCount = $sellerDashboard->getProductCount($seller_id);
        $orderCount = $sellerDashboard->getOrderCount($seller_id);
        $revenue = $sellerDashboard->getRevenue($seller_id);
        $completedProductsCount = $sellerDashboard->getCompletedProductsCount($seller_id);

        // Fetch current subscription details
        $current_subscription_name = $sellerDashboard->getSubscriptionName($current_subscription_id);

        // Initialize search parameters
        $searchTerm = isset($_GET['search_term']) ? mysqli_real_escape_string($conn, $_GET['search_term']) : '';
        $searchStatus = isset($_GET['search_status']) ? mysqli_real_escape_string($conn, $_GET['search_status']) : '';

        // Fetch orders with search filters applied
        $ordersQuery = $sellerDashboard->getOrders($seller_id, $searchTerm, $searchStatus);

        // Handle order status update via AJAX
        if (isset($_POST['update_status'])) {
            $order_id = $_POST['order_id'];
            $new_status = $_POST['status'];

            if ($sellerDashboard->updateOrderStatus($order_id, $new_status)) {
                echo json_encode(["success" => true, "message" => "Order status updated successfully"]);
            } else {
                echo json_encode(["success" => false, "message" => "Error updating order status"]);
            }
            exit();
        }
    } else {
        $fullName = 'User not found';
        $productCount = 0;
        $profileImg = 'profile_images/default_profile.jpg'; // Use a default profile image if no data is found
    }
} else {
    $fullName = 'Guest';
    $productCount = 0;
    $profileImg = 'profile_images/default_profile.jpg'; // Default image for guest
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom CSS -->
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
        <?php if ($current_subscription_name): ?>
            <li><i class="fa-solid fa-chart-pie"></i><a href="insert_product.php">Create Listing</a></li>
        <?php else: ?>
            <li><i class="fa-solid fa-chart-pie"></i><a href="#" class="disabled" title="You must subscribe to add a product">Create Listing (Unavailable)</a></li>
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
            <!-- Search Section -->
            <div class="search">
                <form action="" method="GET" style="display: flex; gap: 10px; align-items: center;">
                    <input type="text" name="search_term" placeholder="search names or products" value="<?php echo isset($_GET['search_term']) ? htmlspecialchars($_GET['search_term']) : ''; ?>" />
                    <button class="search_button" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>

            <!-- Status Filter Section -->
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
            <!-- Notification Icon (remains visible) -->
            <i class="fa-solid fa-bell" style="font-size: 25px; cursor: pointer;"></i>

            <!-- Profile Image Click to Toggle Dropdown -->
            <div class="dropdown">
                <!-- Use the dynamic profile image here -->
                <img src="<?php echo $profileImg; ?>" alt="Profile Picture" width="30" height="30" class="rounded-circle" id="profilePic" data-bs-toggle="dropdown" aria-expanded="false">
                <ul class="dropdown-menu" aria-labelledby="profilePic">
                    <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                    <li><a class="dropdown-item" href="#">Account Settings</a></li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </div>
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
                <span>Completed Orders</span>
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
                                    <form action='' method='POST'>
                                        <input type='hidden' name='order_id' value='{$order['order_id']}'>
                                        <select name='status' onchange='this.form.submit()'>
                                            <option value='pending' ".($order['status'] == 'pending' ? 'selected' : '').">Pending</option>
                                            <option value='completed' ".($order['status'] == 'completed' ? 'selected' : '').">Completed</option>
                                            <option value='canceled' ".($order['status'] == 'canceled' ? 'selected' : '').">Canceled</option>
                                        </select>
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

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
