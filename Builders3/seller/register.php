<?php 

include('../includes/connect.php');
session_start();

if (isset($_POST['signUp'])) {
    // Collect form data
    $firstName = trim($_POST['fName']);
    $lastName = trim($_POST['lName']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Initialize error array
    $errors = [];

    // Check if all fields are filled
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($confirmPassword)) {
        $errors[] = "All fields are required!";
    }

    // Validate password length (minimum 8 characters)
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long!";
    }

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match!";
    }

    // If there are no errors, proceed with the registration
    if (empty($errors)) {
        // Check if the email already exists
        $checkEmail = "SELECT * FROM seller WHERE email='$email'";
        $result = $conn->query($checkEmail);

        if ($result->num_rows > 0) {
            echo "Email Address Already Exists!";
        } else {
            // Hash the password
            $password = md5($password);

            // Insert the new user with 'pending' status
            $insertQuery = "INSERT INTO seller(firstName, lastName, email, password, status) 
                            VALUES ('$firstName', '$lastName', '$email', '$password', 'pending')";
            if ($conn->query($insertQuery) === TRUE) {
                // Redirect to success.php after successful registration
                header("Location: reg-success.php?registration=success");
                exit(); // Ensure the script stops executing after the redirect
            } else {
                echo "Error: " . $conn->error;
            }
        }
    } else {
        // Display validation errors
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}


if (isset($_POST['signIn'])) {
    // Get email and password from POST data
    $email = $_POST['email'];
    $password = md5($_POST['password']);  // Hash the password for comparison

    // Query to check if the email and password exist in the database
    $sql = "SELECT * FROM seller WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Check if the user is approved
        if ($row['status'] == 'approved') {
            // If the user is approved, log them in by storing session variables
            $_SESSION['seller_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            header("Location: seller.php");  // Redirect to the dashboard or main page
            exit();
        } elseif ($row['status'] == 'pending') {
            // If the user is still pending, redirect to a "waiting for confirmation" page
            header("Location: waiting_for_confirmation.php");
            exit();
        } else {
            // In case the status is 'rejected', you can handle it if necessary (optional)
            echo "Your account has been rejected. Please contact support.";
        }
    } else {
        // Invalid login attempt (incorrect email or password)
        echo "Incorrect email or password.";
    }
}

?>
