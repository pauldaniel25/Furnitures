<?php
session_start();
include('../includes/connect.php');
include('seller.class.php');

// Initialize SellerDashboard class
$sellerDashboard = new SellerDashboard($conn);

// Check if the session email variable is set
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $seller_id = $_SESSION['seller_id'];

    // Fetch user details and subscription status
    $sellerDetails = $sellerDashboard->getSellerDetails($email);
    if ($sellerDetails) {
        $fullName = $sellerDetails['firstName'] . ' ' . $sellerDetails['lastName'];
        $current_subscription_id = $sellerDetails['subscription_id'];

        // Fetch the current subscription details
        $current_subscription_name = $sellerDashboard->getSubscriptionName($current_subscription_id);

        // Handle subscription insertion
        if (isset($_POST['insert_subscription'])) {
            $subscription_id = $_POST['subscription'];

            if ($sellerDashboard->updateSubscription($seller_id, $subscription_id)) {
                echo "<script>alert('Subscription updated successfully');</script>";
                header('Location: Subscription.php');
                exit();
            } else {
                echo "<script>alert('Error updating subscription');</script>";
            }
        }

        // Handle subscription cancellation
        if (isset($_POST['cancel_subscription'])) {
            if ($sellerDashboard->updateSubscription($seller_id, null)) {
                echo "<script>alert('Subscription cancelled successfully');</script>";
                header('Location: Subscription.php');
                exit();
            } else {
                echo "<script>alert('Error cancelling subscription');</script>";
            }
        }
    } else {
        $fullName = 'Guest';
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="style.css">
    <title>CH Lumberyard Admin - Subscription</title>
    <style>
        /* Modal Styles for Subscription - Centered */
        .modal-dialog {
            max-width: 500px;
            margin: 0 auto; /* Center the modal horizontally */
        }

        .modal-content {
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            text-align: center;
            border-bottom: none;
        }

        .modal-title {
            font-size: 24px;
            font-weight: bold;
        }

        .modal-body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .modal-footer {
            display: flex;
            justify-content: center; /* Center the button horizontally */
            padding-top: 10px;
            border-top: none;
        }

        .modal-footer .btn {
            margin-top: 10px; /* Add some spacing above the button */
        }

        /* Optional: If you'd like to override default styles for the subscription form */
        .form-outline {
            margin-bottom: 20px;
        }

        .form-outline input,
        .form-outline select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>

<!-- Sidebar Section (Retained Original) -->
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
    <h3 class="i-name"><?php echo $fullName; ?></h3>


    <!-- Subscription Modal -->
    <div class="modal" tabindex="-1" id="subscriptionModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Manage Subscription</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="form-outline mb-3">
                            <label for="subscription" class="form-label">Select Subscription Type</label>
                            <select name="subscription" id="subscription" class="form-select" required>
                                <option value="" disabled selected>Select your subscription</option>
                                <?php
                                // Fetch available subscriptions
                                $subscriptions = $sellerDashboard->getAllSubscriptions();
                                foreach ($subscriptions as $subscription) {
                                    echo "<option value='{$subscription['id']}'>{$subscription['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Display current subscription (if any) -->
                        <?php if ($current_subscription_name): ?>
                            <div class="alert alert-info">
                                <strong>Current Subscription:</strong> <?php echo $current_subscription_name; ?>
                            </div>
                        <?php endif; ?>

                        <button type="submit" name="insert_subscription" class="btn btn-primary">Apply Subscription</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <?php if ($current_subscription_name): ?>
                        <form action="" method="post" onsubmit="return confirmCancel();">
                            <button type="submit" name="cancel_subscription" class="btn btn-danger">Cancel Subscription</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<!-- Footer Section -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.49.0/apexcharts.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function confirmCancel() {
        return confirm('Are you sure you want to cancel your subscription?');
    }
</script>



</body>
</html>

</section>

<!-- Footer Section -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.49.0/apexcharts.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>



</body>
</html>
