<?php

// Assuming the 'database' class is already defined as per the previous discussion.
require_once 'database.php';  // Including the database class

class User {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function signUp($username, $password) {
        // Check if the username already exists
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return "Username already exists!";
        }

        // Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user into the database
        $query = "INSERT INTO users (username, pwd) VALUES (:username, :pwd)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':pwd', $hashedPassword);

        if ($stmt->execute()) {
            return "User registered successfully!";
        } else {
            return "Error: Could not register user.";
        }
    }
}

// Sample usage:
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new User();
    $result = $user->signUp($username, $password);
    echo $result;
}

?>

<!-- HTML form for user registration -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        <input type="submit" value="Sign Up">
    </form>
</body>
</html>