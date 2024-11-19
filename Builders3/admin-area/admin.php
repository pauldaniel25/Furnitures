<?php
include('../includes/connect.php');
session_start();

// Check if the session email variable is set
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $admin_id = $_SESSION['admin_id'];

    // Fetch admin details from the database
    $query = mysqli_query($conn, "SELECT * FROM `admin` WHERE email='$email'");

    if ($query && mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_array($query);
        $fullName = $row['firstName'] . ' ' . $row['lastName'];

        // Count the number of listed products
        $productCountQuery = mysqli_query($conn, "SELECT COUNT(*) as total_products FROM `products`");
        $productCount = mysqli_fetch_assoc($productCountQuery)['total_products'] ?? 0;

        // Count the number of orders
        $orderCountQuery = mysqli_query($conn, "SELECT COUNT(*) as total_orders FROM `user_order_details`");
        $orderCount = mysqli_fetch_assoc($orderCountQuery)['total_orders'] ?? 0;

        // Calculate total revenue
        $revenueQuery = mysqli_query($conn, "
            SELECT SUM(p.product_price * uod.quantity) AS total_revenue
            FROM user_order_details AS uod
            JOIN products AS p ON uod.product_id = p.product_id
            WHERE uod.status = 'completed'
        ");
        $revenue = mysqli_fetch_assoc($revenueQuery)['total_revenue'] ?? 0;

        // Count the number of sellers
        $sellerCountQuery = mysqli_query($conn, "SELECT COUNT(*) as total_sellers FROM `seller`");
        $sellerCount = mysqli_fetch_assoc($sellerCountQuery)['total_sellers'] ?? 0;

        // Count the number of users
        $userCountQuery = mysqli_query($conn, "SELECT COUNT(*) as total_users FROM `user`");
        $userCount = mysqli_fetch_assoc($userCountQuery)['total_users'] ?? 0;

        // Fetch all orders
        $ordersQuery = mysqli_query($conn, "
            SELECT u.first_name, u.last_name, p.product_name, uod.status, uod.quantity, (p.product_price * uod.quantity) AS total, uod.id AS order_id
            FROM user_order_details AS uod
            JOIN products AS p ON uod.product_id = p.product_id
            JOIN user AS u ON uod.user_id = u.id
        ");

        // Handle order deletion
        if (isset($_GET['delete_order_id'])) {
            $order_id = $_GET['delete_order_id'];
            $deleteQuery = "DELETE FROM user_order_details WHERE id='$order_id'";
            if (mysqli_query($conn, $deleteQuery)) {
                header("Location: " . $_SERVER['PHP_SELF'] . "?message=Order deleted successfully.");
                exit();
            } else {
                echo "<script>alert('Error deleting order: " . mysqli_error($conn) . "');</script>";
            }
        }
    } else {
        $fullName = 'Admin not found';
        $productCount = 0;
    }
} else {
    $fullName = 'Guest';
    $productCount = 0;
}

// Fetching the message if exists
$message = isset($_GET['message']) ? $_GET['message'] : '';
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
        <li><i class="fa-solid fa-chart-pie"></i><a href="admin.php">Dashboard</a></li>
        <li><i class="fa-solid fa-chart-pie"></i><a href="insert_product.php">Products</a></li>
        <li><i class="fa-solid fa-chart-pie"></i><a href="product.php">Listed Products</a></li>
        <li><i class="fa-solid fa-chart-pie"></i><a href="user.php">Users</a></li>
        <li><i class="fa-solid fa-chart-pie"></i><a href="seller.php">Sellers</a></li>
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
                    <input type="text" name="search_term" placeholder="Search names or products" value="<?php echo isset($_GET['search_term']) ? htmlspecialchars($_GET['search_term']) : ''; ?>" />
                    <button class="search_button" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
        </div>
        <div class="profile">
            <i class="fa-solid fa-bell"></i>
            <img src="penguin.avif" alt="Profile Picture">
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
                <span>Total Revenue</span>
            </div>
        </div>
        <div class="val-box">
            <i class="fa-solid fa-users"></i>
            <div>
                <h3><?php echo $sellerCount; ?></h3>
                <span>Total Sellers</span>
            </div>
        </div>
        <div class="val-box">
            <i class="fa-solid fa-users"></i>
            <div>
                <h3><?php echo $userCount; ?></h3>
                <span>Total Users</span>
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
                    <td>Actions</td>
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
                                    <a href='edit_order.php?order_id={$order['order_id']}' class='edit-btn'>Edit</a>
                                    <a href='?delete_order_id={$order['order_id']}' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this order?\");'>Delete</a>
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
