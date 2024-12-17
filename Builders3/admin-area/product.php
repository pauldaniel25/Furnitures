<?php
session_start();
include('../includes/connect.php');

// Check if the session email variable is set
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $admin_id = $_SESSION['admin_id'];

    // Fetch admin details from the database
    $query = mysqli_query($conn, "SELECT * FROM `admin` WHERE email='$email'");

    if ($query && mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_array($query);
        $fullName = $row['firstName'] . ' ' . $row['lastName'];

        // Fetch all products for all sellers
        $productQuery = mysqli_query($conn, "
            SELECT p.product_id, p.product_name, p.product_description, p.product_price, p.product_image1, 
                   c.category_title, s.firstName, s.lastName 
            FROM products p 
            JOIN categories c ON p.category_id = c.category_id 
            JOIN seller s ON p.seller_id = s.id
        ");
    } else {
        $fullName = 'Admin not found';
        $productQuery = [];
    }
} else {
    $fullName = 'Guest'; // Default if not logged in
    $productQuery = [];
}

// Handle product deletion
if (isset($_GET['delete_product_id'])) {
    $product_id = $_GET['delete_product_id'];
    $deleteQuery = "DELETE FROM products WHERE product_id='$product_id'";

    if (mysqli_query($conn, $deleteQuery)) {
        header("Location: listedproduct.php?message=Product deleted successfully.");
        exit();
    } else {
        $message = "Error deleting product: " . mysqli_error($conn);
    }
}

// Fetching the message if exists
$message = isset($_GET['message']) ? $_GET['message'] : '';
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="admin.css">
    <title>CH Lumberyard Admin</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn-group {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .edit-btn, .delete-btn, .view-btn {
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
        }
        .edit-btn {
            background-color: #4CAF50;
        }
        .delete-btn {
            background-color: #f44336;
        }
        .view-btn {
            background-color: #2196F3;
        }
        .alert {
            color: red;
            font-weight: bold;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.8);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 60%;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .modal-content h2 {
            margin-top: 0;
        }
        .modal-content p {
            margin: 10px 0;
        }
        .modal-content img {
            display: block;
            margin: 20px auto;
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .modal-content form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .modal-content form input, .modal-content form textarea, .modal-content form select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
        }
        .modal-content form button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        .modal-content form button:hover {
            background-color: #45a049;
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
        <li><i class="fa-solid fa-house"></i></i><a href="admin.php">Dashboard</a></li>
        <li><i class="fa-solid fa-cart-plus"></i><a href="insert_product.php">Products</a></li>
        <li><i class="fa-solid fa-cart-shopping"></i><a href="product.php">Listed Products</a></li>
        <li><i class="fa-regular fa-user"></i><a href="user.php">Users</a></li>
        <li><i class="fa-solid fa-user-secret"></i><a href="seller.php">Sellers</a></li>
        <li><i class="fa-solid fa-arrow-right-from-bracket"></i><a href="logout.php">Logout</a></li>
    </div>
</section>

<!-- Main Content Section -->
<section id="interface">
    <h3 class="i-name"><?php echo $fullName; ?></h3>
    
    <?php if ($message): ?>
        <div class="alert"><?php echo $message; ?></div>
    <?php endif; ?>

    <div class="board">
        <h3>All Listed Products</h3>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Seller</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($productQuery && mysqli_num_rows($productQuery) > 0) {
                    while ($product = mysqli_fetch_assoc($productQuery)) {
                        echo "<tr>
                                <td>{$product['product_name']}</td>
                                <td>{$product['product_description']}</td>
                                <td>{$product['category_title']}</td>
                                <td>{$product['firstName']} {$product['lastName']}</td>
                                <td><img src='./product_images2/{$product['product_image1']}' alt='Product Image' width='100'></td>
                                <td>{$product['product_price']}</td>
                                <td>
                                    <div class='btn-group'>
                                        <button class='edit-btn' onclick='openEditModal({$product['product_id']})'>Edit</button>
                                        <a href='listedproduct.php?delete_product_id={$product['product_id']}' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this product?\");'>Delete</a>
                                        <button class='view-btn' onclick='openViewModal({$product['product_id']})'>View</button>
                                    </div>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No products found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</section>

<!-- View Modal -->
<div id="viewModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('viewModal')">&times;</span>
        <h2>Product Details</h2>
        <div id="view-modal-body">
            <!-- Product details will be loaded here via JavaScript -->
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('editModal')">&times;</span>
        <h2>Edit Product</h2>
        <div id="edit-modal-body">
            <!-- Edit form will be loaded here via JavaScript -->
        </div>
    </div>
</div>

<script>
function openViewModal(productId) {
    // Fetch product details using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "fetch_product_details.php?product_id=" + productId, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("view-modal-body").innerHTML = xhr.responseText;
            document.getElementById("viewModal").style.display = "block";
        }
    };
    xhr.send();
}

function openEditModal(productId) {
    // Fetch product edit form using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "fetch_edit_form.php?product_id=" + productId, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("edit-modal-body").innerHTML = xhr.responseText;
            document.getElementById("editModal").style.display = "block";
        }
    };
    xhr.send();
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
}
</script>

</body>
</html>
