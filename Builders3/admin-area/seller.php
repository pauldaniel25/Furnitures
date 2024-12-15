<?php
include('../includes/connect.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

// Handle seller deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['seller_id'])) {
    $seller_id = $_POST['seller_id'];

    // Prepare the delete query
    $deleteQuery = "DELETE FROM `seller` WHERE id='$seller_id'";

    // Execute the query
    if (mysqli_query($conn, $deleteQuery)) {
        // Optionally set a success message
        $message = "Seller deleted successfully.";
    } else {
        $message = "Error deleting seller: " . mysqli_error($conn);
    }
}

// Handle seller approval
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve_seller_id'])) {
    $seller_id = $_POST['approve_seller_id'];

    // Update the seller status to approved
    $approveQuery = "UPDATE `seller` SET `status` = 'approved' WHERE `id` = '$seller_id'";

    if (mysqli_query($conn, $approveQuery)) {
        $message = "Seller approved successfully.";
    } else {
        $message = "Error approving seller: " . mysqli_error($conn);
    }
}

// Handle seller rejection
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reject_seller_id'])) {
    $seller_id = $_POST['reject_seller_id'];

    // Update the seller status to rejected
    $rejectQuery = "UPDATE `seller` SET `status` = 'rejected' WHERE `id` = '$seller_id'";

    if (mysqli_query($conn, $rejectQuery)) {
        $message = "Seller rejected successfully.";
    } else {
        $message = "Error rejecting seller: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
    <title>Manage Sellers</title>
    <style>
        .alert {
            padding: 10px;
            background-color: #f44336;
            color: white;
            margin-bottom: 15px;
            text-align: center;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .btn-approve {
            background-color: #4CAF50;
        }
        .btn-reject {
            background-color: #f44336;
        }
        .btn-delete {
            background-color: #ff9800;
        }
        .btn-approve:hover {
            background-color: #45a049;
        }
        .btn-reject:hover {
            background-color: #e53935;
        }
        .btn-delete:hover {
            background-color: #fb8c00;
        }
    </style>
</head>
<body>

<!-- Header Section -->
<section id="menu">
    <div class="logo">
        <img src="LOGO-removebg-preview.png" alt="CH Lumber">
        <h2>CH Lumber</h2>
    </div>
    <div class="items">
        <li><i class="fa-solid fa-house"></i><a href="admin.php">Dashboard</a></li>
        <li><i class="fa-solid fa-cart-plus"></i><a href="insert_product.php">Products</a></li>
        <li><i class="fa-solid fa-cart-shopping"></i><a href="product.php">Listed Products</a></li>
        <li><i class="fa-regular fa-user"></i><a href="user.php">Users</a></li>
        <li><i class="fa-solid fa-user-secret"></i><a href="seller.php">Sellers</a></li>
        <li><i class="fa-solid fa-arrow-right-from-bracket"></i><a href="logout.php">Logout</a></li>
    </div>
</section>

<!-- Main Content Section -->
<section id="interface">
    <h3>Manage Sellers</h3>
    
    <?php if (isset($message)): ?>
        <div class="alert">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Subscription Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT s.id, s.firstName, s.lastName, s.email, s.created_at, 
                             COALESCE(sub.name, 'No Subscription') AS subscription_name 
                      FROM seller s 
                      LEFT JOIN subscription sub ON s.subscription_id = sub.id";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['firstName']}</td>";
                echo "<td>{$row['lastName']}</td>";
                echo "<td>{$row['email']}</td>";
                echo "<td>{$row['created_at']}</td>";
                echo "<td>{$row['subscription_name']}</td>";
                echo "<td>
                        <form method='POST' style='display:inline-block;'>
                            <input type='hidden' name='approve_seller_id' value='{$row['id']}'>
                            <button type='submit' class='btn btn-approve'>Approve</button>
                        </form>
                        <form method='POST' style='display:inline-block;'>
                            <input type='hidden' name='reject_seller_id' value='{$row['id']}'>
                            <button type='submit' class='btn btn-reject'>Reject</button>
                        </form>
                        <form method='POST' style='display:inline-block;'>
                            <input type='hidden' name='seller_id' value='{$row['id']}'>
                            <button type='submit' class='btn btn-delete'>Delete</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</section>

</body>
</html>
