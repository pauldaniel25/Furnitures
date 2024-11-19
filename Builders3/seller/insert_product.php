<?php
include('../includes/connect.php');
session_start();

// Check if seller is logged in
if (!isset($_SESSION['seller_id'])) {
    die("Seller not logged in.");
}

$seller_id = $_SESSION['seller_id'];


if (isset($_POST['insert_product'])) {
    // Retrieve form data
    $product_title = $_POST['product_title'];
    $product_description = $_POST['product_description'];
    $product_keywords = $_POST['product_keywords'];
    $product_category = $_POST['product_category'];
    $product_image1 = $_FILES['product_image1']['name'];
    $product_image2 = $_FILES['product_image2']['name'];
    $product_image3 = $_FILES['product_image3']['name'];
    $product_price = $_POST['product_price'];
    $product_status = 'true';

    // Temporary file names
    $temp_image1 = $_FILES['product_image1']['tmp_name'];
    $temp_image2 = $_FILES['product_image2']['tmp_name'];
    $temp_image3 = $_FILES['product_image3']['tmp_name'];

    // Validation
    if (empty($product_title) || empty($product_description) || empty($product_keywords) || 
        empty($product_category) || empty($product_image1) || empty($product_image2) || 
        empty($product_image3) || empty($product_price)) {
        echo "<script>alert('All fields are required to be filled');</script>";
        exit();
    } else {
        // Move uploaded files
        move_uploaded_file($temp_image1, "./product_images2/$product_image1");
        move_uploaded_file($temp_image2, "./product_images2/$product_image2");
        move_uploaded_file($temp_image3, "./product_images2/$product_image3");

        // Insert product into the database
        $insert_products = "INSERT INTO `products` (product_name, product_description, product_keywords, 
            category_id, product_image1, product_image2, product_image3, product_price, seller_id, date, status) 
            VALUES ('$product_title', '$product_description', '$product_keywords', '$product_category', 
            '$product_image1', '$product_image2', '$product_image3', '$product_price', '$seller_id', NOW(), '$product_status')";

        $result_query = mysqli_query($conn, $insert_products);

        if ($result_query) {
            header("Location: seller.php");
        } else {
            echo "<script>alert('Error inserting product: " . mysqli_error($conn) . "');</script>";
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
 <!--font awesome cdn-->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 <!--css link-->
 <link rel="stylesheet" href="../style.css">
</head>
<body class="bg_light">
    <div class="container">

        <h1 class="text-center mt-3">Insert Products</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <!-- Product Title -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_title" class="form-label">Product Title</label>
                <input type="text" name="product_title" id="product_title" class="form-control" placeholder="Enter product name"
                       autocomplete="off" required>
            </div>

            <!-- Product Description -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_description" class="form-label">Product Description</label>
                <input type="text" name="product_description" id="product_description" class="form-control" placeholder="Enter product description"
                       autocomplete="off" required>
            </div>

            <!-- Product Keywords -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_keywords" class="form-label">Product Keywords</label>
                <input type="text" name="product_keywords" id="product_keywords" class="form-control" placeholder="Enter product keywords"
                       autocomplete="off" required>
            </div>

            <!-- Product Category -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_category" class="form-label">Product Category</label>
                <select name="product_category" class="product_category form-select" required>
                    <option value="" disabled selected>Select Category</option>
                    <?php 
                    $select_query = "SELECT * FROM `categories`";
                    $result_query = mysqli_query($conn, $select_query);
                    while ($row = mysqli_fetch_assoc($result_query)) {
                        $category_title = $row['category_title'];
                        $category_id = $row['category_id'];
                        echo "<option value='$category_id'>$category_title</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Product Images -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image1" class="form-label">Image 1</label>
                <input type="file" name="product_image1" id="product_image1" class="form-control" required>
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image2" class="form-label">Image 2</label>
                <input type="file" name="product_image2" id="product_image2" class="form-control" required>
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image3" class="form-label">Image 3</label>
                <input type="file" name="product_image3" id="product_image3" class="form-control" required>
            </div>

            <!-- Product Price -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_price" class="form-label">Product Price</label>
                <input type="number" name="product_price" id="product_price" class="form-control" placeholder="Enter product price"
                       step="0.01" autocomplete="off" required>
            </div>

            <!-- Submit Button -->
                <div class="form-outline mb-4 w-50 m-auto">
                    <input type="submit" name="insert_product" class="btn btn-info mb-3 px-3" value="Insert Product">
                </div>

        </form>
    </div>
</body>
</html>
