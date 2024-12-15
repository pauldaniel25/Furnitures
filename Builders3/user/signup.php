<?php
require_once 'function.php';
require_once 'classes.php';

session_start();

$First_Name = $Last_Name = $barangay_id = $email = $password = $contact_number = '';
$userobj = new User();
$signupErr = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $First_Name = clean($_POST['First_Name']);
    $Last_Name = clean($_POST['Last_Name']);
    $barangay_id = clean($_POST['barangay_id']);
    $contact_number = clean($_POST['contact_number']);
    $email = clean($_POST['email']);
    $password = clean($_POST['password']);

    // Here you would typically validate and save the user data
    if ($userobj->signUp($First_Name, $Last_Name, $barangay_id, $contact_number, $email, $password )) {
        $_SESSION['success_message'] = "Account created successfully! You can now log in.";
        header("Location: index.php");
        exit();
    } else {
        $signupErr = "Registration failed! Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Builders</title>
    <!-- Bootstrap CSS -->
    <link href="../xtend/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="signup.css">
</head>
<body>   
    <div class="container">
        <div class="login-card">
            <h1>Sign Up</h1>
            <?php
               if (isset($_SESSION['success_message'])) {
                   echo '<div class="alert alert-success text-center">' . $_SESSION['success_message'] . '</div>';
                   unset($_SESSION['success_message']);  // Unset the session after displaying the message
               }
            ?>
            <?php if ($signupErr): ?>
                <p class="error-message"><?php echo $signupErr; ?></p>
            <?php endif; ?>
            <form action="" method="POST">
            <div class="row mb-3">
                <div class="md-6">
                    <label for="First_Name" class="form-label">First Name</label>
                    <input type="text" name="First_Name" id="First_Name" class="form-control name" placeholder="Enter your First name" required>
                </div>
                <div class="md-6">
                    <label for="Last_Name" class="form-label">Last Name</label>
                    <input type="text" name="Last_Name" id="Last_Name" class="form-control name" placeholder="Enter your Last name" required>
                </div>
            </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="contact_number" class="form-label">Contact Number</label>
                    <input type="text" name="contact_number" id="contact_number" class="form-control" placeholder="Enter your contact number" required>
                </div>
                <div class="mb-3">
    <label for="barangay_id" class="form-label">Barangay</label>
    <select name="barangay_id" id="barangay" class="form-select" required>
        <?php
        $array = $userobj->getbarangay();

        // Check if any barangays were retrieved
        if (!empty($array)) {
            // Loop through each barangay and create an option element
            foreach ($array as $arr) {
                ?>
                <option value="<?= htmlspecialchars($arr['id'])?>"><?= htmlspecialchars($arr['Brgy_Name'])?></option>
                <?php
            }
        } else {
            echo '<option value="">No Barangays Found</option>';
        }
        ?>
    </select>
</div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn-submit">Sign Up</button>
            </form>
            <div class="signup-link">
                <p>Already have an account? <a href="index.php">Log in</a></p>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS (Optional, for interactive components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+3oG4eU9p8qE4y84QrQjjtvVBR11" crossorigin="anonymous"></script>
</body>
</html>
