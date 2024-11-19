<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin dashboard</title>
    <!--bootsrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
 <!--font awesome cdn-->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 <!--css link-->
 <link rel="stylesheet" href="../style.css">
</head>

<body>
    <!--navbar-->
    <div class="container-fluid p-0">
        <!--first child-->
        <nav class="nabvar nabvar-expand-lg navbar-light bg-info">
            <div class="container-fluid">
                <img src="../image_asset/LOGO-removebg-preview.png" alt="" class="logo">
                <nav class="nabvar nabvar-expand-lg ">
<ul class="navbar-nav">
    <li class="nav-item">
        <a href="#" class="nav-link">Welcome guest</a>
    </li>
</ul>
                </nav>
            </div>
        </nav>
        <!--second child-->
        <div class="bg-light">
            <h3 class="text-center p-2">Manage Details</h3>
        </div>

        <!--3rd child-->
        <div class="row">
            <div class="col md-12 bg-secondary p-1 d-flex align-items-center justify-content-center">
                <div class="p-3"><a href="#">
                    <img src="../image_asset/door/DOOR2.jpg" alt="" class="admin-image">
                </a>
                <p class="text-light text-center">Admin name</p>
            </div>
            <div class="button text-center">
                <button><a href="insert_product.php" class="nav-link text-light bg-info my-1">insert products</a></button>
                <button><a href="" class="nav-link text-light bg-info my-1">view products</a></button>
                <button><a href="index.php?insert_category" class="nav-link text-light bg-info my-1">insert categories</a></button>
                <button><a href="" class="nav-link text-light bg-info my-1">view categories</a></button>
                <button><a href="" class="nav-link text-light bg-info my-1">all orders</a></button>
                <button><a href="insert_subscription.php" class="nav-link text-light bg-info my-1">insert Subscription</a></button>
                <button><a href="" class="nav-link text-light bg-info my-1">list users</a></button>
                <button><a href="" class="nav-link text-light bg-info my-1">list sellers</a></button>
                <button><a href="" class="nav-link text-light bg-info my-1">logout</a></button>
             
            </div>
            </div>
        </div>

<div class="container my-3">
    <?php 
    if(isset($_GET['insert_category'])){
        include("insert_categories.php");
    }
    ?>
</div>

        <div class="bg-footer  p-3 text-center" >
    All rights reserved
</div>

    </div>
    


<!--bootsrap js link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>