<?php
require_once 'function.php';
require_once 'classes.php';

session_start();

$Email = $password = '';
$userobj = new User();
$loginErr = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $Email = clean($_POST['Email']);
    $password = clean($_POST['password']);

    if ($userobj->login($Email, $password)) {
        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION['error'] = "Invalid email or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Builders</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="index.css">
</head>
<body>    
    <div class="container">
        <div class="login-card">
            <h1>Login</h1>
            <?php
               if (isset($_SESSION['success_message'])) {
                   echo '<div class="alert alert-success text-center">' . $_SESSION['success_message'] . '</div>';
                   unset($_SESSION['success_message']);  // Unset the session after displaying the message
               }
            ?>
            <?php if (isset($_SESSION['error'])): ?>
                <p class="error-message"><?php echo $_SESSION['error']; ?></p>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="Email" class="form-label">Email</label>
                    <input type="email" name="Email" id="Email" class="form-control" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="Password" class="form-label">Password</label>
                    <input type="password" name="password" id="Password" class="form-control" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn-submit">Login</button>
            </form>
            <div class="signup-link">
                <p>Don't have an account? <a href="signup.php">Create an account</a></p>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS (Optional, for interactive components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+3oG4eU9p8qE4y84QrQjjtvVBR11" crossorigin="anonymous"></script>
</body>
</html>
