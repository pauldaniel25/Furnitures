<?php
session_start();

if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success text-center">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../vendor/bootstrap-5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendor//bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../vendor/datatable-2.1.8/datatables.min.css" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="Dashboard.css">
    <link rel="stylesheet" href="includes/header.css">
</head>

<!-- body -->
<body>
    
<!-- header here -->
<?php
require_once 'includes/header.php';
?>
<!-- modal here -->
<div class="modal-container"></div>


<div class="bg-light text-center">
    <h3>BEST SELLING FURNITURE</h3>
    <p>Buy what you need</p>
</div>

<!-- Products Display -->
<div class="row p-3">
    <div class="col-md-10 mx-auto">
        <div class="row">
        <?php
        foreach ($array as $arr) {
        ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="../seller/product_images2/<?= $arr['product_image1']?>" class="card-img-top" alt="Product Image">
                    <div class="card-body">
                        <h5 class="card-title"><?= $arr['product_name'] ?></h5>
                        <p class="card-text"><?= htmlspecialchars($productobj->truncateDescription($arr['product_description'], 30)) ?></p>
                        <p class="card-text"><strong>Price:</strong> $<?= $arr['product_price'] ?></p>
                        <p class="card-text"><strong>Category:</strong> <?= $arr['Category'] ?></p>
                        <p class="card-text"><strong>Status:</strong> <?= htmlspecialchars($arr['status']) ?></p>
                        <button type="button" class="btn add-cart-btn btn-custom" data-id="<?= $arr['product_id'] ?>" id="add-to-cart" >Add to Cart</button>
                        <a href="view.php?id=<?= $arr['product_id']?>" class="btn btn-custom">View Product</a>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
        </div>
    </div>
</div>
<?php
 require_once 'includes/footer.php';
 ?>
<script src="ajax.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
