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

        // Count the number of subscriptions
        $subscriptionCountQuery = mysqli_query($conn, "SELECT COUNT(*) as total_subscribed_sellers FROM `seller` WHERE `subscription_id` IS NOT NULL AND `subscription_id` != 0");
        $subscriptionCount = mysqli_fetch_assoc($subscriptionCountQuery)['total_subscribed_sellers'] ?? 0;
        

        // Fetch subscription counts by type
        $subscriptionCountByTypeQuery = mysqli_query($conn, "
            SELECT name, COUNT(*) as count
            FROM subscription
            GROUP BY name
        ");
        $subscriptionCounts = [];
        while ($row = mysqli_fetch_assoc($subscriptionCountByTypeQuery)) {
            $subscriptionCounts[$row['name']] = $row['count'];
        }

        // Define colors for each subscription type
        $subscriptionColors = [
            'Basic' => '#FF6384',
            'Standard' => '#36A2EB',
            'Premium' => '#FFCE56',
            'VIP' => '#4CAF50'
        ];

        // Assign colors to each subscription type
        $barColors = [];
        foreach ($subscriptionCounts as $name => $count) {
            $barColors[] = $subscriptionColors[$name] ?? sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        }

        // Fetch all orders with search functionality
        $searchTerm = isset($_GET['search_term']) ? mysqli_real_escape_string($conn, $_GET['search_term']) : '';
        $ordersQuery = mysqli_query($conn, "
            SELECT u.first_name, u.last_name, p.product_name, uod.status, uod.quantity, (p.product_price * uod.quantity) AS total, uod.id AS order_id
            FROM user_order_details AS uod
            JOIN products AS p ON uod.product_id = p.product_id
            JOIN user AS u ON uod.user_id = u.id
            WHERE u.first_name LIKE '%$searchTerm%' OR u.last_name LIKE '%$searchTerm%' OR p.product_name LIKE '%$searchTerm%' OR uod.status LIKE '%$searchTerm%'
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

        // Fetch transaction status counts
        $statusCountQuery = mysqli_query($conn, "
            SELECT status, COUNT(*) as count
            FROM user_order_details
            GROUP BY status
        ");
        $statusCounts = [];
        while ($row = mysqli_fetch_assoc($statusCountQuery)) {
            $statusCounts[$row['status']] = $row['count'];
        }

        // Calculate total subscription income from subscribed sellers
        $subscriptionIncomeQuery = mysqli_query($conn, "
            SELECT SUM(sub.subscription_price) as total_income
            FROM seller AS s
            JOIN subscription AS sub ON s.subscription_id = sub.id
            WHERE s.subscription_id IS NOT NULL AND s.subscription_id != 0
        ");
        $subscriptionIncome = mysqli_fetch_assoc($subscriptionIncomeQuery)['total_income'] ?? 0;

        // Fetch all subscribers with their subscription type and price
        $subscribersQuery = mysqli_query($conn, "
            SELECT s.firstName, s.lastName, sub.name AS subscription_type, sub.subscription_price
            FROM seller AS s
            JOIN subscription AS sub ON s.subscription_id = sub.id
        ");
    } else {
        $fullName = 'Admin not found';
        $productCount = 0;
    }
} else {
    $fullName = 'Guest';
    $productCount = 0;
}

// Logout functionality
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin_signup.php");
    exit();
}

// Fetching the message if exists
$message = isset($_GET['message']) ? $_GET['message'] : '';
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="admin.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px; /* Adjusted font size */
        }
        .values, .additional-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 10px; /* Reduced gap */
            justify-content: center;
        }
        .val-box, .card {
            flex: 1 1 250px; /* Adjusted flex basis */
            max-width: 250px; /* Adjusted max width */
            padding: 10px; /* Reduced padding */
            margin: 5px; /* Reduced margin */
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); /* Reduced shadow */
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .val-box i, .card i {
            font-size: 1.5em; /* Adjusted icon size */
            margin-bottom: 5px; /* Reduced margin */
        }
        .val-box h3, .card h3 {
            margin: 0;
            font-size: 1.2em; /* Adjusted font size */
        }
        .val-box span, .card p {
            font-size: 0.9em; /* Adjusted font size */
            color: #666;
        }
        .board {
            width: 100%;
            max-width: 1200px; /* Set a maximum width for the container */
            margin: 0 auto; /* Center the container */
            overflow-x: auto;
            margin-bottom: 40px; /* Add margin-bottom to create distance between tables */
        }
        table {
            width: 100%;
            max-width: 100%; /* Ensure the table does not exceed the container width */
            border-collapse: collapse;
        }
        table th, table td {
            padding: 8px; /* Reduced padding */
            border: 1px solid #ccc;
            text-align: left;
        }
        .additional-cards {
            width: 100%;
            max-width: 1200px; /* Set a maximum width for the container */
            margin: 0 auto; /* Center the container */
            display: flex;
            gap: 0; /* Remove gap */
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .additional-cards .card {
            flex: 1; /* Make each card take up equal space */
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
            width: 100%; /* Ensure each card takes up full width */
            height: 400px; /* Set height to 400px */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .profile {
            position: relative;
            display: inline-block;
        }
        .profile .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }
        .profile .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .profile .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        .profile:hover .dropdown-content {
            display: block;
        }
    </style>
    <title>CH Lumberyard Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<!-- Header Section -->
<section id="menu">
    <div class="logo">
        <img src="LOGO-removebg-preview.png" alt="CH Lumber">
        <h2>CH Lumber</h2>
        <i id="menu-btn" class="fa-solid fa-bars"></i> <!-- Move the button here -->
    </div>
    <div class="items">
        <li><i class="fa-solid fa-house"></i><a href="admin.php">Dashboard</a></li>
        <li><i class="fa-solid fa-cart-plus"></i><a href="insert_product.php">Products</a></li>
        <li><i class="fa-solid fa-cart-shopping"></i><a href="product.php">Listed Products</a></li>
        <li><i class="fa-regular fa-user"></i><a href="user.php">Users</a></li>
        <li><i class="fa-solid fa-user-secret"></i><a href="seller.php">Sellers</a></li>
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
                    <input type="text" name="search_term" placeholder="Search names, products, or status" value="<?php echo htmlspecialchars($searchTerm); ?>" />
                    <button class="search_button" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
        </div>
        <div class="profile">
            <i class="fa-solid fa-bell"></i>
            <img src="penguin.avif" alt="Profile Picture">
            <div class="dropdown-content">
                <a href="profile.php">Profile</a>
                <a href="?logout=true">Logout</a>
            </div>
        </div>
    </div>
    <h3 class="i-name"></h3>
    <h3 class="i-name">Welcome  <?php echo $fullName; ?></h3>
    
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
                <span>user Sales</span>
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
        <div class="val-box subscription">
            <i class="fa-solid fa-envelope"></i>
            <div>
                <h3><?php echo $subscriptionCount; ?></h3>
                <span>Total Subscriptions</span>
            </div>
        </div>
        <div class="val-box subscription-income">
            <i class="fa-solid fa-dollar-sign"></i>
            <div>
                <h3><?php echo number_format($subscriptionIncome, 2); ?></h3>
                <span>Subscription Income</span>
            </div>
        </div>
    </div>

    <div class="additional-cards" style="display: flex; gap: 10px; margin-top: 20px; margin-bottom: 20px; max-width: 1200px;">
        <div class="card" style="flex: 1; padding: 15px; margin: 0 20px; border: 1px solid #ccc; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); background-color: #f9f9f9; height: 400px; width: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
            <h3>Transaction Status</h3>
            <canvas id="statusPieChart" width="200" height="200"></canvas>
        </div>
        <div class="card" style="flex: 1; padding: 15px; margin: 0 20px; border: 1px solid #ccc; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); background-color: #f9f9f9; height: 400px; width: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
            <h3>Subscription Types</h3>
            <canvas id="subscriptionBarChart" width="400" height="400"></canvas>
        </div>
    </div>

    <div class="board">
        <h1>Orders</h1>
        <table width="100%">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Actions</th>
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
                                    <button class='edit-btn' onclick='openEditModal({$order['order_id']})'>Edit</button>
                                    <a href='?delete_order_id={$order['order_id']}' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this order?\");'>Delete</a>
                                    <button class='view-btn' onclick='openModal({$order['order_id']})'>View</button>
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

    <div class="board">
        <h1>Subscribers</h1>
        <table width="100%">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Subscription Type</th>
                    <th>Subscription Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($subscribersQuery && mysqli_num_rows($subscribersQuery) > 0) {
                    while ($subscriber = mysqli_fetch_assoc($subscribersQuery)) {
                        echo "<tr>
                                <td>{$subscriber['firstName']}</td>
                                <td>{$subscriber['lastName']}</td>
                                <td>{$subscriber['subscription_type']}</td>
                                <td>" . number_format($subscriber['subscription_price'], 2) . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No subscribers found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- The View Modal -->
    <div id="orderModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div id="modalContent"></div>
        </div>
    </div>

    <!-- The Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <div id="editModalContent"></div>
        </div>
    </div>

    <script>
        function openModal(orderId) {
            // Fetch order details using AJAX
            fetch(`get_order_details.php?order_id=${orderId}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('modalContent').innerHTML = data;
                    document.getElementById('orderModal').style.display = "block";
                });
        }

        function closeModal() {
            document.getElementById('orderModal').style.display = "none";
        }

        function openEditModal(orderId) {
            // Fetch order edit form using AJAX
            fetch(`edit_order_form.php?order_id=${orderId}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('editModalContent').innerHTML = data;
                    document.getElementById('editModal').style.display = "block";
                });
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('orderModal')) {
                document.getElementById('orderModal').style.display = "none";
            }
            if (event.target == document.getElementById('editModal')) {
                document.getElementById('editModal').style.display = "none";
            }
        }

        const ctx = document.getElementById('statusPieChart').getContext('2d');
        const statusPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_keys($statusCounts)); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_values($statusCounts)); ?>,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4CAF50'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                }
            }
        });

        const ctx2 = document.getElementById('subscriptionBarChart').getContext('2d');
        const subscriptionBarChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_keys($subscriptionCounts)); ?>,
                datasets: [{
                    label: 'Subscription Count',
                    data: <?php echo json_encode(array_values($subscriptionCounts)); ?>,
                    backgroundColor: <?php echo json_encode($barColors); ?>,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Subscription Type'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Count'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
