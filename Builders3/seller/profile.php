<?php
include('../includes/connect.php');
session_start();

// Check if seller is logged in
if (!isset($_SESSION['seller_id'])) {
    die("Seller not logged in.");
}

$seller_id = $_SESSION['seller_id'];

// Fetch the current seller data
$query = "SELECT * FROM seller WHERE id = '$seller_id'";
$result = mysqli_query($conn, $query);
$seller_data = mysqli_fetch_assoc($result);

if (isset($_POST['update_profile'])) {
    // Retrieve form data
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $profile_img = $_FILES['profile_image']['name'];
    
    // Temporary file name
    $temp_profile_img = $_FILES['profile_image']['tmp_name'];
    
    // Validation
    if (empty($firstName) || empty($lastName)) {
        echo "<script>alert('First name and last name are required.');</script>";
        exit();
    } else {
        // If a new image is uploaded, move it to the correct folder
        if (!empty($profile_img)) {
            $profile_img_path = "./profile_images/" . $profile_img;
            move_uploaded_file($temp_profile_img, $profile_img_path);
        } else {
            // Use the existing image if no new one is uploaded
            $profile_img_path = $seller_data['profile_img']; // Keep current image if no new one
        }

        // Update the profile in the database
        $update_profile = "UPDATE seller SET firstName = '$firstName', lastName = '$lastName', profile_img = '$profile_img_path' WHERE id = '$seller_id'";
        
        $result_query = mysqli_query($conn, $update_profile);

        if ($result_query) {
            echo "<script>alert('Profile updated successfully.');</script>";
            header("Location: profile.php"); // Redirect to the dashboard or profile page
        } else {
            echo "<script>alert('Error updating profile: " . mysqli_error($conn) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <!-- Display the profile image -->
                <img class="rounded-circle mt-5" width="150px" 
                     src="<?php echo $seller_data['profile_img'] ? $seller_data['profile_img'] : 'profile_images/default_profile.jpg'; ?>" 
                     alt="Profile Image">
                <!-- Display the first and last name -->
                <span class="font-weight-bold"><?php echo $seller_data['firstName'] . ' ' . $seller_data['lastName']; ?></span>
                <span class="text-black-50"><?php echo $seller_data['email']; ?></span>
            </div>
        </div>
        <div class="col-md-5 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Profile Settings</h4>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label class="labels">First name</label>
                            <input type="text" class="form-control" name="first_name" placeholder="First name" value="<?php echo $seller_data['firstName']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Last name</label>
                            <input type="text" class="form-control" name="last_name" placeholder="Last name" value="<?php echo $seller_data['lastName']; ?>" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="labels">Email ID</label>
                            <input type="email" class="form-control" placeholder="Email ID" value="<?php echo $seller_data['email']; ?>" disabled>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="labels">Profile Image</label>
                            <input type="file" class="form-control" name="profile_image">
                        </div>
                    </div>

                    <div class="mt-5 text-center">
                        <input type="submit" class="btn btn-primary profile-button" name="update_profile" value="Save Profile">
                    </div>
                </form>

                <!-- Button to redirect to seller.php -->
                <div class="mt-3 text-center">
                    <button class="btn btn-secondary" onclick="window.location.href='seller.php'">Back to Seller Dashboard</button>
                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>
