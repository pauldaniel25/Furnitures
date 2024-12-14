<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="../vendor/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../vendor/datatable-2.1.8/datatables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="productstyle.css">
    <link rel="stylesheet" href="includes/header.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .order-history-container {
            margin-top: 50px;
        }
        .order-history-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .order-history-table th, .order-history-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .order-history-table th {
            background-color: #343a40;
            color: white;
        }
        .order-history-table tr:hover {
            background-color: #f1f1f1;
        }
        .order-history-table img {
            width: 50px;
            height: auto;
        }
        .order-history-table .status-complete {
            color: green;
            font-weight: bold;
        }
        .order-history-table .status-canceled {
            color: red;
            font-weight: bold;
        }
        .filter-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .filter-section input[type="text"] {
            flex: 1;
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .filter-section select, .filter-section button {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }
        .filter-section button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
        .filter-section button:hover {
            background-color: #0056b3;
        }
        .order-section {
            margin-top: 30px;
        }
        .order-section h2 {
            font-size: 20px;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
    </style>
</head>
<body>
    <?php
    require_once 'includes/header.php';
    ?>
    <div class="container order-history-container">
        <h1 class="text-center mb-4">Order History</h1>
        <div class="filter-section">
            <input type="text" placeholder="Search orders...">
            <select>
                <option value="all">All</option>
                <option value="complete">Complete</option>
                <option value="canceled">Canceled</option>
            </select>
            <button>Filter</button>
        </div>
        <table class="order-history-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Date Ordered</th>
                    <th>Date Completed</th>
                    <th>Quantity</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6"><h2>Today</h2></td>
                </tr>
                <tr>
                    <td><img src="https://via.placeholder.com/50" alt="Wooden Chair" class="img-fluid"></td>
                    <td>Wooden Chair</td>
                    <td>2023-10-01</td>
                    <td>2023-10-03</td>
                    <td>2</td>
                    <td class="status-complete">Complete</td>
                </tr>
                <!-- Additional rows can be added here -->
                <tr>
                    <td colspan="6"><h2>Last Week</h2></td>
                </tr>
                <tr>
                    <td><img src="https://via.placeholder.com/50" alt="Wooden Chair" class="img-fluid"></td>
                    <td>Wooden Chair</td>
                    <td>2023-09-24</td>
                    <td>2023-09-26</td>
                    <td>1</td>
                    <td class="status-complete">Complete</td>
                </tr>
                <!-- Additional rows can be added here -->
            </tbody>
        </table>
    </div>
</body>
</html>