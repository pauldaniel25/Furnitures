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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <title>CH Lumberyard Admin</title>
</head>
<body>

<!-- Sidebar and Header -->
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
            <i class="fa-solid fa-bell" style="font-size: 25px; cursor: pointer;"></i>
            <div class="dropdown">
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
    <h3 class="i-name"><?php echo $fullName; ?></h3>

    <div class="values">
        <div class="val-box">
            <i class="fa-solid fa-users"></i>
            <div>
                <h3><?php echo $productCount; ?></h3>
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
                <h3><?php echo number_format($revenue, 2); ?></h3>
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
                        // Fetch values safely to avoid undefined index warnings
                        $firstName = isset($order['user_first_name']) ? $order['user_first_name'] : 'N/A';
                        $lastName = isset($order['user_last_name']) ? $order['user_last_name'] : 'N/A';
                        $status = isset($order['order_status']) ? $order['order_status'] : 'Unknown';
                        $total = isset($order['total_price']) ? $order['total_price'] : 0.00;
                        $productName = isset($order['product_name']) ? $order['product_name'] : 'No Product Name';
                        $quantity = isset($order['quantity']) ? $order['quantity'] : 0;
                        $productImage = isset($order['product_image1']) ? $order['product_image1'] : 'default_image.jpg';

                        echo "<tr>
                                <td>{$firstName} {$lastName}</td>
                                <td>{$productName}</td>
                                <td>{$quantity}</td>
                                <td>{$status}</td>
                                <td>" . number_format($total, 2) . "</td>
                                <td>
                                    <button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#orderModal{$order['user_order_id']}'>View</button>
                                </td>
                            </tr>";

                        // Modal for Order Details with Status Update Form
                        echo "<div class='modal fade' id='orderModal{$order['user_order_id']}' tabindex='-1' aria-labelledby='orderModalLabel' aria-hidden='true'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='orderModalLabel'>Order Details - {$productName}</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <form method='POST'>
                                    <div class='modal-body'>
                                        <div class='card' style='width: 18rem;'>
                                            <img class='card-img-top' src='product_images2/{$productImage}' alt='Product Image'>
                                            <div class='card-body'>
                                                <h5 class='card-title'>{$productName}</h5>
                                                <p class='card-text'>
                                                    <strong>Customer:</strong> {$firstName} {$lastName}<br>
                                                    <strong>Quantity:</strong> {$quantity}<br>
                                                    <strong>Status:</strong> {$status}<br>
                                                    <strong>Total Price:</strong> $" . number_format($total, 2) . "<br>
                                                </p>
                                                <input type='hidden' name='user_order_id' value='{$order['user_order_id']}'> 
                                                <select name='status' class='form-select'>
                                                    <option value='pending' " . ($status == 'pending' ? 'selected' : '') . ">Pending</option>
                                                    <option value='completed' " . ($status == 'completed' ? 'selected' : '') . ">Completed</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='submit' name='update_status' class='btn btn-success'>Update Status</button>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>";
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

<?php
// Handle status update
if (isset($_POST['update_status'])) {
    $user_order_id = $_POST['user_order_id'];
    $new_status = $_POST['status'];

    // Update the status in the user_order_details table
    $updateStatusQuery = "UPDATE user_order_details SET status = '$new_status' WHERE user_order_id = '$user_order_id' AND seller_id = '$seller_id'";

    if (mysqli_query($conn, $updateStatusQuery)) {
        echo "<script>alert('Order status updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating order status');</script>";
    }
}
?>
