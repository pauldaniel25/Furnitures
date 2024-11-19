<?php
ob_start();
session_start();
require_once('function.php');
require_once('classes.php');

$prodobj = new Product();
 $product_name =  $product_price =  
 $product_code =  $type_id =  $product_description = $product_photo = '';
 // error
 $product_nameErr =  $product_priceErr =  
 $product_codeErr =  $type_idErr = $product_descriptionErr = $product_photoErr = '';

 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = isset($_POST['product_name']) ? clean($_POST['product_name']) : '';
    $product_price = isset($_POST['product_price']) ? clean($_POST['product_price']) : '';
    $product_code = isset($_POST['product_code']) ? clean($_POST['product_code']) : '';
    $type_id = isset($_POST['type_id']) ? clean($_POST['type_id']) : '';
    $product_description = isset($_POST['product_description']) ? clean($_POST['product_description']) : '';
// empty error handlings
if (isset($_FILES['product_photo'])) {
    $product_photo = $_FILES['product_photo'];


    if ($product_photo['error'] !== UPLOAD_ERR_OK) {
        $product_photoErr = 'Error uploading photo. Please try again.';
    } else {
        // Validate the file type (e.g., allow only images)
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($product_photo['type'], $allowed_types)) {
            $product_photoErr = 'Only JPEG, PNG, and GIF files are allowed.';
        }
    }
} else {
    $product_photoErr = 'Product Photo is required';
}
if(empty($product_name)){
    $product_nameErr = 'Product Name is required';
    } 
if(empty($product_price)){
    $product_priceErr = 'Product Price is required';
    } else if (!is_numeric($product_price)){
        $product_priceErr = 'Price should be a number';
    } else if ($product_price < 1){
        $product_priceErr = 'Price must be greater than 0';
    }
if(empty($product_code)){
    $product_codeErr = 'Product Code is required';
    } else if ($prodobj->codeExists($product_code)){
        $product_codeErr = 'Product Code already exists';
    }
if(empty($type_id)){
    $type_idErr = 'Product Type is required';
    }     
if (empty($product_description)) {
    $product_descriptionErr = 'Product Description is required';
    }


    if(empty($product_nameErr) && empty($product_priceErr) && empty($product_codeErr) && empty($type_idErr) && empty($product_descriptionErr)){
        // Assign the sanitized inputs to the product object.
        $prodobj->product_code = $product_code;
        $prodobj->product_name = $product_name;
        $prodobj->type_id = $type_id;
        $prodobj->product_price = $product_price;
        $prodobj->product_description = $product_description;

        $upload_dir = 'images/'; // Directory to save the uploaded images
        $upload_file = $upload_dir .basename($_FILES['product_photo']['name']);

        if (move_uploaded_file($product_photo['tmp_name'], $upload_file)) {
            $prodobj->product_photo = $upload_file; // Save the file path to the product object
        } else {
            $product_photoErr = 'Failed to move uploaded file.';
        }
        if($prodobj->addProduct()){
            $_SESSION['success_message'] = 'Product added successfully!';
            header('Location: Dashboard.php');
            exit();
        }else {
            echo 'Something wnet wrong when adding the new product.';
        }
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Error message styling */
        .error{
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Add New Product</h2>
        <form action="" method="POST" enctype="multipart/form-data">
        <span class="error">* are required fields</span>
        
        <div class="form-group">
    <label for="product_photo">Product Photo:</label>
    <input type="file" class="form-control" id="product_photo" name="product_photo" required>
    <?php if(!empty($product_photoErr)): ?>
        <span class="error"> <?= $product_photoErr ?></span><br>
    <?php endif; ?>
</div>
            <div class="form-group">
                <label for="product_name">Product Name:</label><span class="error"> *</span>
                <input type="text" class="form-control" id="product_name" name="product_name" value="<?= $product_name ?>" required>
                <?php 
                if(!empty($product_nameErr)): ?>
                    <span class = "error"> <?= $product_nameErr ?></span><br>
                <?php endif;?>
            </div>
            <div class="form-group">
                <label for="product_price">Product Price:</label><span class="error"> *</span>
                <input type="number" step="0.01" class="form-control" id="product_price" name="product_price" value="<?= $product_price ?>" required>
                <?php 
                if(!empty($product_priceErr)): ?>
                    <span class = "error"> <?= $product_priceErr ?></span><br>
                <?php endif;?>
            </div>
            <div class="form-group">
                <label for="product_code">Product Code:</label><span class="error"> *</span>
                <input type="number" class="form-control" id="product_code" name="product_code"value="<?= $product_code ?>"  required>
                <?php 
                if(!empty($product_codeErr)): ?>
                    <span class = "error"> <?= $product_codeErr ?></span><br>
                <?php endif;?>
            </div>
            <div class="form-group">
                <label for="type_id">Type ID:</label><span class="error"> *</span>
                <input type="number" class="form-control" id="type_id" name="type_id" value="<?= $type_id ?>"  required>
                <?php 
                if(!empty($type_idErr)): ?>
                    <span class = "error"> <?= $type_idErr ?></span><br>
                <?php endif;?>
            </div>
            <div class="form-group">
                <label for="product_description">Product Description:</label>
                <textarea class="form-control" id="product_description" name="product_description" rows="4" required><?= $product_description ?></textarea>
                <?php if(!empty($product_descriptionErr)): ?>
                <span class="error"> <?= $product_descriptionErr ?></span><br>
                 <?php endif; ?>
            </div>
            

                
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>
</body>
</html>