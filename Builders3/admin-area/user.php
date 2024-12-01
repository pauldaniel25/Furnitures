<?php
include('../includes/connect.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

// Handle user deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Prepare the delete query
    $deleteQuery = "DELETE FROM `user` WHERE id='$user_id'";

    // Execute the query
    if (mysqli_query($conn, $deleteQuery)) {
        // Optionally set a success message
        $message = "User deleted successfully.";
    } else {
        $message = "Error deleting user: " . mysqli_error($conn);
    }
}

// Fetch all users
$usersQuery = mysqli_query($conn, "SELECT * FROM `user`");
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Manage Users</title>
</head>
<body>

<!-- Header Section -->
<section id="menu">
    <div class="logo">
        <img src="LOGO-removebg-preview.png" alt="CH Lumber">
        <h2>CH Lumber</h2>
    </div>
    <div class="items">
        <li><i class="fa-solid fa-house"></i></i><a href="admin.php">Dashboard</a></li>
        <li><i class="fa-solid fa-cart-plus"></i><a href="insert_product.php">Products</a></li>
        <li><i class="fa-solid fa-cart-shopping"></i><a href="product.php">Listed Products</a></li>
        <li><i class="fa-regular fa-user"></i><a href="user.php">Users</a></li>
        <li><i class="fa-solid fa-user-secret"></i><a href="seller.php">Sellers</a></li>
        <li><i class="fa-solid fa-arrow-right-from-bracket"></i><a href="logout.php">Logout</a></li>
    </div>
</section>

<!-- Main Content Section -->
<section id="interface">
    <h3>Manage Users</h3>
    
    <?php if (isset($message)): ?>
        <div class="alert">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <table width="100%">
        <thead>
            <tr>
                <td>Name</td>
                <td>Created At</td>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($user = mysqli_fetch_assoc($usersQuery)) {
                echo "<tr>
                        <td>{$user['first_name']} {$user['last_name']}</td>
                        <td>{$user['created_at']}</td>
                        <td>
                            <form action='' method='POST' style='display:inline;'>
                                <input type='hidden' name='user_id' value='{$user['id']}'>
                                <button type='submit' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</button>
                            </form>
                        </td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</section>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        color: #333;
    }

    #menu {
        background-color: #378370; /* Sidebar color retained */
        padding: 20px;
        color: white;
    }

    .logo img {
        width: 50px;
        height: auto;
    }

    .items {
        list-style-type: none;
        padding: 0;
    }

    .items li {
        margin: 10px 0;
    }

    .items a {
        color: white;
        text-decoration: none;
        font-size: 16px;
    }

    #interface {
        padding: 20px;
    }

    h3 {
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #4CAF50; /* Table header color */
        color: white;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    button {
        background-color: #f44336; /* Delete button color */
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background-color: #d32f2f; /* Hover color for delete button */
    }

    .alert {
        margin-bottom: 20px;
        padding: 10px;
        background-color: #dff0d8;
        color: #3c763d;
        border: 1px solid #d6e9c6;
        border-radius: 5px;
    }
</style>

</body>
</html>
