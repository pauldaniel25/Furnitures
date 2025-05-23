<?php
// filepath: /C:/xampp/htdocs/git/Furnitures/Builders3/user/order_history.php
session_start();
require_once 'classes.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

// Create an instance of the history class
$history = new history();
$orderHistory = $history->getUserOrderHistory($user_id);

// Check if any orders exist
if (empty($orderHistory)) {
    $noOrdersMessage = "You have no order history.";
} else {
    $noOrdersMessage = "";
}
?>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
            padding: 10px; /* Added padding */
        }
        .filter-section input[type="text"] {
            flex: 1;
            padding: 5px; /* Shortened space bar */
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .filter-section select, .filter-section button {
            padding: 5px; /* Shortened space bar */
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
        .calendar-icon {
            cursor: pointer;
            font-size: 1.5rem;
            margin-left: 10px;
            margin-right: 1em;
        }
        .date-filter-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .date-filter-modal .close-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .date-filter-modal .close-btn:hover {
            background-color: #0056b3;
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
            <input type="text" id="searchInput" placeholder="Search orders...">
            <i class="bi bi-calendar calendar-icon" onclick="toggleDateFilterModal()"></i>
            <select id="statusFilter">
                <option value="all">All</option>
                <option value="Completed">Completed</option>
                <option value="Canceled">Canceled</option>
            </select>
            <button onclick="filterOrders()">Filter</button>
        </div>
        <div class="date-filter-modal" id="dateFilterModal">
            <input type="text" id="dateRange" class="form-control mb-2" placeholder="Select date range">
            <button onclick="applyDateFilter()" class="btn btn-primary">Apply</button>
            <button onclick="toggleDateFilterModal()" class="close-btn">Close</button>
        </div>
        <table class="order-history-table" id="orderHistoryTable">
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
                <?php if ($noOrdersMessage): ?>
                    <tr>
                        <td colspan="6" class="text-center"><?php echo $noOrdersMessage; ?></td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($orderHistory as $order): ?>
                        <tr>
                            <td><img src="../seller/product_images2/<?php echo $order['product_image1']; ?>" alt="<?php echo $order['product_name']; ?>" class="img-fluid"></td>
                            <td><?php echo $order['product_name']; ?></td>
                            <td><?php echo $order['date_ordered']; ?></td>
                            <td><?php echo $order['date_completed']; ?></td>
                            <td><?php echo $order['quantity']; ?></td>
                            <td class="<?php echo $order['status'] === 'Completed' ? 'status-complete' : 'status-canceled'; ?>"><?php echo $order['status']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(function() {
            $('#dateRange').daterangepicker({
                singleDatePicker: false,
                showDropdowns: true,
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('#dateRange').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                applyDateFilter(picker.startDate, picker.endDate);
            });

            $('#dateRange').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                applyDateFilter(null, null);
            });
        });

        function filterOrders() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            const table = document.getElementById('orderHistoryTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                const productName = cells[1].textContent.toLowerCase();
                const status = cells[5].textContent;

                let matchesSearch = productName.includes(searchInput);
                let matchesStatus = (statusFilter === 'all') || (status === statusFilter);

                if (matchesSearch && matchesStatus) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }

        function toggleDateFilterModal() {
            const dateFilterModal = document.getElementById('dateFilterModal');
            dateFilterModal.style.display = dateFilterModal.style.display === 'none' ? 'block' : 'none';
        }

        function applyDateFilter(start, end) {
            const table = document.getElementById('orderHistoryTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                const dateOrdered = moment(cells[2].textContent, 'YYYY-MM-DD');
                const dateCompleted = moment(cells[3].textContent, 'YYYY-MM-DD');

                let matchesDateRange = true;
                if (start && end) {
                    matchesDateRange = dateOrdered.isBetween(start, end, null, '[]') || dateCompleted.isBetween(start, end, null, '[]');
                }

                if (matchesDateRange) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }

        document.getElementById('searchInput').addEventListener('input', filterOrders);
        document.getElementById('statusFilter').addEventListener('change', filterOrders);
    </script>
</body>
</html>