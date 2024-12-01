<?php
session_start();
include('../includes/connect.php');
include('seller.class.php');

// Initialize the SellerDashboard class
$sellerDashboard = new SellerDashboard($conn);

// Handle delete request
if (isset($_GET['delete_product_id'])) {
    $productId = $_GET['delete_product_id'];

    // Call the delete method
    if ($sellerDashboard->deleteProduct($productId)) {
        // Redirect to refresh the page
        header("Location: listedproduct.php");
        exit();
    } else {
        echo "Failed to delete the product.";
    }
}

// Handle edit request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product'])) {
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $productDescription = $_POST['product_description'];
    $productPrice = $_POST['product_price'];
    $categoryId = $_POST['category_id'];

    // Handle image upload if a new image is provided
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $imageName = uniqid('', true) . '.' . strtolower(pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION));
        $uploadPath = 'product_images2/' . $imageName;
    
        // Move the uploaded image to the correct folder
        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $uploadPath)) {
            // Call editProduct with the image name
            $sellerDashboard->editProduct($productId, $productName, $productDescription, $productPrice, $categoryId, $imageName);
        } else {
            echo "Image upload failed.";
        }
    } else {
        // Call editProduct without the image
        $sellerDashboard->editProduct($productId, $productName, $productDescription, $productPrice, $categoryId);
    }
    

    header("Location: listedproduct.php"); // Redirect after successful update
    exit;
}

