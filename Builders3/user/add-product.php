<?php
session_start();
// Add the necessary includes
require_once('function.php');
require_once('classes.php');

$product_id = $_GET['id'] ?? null;  // Get the product ID from the query string

// Initialize product variables
 $product_name = $product_image1 = $product_price = ''; 

if ($product_id) {
    $prodobj = new Product();
    $record = $prodobj->fetchRecord($product_id);  // Fetch the product record from DB

    if (!empty($record)) {
        $product_name = htmlspecialchars($record['product_name']);
        $product_image1 = htmlspecialchars($record['product_image1']);
        $product_price = htmlspecialchars($record['product_price']);
        $available_quantity = $record['quantity'];
    } else {
        echo 'No product found';
        exit;
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = filter_var($_POST['quantity'], FILTER_VALIDATE_INT);
    $user_id = $_SESSION['user_id'];

    if ($quantity <= 0) {
        echo 'Invalid quantity';
        exit;
    }
    
    $cart = new Cart();
    try {
        $cart->addtocart($product_id, $quantity, $user_id);
        header('Location: cart2.php');
        exit;
    } catch (Exception $e) {
        echo 'Error adding product to cart: ' . $e->getMessage();
    }
}
?>

<!-- Modal Content -->
<div class="modal fade" id="modal-add-product" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" id="form-add-product" name="form-add-product" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?= $product_id ?>">
                <div class="modal-body">
                    <div class="d-flex">
                        <!-- Left section: Product Image -->
                        <div class="modal-image-container" style="flex: 1; padding-right: 20px;">
                            <img src="../seller/product_images2/<?= $product_image1 ?>" alt="<?= $product_name ?>" class="img-fluid">
                        </div>

                        <div class="modal-details-container" style="flex: 1;">
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity (Available: <?= $available_quantity ?>)</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="<?= $available_quantity ?>">
                            </div>

                            <div class="mb-3">
                                <label for="total-price" class="form-label">Total Price</label>
                                <input type="text" class="form-control" id="total-price" name="total-price" value="$<?= number_format($product_price, 2) ?>" readonly>
                            </div>                      
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const quantityInput = document.getElementById('quantity');
const totalPriceInput = document.getElementById('total-price');
const basePrice = <?= $product_price ?>;
const availableQuantity = <?= $available_quantity ?>;

quantityInput.max = availableQuantity; // Add this line

quantityInput.addEventListener('input', updatePrice);

function updatePrice() {
    const quantity = parseInt(quantityInput.value);
    
    if (quantity > availableQuantity) {
        quantityInput.value = availableQuantity;
        alert('Quantity exceeds available stock.');
    }
    
    const totalPrice = basePrice * Math.min(quantity, availableQuantity);
    totalPriceInput.value = `$${totalPrice.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
}
</script>