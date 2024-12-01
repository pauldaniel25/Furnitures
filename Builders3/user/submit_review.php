<?php
// submit_review.php

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve form data
    $product_id = (int)$_POST['product_id'];
    $user_id = (int)$_POST['user_id'];
    $rating = (int)$_POST['rating'];
    $review = htmlspecialchars(trim($_POST['review']), ENT_QUOTES);

    // Include necessary classes
    include 'classes.php';

    // Create a Product object (assuming it contains the saveProductReview function)
    $product = new Product();

    // Call the method to save the review
    $success = $product->saveProductReview($product_id, $user_id, $rating, $review);

    // Return a JSON response
    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Unable to submit review.']);
    }
}
?>
