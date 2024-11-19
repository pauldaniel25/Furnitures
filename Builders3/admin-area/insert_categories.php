<?php
include('../includes/connect.php');

if(isset($_POST['insert_cat'])){
  $category_title=$_POST['cat-title'];

  $select_query="select * from `categories` where category_title='$category_title'";
  $result_select=mysqli_query($con,$select_query);
  $number=mysqli_num_rows( $result_select);

if( $number>0){
  echo "<script>alert('category already added,insert new category')</script>";
}else{
  $insert_query="insert into `categories`(category_title) values ( '$category_title')";
  $result=mysqli_query($con,$insert_query);
  if($result){
    echo "<script>alert('category successfully added')</script";
  }
}
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>insert category</title>
  
 <link rel="stylesheet" href="../style.css">
</head>

<body>
<h2 class="text-center">Insert Categories </h2>
<form action="" method="post" class="mb-2">
<div class="input-group w-90 mb-2">
  <span class="input-group-text bg-info" id="basic-addon1">
    <i class="fa-solid fa-receipt"></i></span>
  <input type="text" class="form-control" name="cat-title" placeholder="Insert Categories"
   aria-label="Categories" aria-describedby="basic-addon1">
</div>

<div class="input-group w-10 mb-2 m-auto">
  
  <input type="submit" class=" submit-btn bg-info border-0 p-2 my-3" name="insert_cat" value="Insert categories"
   aria-label="Categories" aria-describedby="basic-addon1" class="">
   
</div>

</form>
    


<!--bootsrap js link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>