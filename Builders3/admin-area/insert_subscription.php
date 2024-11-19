<?php
include('../includes/connect.php');

if (isset($_POST['insert_product'])) {
    // Retrieve form data
    $subscription_title = $_POST['subscription_title'];
    $product_start_date = $_POST['start_date'];
    $product_end_date = $_POST['end_date'];

    // Validation
    if (empty($subscription_title) || empty($product_start_date) || empty($product_end_date)) {
        echo "<script>alert('All fields are required to be filled');</script>";
        exit();
    }

    // Check if the start date is before the end date
    if (strtotime($product_start_date) >= strtotime($product_end_date)) {
        echo "<script>alert('Start date must be before end date');</script>";
        exit();
    }

    // Insert subscription into the database
    $insert_subscription = "INSERT INTO `subscription` (name, start_date, end_date) 
        VALUES ('$subscription_title', '$product_start_date', '$product_end_date')";

    $result_query = mysqli_query($conn, $insert_subscription);

    if ($result_query) {
        echo "<script>alert('Subscription inserted successfully');</script>";
        // Optionally, redirect or reset the form here
    } else {
        echo "<script>alert('Error inserting subscription: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Subscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../style.css">
</head>
<body class="bg_light">
    <div class="container">
        <h1 class="text-center mt-3">Insert Subscription</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <!-- Subscription Title -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="subscription_title" class="form-label">Subscription Title</label>
                <input type="text" name="subscription_title" id="subscription_title" class="form-control" placeholder="Enter subscription name" autocomplete="off" required>
            </div>

            <!-- Start Date -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control" required>
            </div>

            <!-- End Date -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control" required>
            </div>

            <!-- Submit Button -->
            <div class="form-outline mb-4 w-50 m-auto">
                <input type="submit" name="insert_product" class="btn btn-info mb-3 px-3" value="Insert Subscription">
            </div>
        </form>
    </div>
</body>
</html>
