<?php
class SellerDashboard {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Get products by seller
    public function getProductsBySeller($sellerId) {
        $query = "
            SELECT 
                p.product_id, 
                p.product_name, 
                p.product_description, 
                p.product_price, 
                p.quantity, 
                p.product_image1, 
                c.category_title 
            FROM products p
            JOIN categories c ON p.category_id = c.category_id
            WHERE p.seller_id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $sellerId);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }
    
    
    // Insert or update a product (including quantity)
    public function insertProduct($productName, $productDescription, $productPrice, $categoryId, $quantity, $productImage1, $sellerId) {
        $query = "INSERT INTO products (product_name, product_description, product_price, category_id, quantity, product_image1, seller_id, date) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssdisis", $productName, $productDescription, $productPrice, $categoryId, $quantity, $productImage1, $sellerId);
    
        return $stmt->execute();
    }
    

    // Method to edit a product (including quantity)
    public function editProduct($productId, $productName, $productDescription, $productPrice, $categoryId, $quantity, $productImage = null) {
        $query = "UPDATE products SET 
                    product_name = ?, 
                    product_description = ?, 
                    product_price = ?, 
                    category_id = ?, 
                    quantity = ?";
        
        if ($productImage) {
            $query .= ", product_image1 = ?";
        }
        $query .= " WHERE product_id = ?";
        
        $stmt = $this->conn->prepare($query);
        
        if ($productImage) {
            $stmt->bind_param('ssdiiis', $productName, $productDescription, $productPrice, $categoryId, $quantity, $productImage, $productId);
        } else {
            $stmt->bind_param('ssdiii', $productName, $productDescription, $productPrice, $categoryId, $quantity, $productId);
        }
        
        return $stmt->execute();
    }
    
    

    // Method to handle product deletion
    public function deleteProduct($productId) {
        // SQL query to delete a product
        $query = "DELETE FROM products WHERE product_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $productId);  // Bind the product ID parameter
        return $stmt->execute();  // Execute the query and return the result
    }

    // Fetch all categories for the seller
    public function getCategories() {
        $query = "SELECT category_id, category_title FROM categories";
        $result = $this->conn->query($query);
        $categories = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
        }
        return $categories;
    }

    // Get details of the seller
    public function getSellerDetails($email) {
        $query = mysqli_query($this->conn, "SELECT s.*, sub.start_date, sub.end_date 
                                             FROM `seller` s 
                                             LEFT JOIN `subscription` sub ON s.subscription_id = sub.id 
                                             WHERE s.email='$email'");
        return mysqli_fetch_array($query);
    }

    // Count listed products for the specific seller
    public function getProductCount($seller_id) {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) as total_products FROM `products` WHERE `seller_id`='$seller_id'");
        return mysqli_fetch_assoc($query)['total_products'] ?? 0;
    }

    // Count orders for the specific seller
    public function getOrderCount($seller_id) {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) as total_orders FROM `user_order_details` WHERE `seller_id`='$seller_id'");
        return mysqli_fetch_assoc($query)['total_orders'] ?? 0;
    }

    // Calculate total revenue for the seller from completed orders
    public function getRevenue($seller_id) {
        $query = mysqli_query($this->conn, "
            SELECT SUM(p.product_price * uod.quantity) AS total_revenue
            FROM user_order_details AS uod
            JOIN products AS p ON uod.product_id = p.product_id
            WHERE uod.seller_id = '$seller_id' AND uod.status = 'completed'
        ");
        return mysqli_fetch_assoc($query)['total_revenue'] ?? 0;
    }

    // Count the number of completed products for the seller
    public function getCompletedProductsCount($seller_id) {
        $query = mysqli_query($this->conn, "
            SELECT COUNT(DISTINCT uod.product_id) AS total_completed_products
            FROM user_order_details AS uod
            WHERE uod.seller_id = '$seller_id' AND uod.status = 'completed'
        ");
        return mysqli_fetch_assoc($query)['total_completed_products'] ?? 0;
    }

    public function getOrders($seller_id, $searchTerm = '', $searchStatus = '') {
        // Initial condition to filter by seller_id
        $queryConditions = "WHERE uod.seller_id = '$seller_id'";
    
        // If searchTerm is provided, filter by product name, user name, etc.
        if ($searchTerm) {
            $queryConditions .= " AND (u.first_name LIKE '%$searchTerm%' OR u.last_name LIKE '%$searchTerm%' OR p.product_name LIKE '%$searchTerm%')";
        }
    
        // If searchStatus is provided, filter by order status
        if ($searchStatus) {
            $queryConditions .= " AND uod.status = '$searchStatus'";
        }
    
        // SQL query to fetch order details along with product images
        return mysqli_query($this->conn, "
            SELECT 
                u.first_name AS user_first_name, 
                u.last_name AS user_last_name, 
                p.product_name, 
                p.product_image1,  
                p.product_price, 
                uod.status AS order_status, 
                uod.quantity, 
                (p.product_price * uod.quantity) AS total_price, 
                uod.id AS user_order_id,   -- Changed from order_id to user_order_id
                uod.seller_id, 
                uod.user_id
            FROM 
                user_order_details AS uod
            JOIN 
                products AS p ON uod.product_id = p.product_id
            JOIN 
                user AS u ON uod.user_id = u.id
            JOIN 
                seller AS s ON uod.seller_id = s.id
            $queryConditions
        ");
    }
    

    // Update order status
   // Update the order status
public function updateOrderStatus($order_id, $new_status) {
    // Check if new status is valid
    if (!in_array($new_status, ['pending', 'completed','canceled'])) {
        return false; // Invalid status
    }

    // Prepare the SQL query to update the status
    $updateStatusQuery = "UPDATE `user_order_details` SET `status` = ? WHERE `id` = ?";
    $stmt = $this->conn->prepare($updateStatusQuery);
    $stmt->bind_param("si", $new_status, $order_id);
    
    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        return true; // Successfully updated
    } else {
        return false; // Failed to update
    }
}

    // Get subscription name by ID
    public function getSubscriptionName($subscription_id) {
        if ($subscription_id) {
            $query = mysqli_query($this->conn, "SELECT name FROM `subscription` WHERE `id`='$subscription_id'");
            if ($query && mysqli_num_rows($query) > 0) {
                $subscription = mysqli_fetch_assoc($query);
                return $subscription['name'];
            }
        }
        return null;
    }

    // Update subscription for a seller
    public function updateSubscription($seller_id, $subscription_id) {
        $update_query = "UPDATE `seller` SET subscription_id='$subscription_id' WHERE id='$seller_id'";
        return mysqli_query($this->conn, $update_query);
    }

    // Get all subscription options
    public function getAllSubscriptions() {
        $subscriptions = [];
        $query = mysqli_query($this->conn, "SELECT * FROM `subscription`");
        while ($row = mysqli_fetch_assoc($query)) {
            $subscriptions[] = $row;
        }
        return $subscriptions;
    }

  
}
?>
