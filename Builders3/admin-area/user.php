<?php
include('../includes/connect.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

// Handle user deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_id'])) {
    $user_id = $_POST['delete_user_id'];

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

// Handle user update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user_id'])) {
    $user_id = $_POST['edit_user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $barangay_id = $_POST['barangay_id'];
    $contact_number = $_POST['contact_number'];

    // Prepare the update query
    $updateQuery = "UPDATE `user` SET first_name='$first_name', last_name='$last_name', email='$email', barangay_id='$barangay_id', contact_number='$contact_number' WHERE id='$user_id'";

    // Execute the query
    if (mysqli_query($conn, $updateQuery)) {
        $message = "User updated successfully.";
    } else {
        $message = "Error updating user: " . mysqli_error($conn);
    }
}

// Fetch all users with barangay name
$usersQuery = mysqli_query($conn, "
    SELECT u.*, b.Brgy_Name AS barangay_name 
    FROM `user` u 
    JOIN `barangay` b ON u.barangay_id = b.id
");
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
    <title>Manage Users</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 18px;
            text-align: center;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .alert {
            padding: 10px;
            background-color: #f44336;
            color: white;
            margin-bottom: 15px;
            text-align: center;
        }
        button {
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }
        .view-button {
            background-color: #4CAF50;
        }
        .edit-button {
            background-color: #2196F3;
        }
        .delete-button {
            background-color: #f44336;
        }
        button:hover {
            opacity: 0.8;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            animation: fadeIn 0.5s;
        }
        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .modal-header, .modal-footer {
            padding: 10px;
            background-color: #f2f2f2;
            border-bottom: 1px solid #ddd;
        }
        .modal-footer {
            border-top: 1px solid #ddd;
            text-align: right;
        }
        .modal-body {
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-group button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }
        .form-group button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<!-- Header Section -->
<section id="menu">
    <div class="logo">
        <img src="LOGO-removebg-preview.png" alt="CH Lumber">
        <h2>CH Lumber</h2>
    </div>
    <div class="items">
        <li><i class="fa-solid fa-house"></i><a href="admin.php">Dashboard</a></li>
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

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Barangay</th>
                <th>Contact Number</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($user = mysqli_fetch_assoc($usersQuery)) {
                echo "<tr>
                        <td>{$user['id']}</td>
                        <td>{$user['first_name']} {$user['last_name']}</td>
                        <td>{$user['email']}</td>
                        <td>{$user['barangay_name']}</td>
                        <td>{$user['contact_number']}</td>
                        <td>{$user['created_at']}</td>
                        <td>
                            <button class='view-button' onclick='openModal(\"view\", {$user['id']})'>View</button>
                            <button class='edit-button' onclick='openModal(\"edit\", {$user['id']})'>Edit</button>
                            <form action='' method='POST' style='display:inline;'>
                                <input type='hidden' name='delete_user_id' value='{$user['id']}'>
                                <button class='delete-button' type='submit' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</button>
                            </form>
                        </td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</section>

<script>
    // Remove the openModal and closeModal functions
    // Remove the fetchUserDetails function
</script>

</body>
</html>
