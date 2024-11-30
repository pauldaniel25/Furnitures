
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="../vendor/bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendor/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../vendor/datatable-2.1.8/datatables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="includes/header.css">
</head>

<body>
<?php require_once 'includes/header.php'; ?>
<div class="container">
    <h1>My Orders</h1>
    <div class="order-list">
        <table id="order-table" class="table table-striped">
            <thead>
                <tr>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Date Ordered</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($array as $arr) { ?>
                <tr>
                    <td><img src="../seller/product_images2/<?= $arr['product_image1']?>" alt="Product Image" class="product-image"></td>
                    <td><?= $arr['product_name']?></td>
                    <td>24-9-2024</td>
                    <td>$100</td>
                    <td>Pending</td>
                    <td>
                        <button class="btn-cancel">Cancel</button>
                        <button class="btn-view">View Details</button>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>