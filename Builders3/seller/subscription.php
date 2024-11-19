<?php
session_start();
include('../includes/connect.php');

// Initialize subscription status
$isSubscribed = false;

// Check if the session email variable is set
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $seller_id = $_SESSION['seller_id'];

    // Fetch user details
    $query = mysqli_query($conn, "SELECT * FROM `seller` WHERE `email`='$email'");
    
    if ($query && mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_array($query);
        $fullName = $row['firstName'] . ' ' . $row['lastName'];
        $current_subscription_id = $row['subscription_id'];

        // Check if current subscription ID is valid
        if ($current_subscription_id) {
            $subscription_query = mysqli_query($conn, "SELECT * FROM `subscription` WHERE `id`='$current_subscription_id'");
            if ($subscription_query && mysqli_num_rows($subscription_query) > 0) {
                $subscription_details = mysqli_fetch_array($subscription_query);
                $current_subscription_name = $subscription_details['name'];
                $isSubscribed = true;
            } else {
                $current_subscription_name = null;
            }
        } else {
            $current_subscription_name = null;
        }

    } else {
        $fullName = 'User not found';
        $current_subscription_name = null;
    }

    // Handle subscription insertion
    if (isset($_POST['insert_subscription'])) {
        $subscription_id = $_POST['subscription'];

        // Validation
        if (empty($subscription_id)) {
            echo "<script>alert('Please select a subscription type');</script>";
            exit();
        }
        
        // Update the seller's subscription_id
        $update_subscription = "UPDATE `seller` SET subscription_id='$subscription_id' WHERE id='$seller_id'";

        if (mysqli_query($conn, $update_subscription)) {
            echo "<script>alert('Subscription updated successfully');</script>";
            // Fetch the updated seller details
            $query = mysqli_query($conn, "SELECT * FROM `seller` WHERE `email`='$email'");
            if ($query && mysqli_num_rows($query) > 0) {
                $row = mysqli_fetch_array($query);
                $isSubscribed = !is_null($row['subscription_id']);
                $current_subscription_name = $row['subscription_id'] ? $subscription_details['name'] : null;
            }
            header('Location: Dashboard.php');
            exit(); 
        }
       else {
            echo "<script>alert('Error updating subscription: " . mysqli_error($conn) . "');</script>";
        }
    }
} else {
    $fullName = 'Guest';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <title>CH Lumberyard Admin - Subscription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h3 {
            text-align: center;
            color: #333;
        }
        .form-outline {
            margin-bottom: 20px;
        }
        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .btn {
            background: #28a745;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        .btn:hover {
            background: #218838;
        }
        .disabled {
            color: gray;
            cursor: not-allowed;
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
        <li><i class="fa-solid fa-chart-pie"></i><a href="seller.php">Dashboard</a></li>
        <?php if ($isSubscribed): ?>
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
    <h3 class="i-name"><?php echo $fullName; ?></h3>
    
    <div class="container">
        <h1> Subscription Type</h1>
        <?php if ($current_subscription_name): ?>
            <h4>Current Subscription: <?php echo $current_subscription_name; ?></h4>
        <?php else: ?>
            <form action="" method="post">
                <div class="form-outline">
                    <label for="subscription" class="form-label">Subscription type</label>
                    <select name="subscription" required>
                        <option value="" disabled selected>Select subscription</option>
                        <?php 
                        $select_query = "SELECT * FROM `subscription`";
                        $result_query = mysqli_query($conn, $select_query);
                        if ($result_query) {
                            while ($row = mysqli_fetch_assoc($result_query)) {
                                $subscription_title = $row['name'];
                                $subscription_id = $row['id'];
                                echo "<option value='$subscription_id'>$subscription_title</option>";
                            }
                        } else {
                            echo "Error fetching subscriptions: " . mysqli_error($conn);
                        }
                        ?>
                    </select>
                </div>
                <div class="form-outline">
                    <input type="submit" name="insert_subscription" class="btn" value="Apply Subscription">
                </div>
            </form>
        <?php endif; ?>
    </div>
</section>

<!-- Footer Section -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.49.0/apexcharts.min.js"></script>
</body>
</html>
