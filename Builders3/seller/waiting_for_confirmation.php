<?php
session_start();

// Optionally, check if the user is already logged in (if needed)
if (isset($_SESSION['seller_id'])) {
    // Redirect to the seller dashboard or home page if the user is somehow logged in
    header("Location: seller.php");
    exit();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal Example</title>
</head>
<body>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Waiting for admin approval</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="container">
      
        <p>Thank you for registering! Your account is currently awaiting approval from an administrator. Please check your email for further updates.</p>
        <p>If you have any questions, feel free to contact our support team.</p>
       
    </div>
                <div class="modal-footer">
                  
                  <a href="index.php"> <button type="button" class="btn btn-primary" id="understoodButton">Understood</button>
                  </div></a> 
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS (including Popper.js for Bootstrap's components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- JavaScript to automatically show the modal when the page loads -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Create a new Bootstrap modal instance and show it
            var myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'), {
                keyboard: false
            });
            myModal.show(); // Show the modal as soon as the page loads

            // Add event listener for the "Understood" button to redirect to index.php
            document.getElementById('understoodButton').addEventListener('click', function() {
                window.location.href = 'index.php';  // Redirect to index.php
            });
        });
    </script>
</body>
</html>