// Fetch user and product data
$fullName = 'Guest';
$isSubscribed = false;
$products = [];

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $sellerId = $_SESSION['seller_id'];

    // Fetch user details
    $userDetails = $sellerDashboard->getSellerDetails($email);
    if ($userDetails) {
        $fullName = $userDetails['firstName'] . ' ' . $userDetails['lastName'];
        $isSubscribed = !is_null($userDetails['subscription_id']);
        // Fetch products for the seller
        $products = $sellerDashboard->getProductsBySeller($sellerId);
    } else {
        $fullName = 'User not found';
        $isSubscribed = false; // Default to false if user not found
    }
} else {
    $fullName = 'Guest'; // Default if not logged in
    $isSubscribed = false; // Default to false for guest
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
        <?php if ($isSubscribed): ?>
            <li><i class="fa-solid fa-chart-pie"></i><a href="insert_product.php">Create Listing</a></li>
        <?php else: ?>
            <li><i class="fa-solid fa-chart-pie"></i><a href="#" style="color:gray; cursor:not-allowed;" title="You must subscribe to add a product">Create Listing (Unavailable)</a></li>
        <?php endif; ?>
        <li><i class="fa-solid fa-chart-pie"></i><a href="listedproduct.php">Listed Products</a></li>
        <li><i class="fa-solid fa-chart-pie"></i><a href="Subscription.php">Subscription</a></li>
        <li><i class="fa-solid fa-chart-pie"></i><a href="logout.php">Logout</a></li>
    </div>
</section>

<!-- Main Content Section -->
<section id="interface">
    <h3 class="i-name"><?php echo $fullName; ?></h3> <!-- Display user name -->

    <div class="board">
        <h3>Your Products</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>Product Name</td>
                    <td>Description</td>
                    <td>Category</td>
                    <td>Image</td>
                    <td>Price</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo $product['product_name']; ?></td>
                            <td><?php echo $product['product_description']; ?></td>
                            <td><?php echo $product['category_title']; ?></td>
                            <td><img src="./product_images2/<?php echo $product['product_image1']; ?>" alt="Product Image" width="100"></td>
                            <td><?php echo $product['product_price']; ?></td>
                            <td>
                                <!-- Edit Button -->
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal" 
    data-id="<?php echo $product['product_id']; ?>"
    data-name="<?php echo $product['product_name']; ?>"
    data-description="<?php echo $product['product_description']; ?>"
    data-price="<?php echo $product['product_price']; ?>"
    data-category="<?php echo $product['category_title']; ?>"
    data-image="product_images2/<?php echo $product['product_image1']; ?>"> <!-- Add data-image attribute -->
    Edit
</button>


                                <!-- View Button -->
                                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewModal" 
                                    data-id="<?php echo $product['product_id']; ?>"
                                    data-name="<?php echo $product['product_name']; ?>"
                                    data-description="<?php echo $product['product_description']; ?>"
                                    data-price="<?php echo $product['product_price']; ?>"
                                    data-category="<?php echo $product['category_title']; ?>"
                                    data-image="<?php echo './product_images2/'.$product['product_image1']; ?>">
                                    View
                                </button>
                                
                                <!-- Delete Button -->
                                <a href="listedproduct.php?delete_product_id=<?php echo $product['product_id']; ?>" 
                                    class="btn btn-danger" 
                                    onclick="return confirm('Are you sure you want to delete this product?');">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6">No products found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="viewModalLabel">View Product Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="card" style="width: 18rem;">
                <img id="view-product-image" class="card-img-top" alt="Product Image">
                <div class="card-body">
                    <h5 id="view-product-name" class="card-title">Card title</h5>
                    <p id="view-product-description" class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Price: $<span id="view-product-price"></span></li>
                    <li class="list-group-item">Category: <span id="view-product-category"></span></li>
                </ul>
              
            </div>
        </div>
    </div>
  </div>
</div>

<!-- Edit Modal (Existing) -->
<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="listedproduct.php" enctype="multipart/form-data">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="product_id" id="product_id">
                
                <!-- Product Name -->
                <div class="mb-3">
                    <label for="product_name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" required>
                </div>

                <!-- Product Description -->
                <div class="mb-3">
                    <label for="product_description" class="form-label">Description</label>
                    <textarea class="form-control" id="product_description" name="product_description" required></textarea>
                </div>

                <!-- Product Price -->
                <div class="mb-3">
                    <label for="product_price" class="form-label">Price</label>
                    <input type="number" step="0.01" class="form-control" id="product_price" name="product_price" required>
                </div>

                <!-- Category -->
                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-select" id="category_id" name="category_id" required>
                        <?php
                        $categories = $sellerDashboard->getCategories();
                        foreach ($categories as $category) {
                            echo "<option value='{$category['category_id']}'>{$category['category_title']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Product Image -->
                <div class="mb-3">
                    <label for="product_image" class="form-label">Product Image</label>
                    <div>
                        <img id="edit-product-image" src="" alt="Product Image" width="100" class="mb-2">
                    </div>
                    <input type="file" class="form-control" id="product_image" name="product_image">
                    <small class="text-muted">Leave empty if you don't want to change the image</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="edit_product" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </form>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const viewModal = document.getElementById('viewModal');
    viewModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        document.getElementById('view-product-image').src = button.getAttribute('data-image');
        document.getElementById('view-product-name').innerText = button.getAttribute('data-name');
        document.getElementById('view-product-description').innerText = button.getAttribute('data-description');
        document.getElementById('view-product-price').innerText = button.getAttribute('data-price');
        document.getElementById('view-product-category').innerText = button.getAttribute('data-category');
    });


    const editModal = document.getElementById('editModal');
editModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget; // Button that triggered the modal

    // Populate the modal fields with the data
    document.getElementById('product_id').value = button.getAttribute('data-id');
    document.getElementById('product_name').value = button.getAttribute('data-name');
    document.getElementById('product_description').value = button.getAttribute('data-description');
    document.getElementById('product_price').value = button.getAttribute('data-price');
    document.getElementById('category_id').value = button.getAttribute('data-category');

    // Set the product image (if available)
    const imageSrc = button.getAttribute('data-image'); // Assuming you are passing the image URL as a data attribute
    document.getElementById('edit-product-image').src = imageSrc;
});

</script>

</body>
</html>

