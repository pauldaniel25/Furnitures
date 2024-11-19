<?php

require_once 'database.php';

class User {
    public $First_Name = '';
    public $Last_Name = '';
    public $barangay_id = '';
    public $Email = '';
    public $password = '';

protected $db;

function __construct(){
    $database = new Database();
    $this->db = $database->connect();
    }
    public function signUp($First_Name, $Last_Name, $barangay_id, $Email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO user (First_Name, Last_Name, barangay_id, Email, password) VALUES (:First_Name, :Last_Name, :barangay_id, :Email, :password)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':First_Name', $First_Name);
        $stmt->bindParam(':Last_Name', $Last_Name);
        $stmt->bindParam(':barangay_id', $barangay_id);
        $stmt->bindParam(':Email', $Email);
        $stmt->bindParam(':password', $hashedPassword);
    
        if ($stmt->execute()) {
            return "User registered successfully!";
        } else {
            return "Error: User registration failed.";
        }
    }
    function getbarangay(){
        $sql = "SELECT id, Brgy_Name FROM Barangay"; 
        $query = $this->db->prepare($sql);

        $data = [];

        if ($query->execute()){
            $data = $query->fetchAll();
        }
        return $data;
    }

    public function login($email, $password) {
        // Prepared SQL statement to prevent SQL injection
        $sql = "SELECT id, email, password FROM user WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $email = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify password if user exists
        if ($email && password_verify($password, $email['password'])) {
            // Start session and store user info
            session_start();
            $_SESSION['user_id'] = $email['id'];
            $_SESSION['email'] = $email['email'];

            // Success message
            $_SESSION['success'] = "You have logged in successfully!";
            return true;
        } else {
            // Invalid credentials
            return false;
        }

}    
}
class Product {
    public $id = '';
    public $product_name = '';
    public $product_description = '';
    public $product_keywords = '';
    public $category_id = '';
    public $product_image1 = NULL;
    public $product_image2 = NULL;
    public $product_image3 = NULL;
    public $product_price = '';
    public $status = '';
    public $seller_id = '';
    public $seller_name = '';

    protected $db;

    function __construct(){
        $database = new Database();
        $this->db = $database->connect();
        }
/*
        function addProduct(){
            $sql = "INSERT INTO products (product_name, product_description, product_keywords, category_id, product_code, product_image1, product_image2, product_image3, product_price, status, seller_id, seller_name)
             VALUES  (:product_name, :product_description, :product_keywords, :category_id, :product_code, :product_image1, :product_image2, :product_image3, :product_price, :status, :seller_id, :seller_name);";
            $query = $this->db->prepare($sql);
    
            $stmt->bindParam(':product_name', $product->product_name);
            $stmt->bindParam(':product_description', $product->product_description);
            $stmt->bindParam(':product_keywords', $product->product_keywords);
            $stmt->bindParam(':category_id', $product->category_id);
            $stmt->bindParam(':product_code', $product->product_code);
            $stmt->bindParam(':product_image1', $product->product_image1);
            $stmt->bindParam(':product_image2', $product->product_image2);
            $stmt->bindParam(':product_image3', $product->product_image3);
            $stmt->bindParam(':product_price', $product->product_price);
            $stmt->bindParam(':status', $product->status);
            $stmt->bindParam(':seller_id', $product->seller_id);
            $stmt->bindParam(':seller_name', $product->seller_name);
        
            if($query->execute()){
                return true;
            }else{
                return false;
            }
        }
            */
        function codeExists($product_code, $excludeID = null) {
            // SQL query to check if the product code exists.
            $sql = "SELECT COUNT(*) FROM products WHERE product_code = :product_code";
    
            // If $excludeID is provided, modify the SQL query to exclude the record with this ID.
            if ($excludeID) {
                $sql .= " AND product_id != :excludeID";
            }
    
            // Prepare the SQL statement.
            $query = $this->db->prepare($sql);
    
            // Bind the parameters.
            $query->bindParam(':product_code', $product_code);
    
            if ($excludeID) {
                $query->bindParam(':excludeID', $excludeID);
            }
    
            // Execute the query.
            $query->execute();
    
            // Fetch the count. If it's greater than 0, the code already exists.
            $count = $query->fetchColumn();
    
            return $count > 0;
        }
        function showproducts($keyword = ''){
            $sql = "SELECT p.*, c.category_title AS Category FROM products p INNER JOIN categories c ON p.category_id = c.category_id WHERE (product_name LIKE '%' :keyword '%' OR product_keywords LIKE '%' :keyword '%' ) ORDER BY product_name ASC;"; 
            $query = $this->db->prepare($sql);
            $query->bindparam(':keyword', $keyword);

            $data = null;

            if ($query->execute()){
                $data = $query->fetchAll();
            }
            return $data;
        }
        function fetchRecord($recordID) {
            // SQL query to select a single product based on its ID.
            $sql = "SELECT p.*, c.category_title AS Category FROM products p INNER JOIN categories c ON p.category_id = c.category_id WHERE product_id = :recordID;";
    
            // Prepare the SQL statement for execution.
                   $query = $this->db->prepare($sql);
            $query->bindParam(':recordID', $recordID);
            $data = null; // Initialize a variable to hold the fetched data.
    
            // Execute the query. If successful, fetch the result.
            if($query->execute()) {
                $data = $query->fetch(); // Fetch the single row from the result set.
            }else{
                echo 'error';
            }
    
            return $data; // Return the fetched data.
        } 
        function recommendations($Category, $currentProductId) {
            // SQL query to recommend.
            $sql = "SELECT p.*, c.category_title AS Category FROM products p INNER JOIN 
            categories c ON p.category_id = c.category_id WHERE p.category_id = :Category 
            AND p.product_id != :currentProductId;";
            // Prepare the SQL statement for execution.
            $query = $this->db->prepare($sql);
            $query->bindParam(':Category', $Category);
            $query->bindParam(':currentProductId', $currentProductId);
            $data = null; // Initialize a variable to hold the fetched data.
    
            // Execute the query. If successful, fetch the result.
            if($query->execute()) {
                $data = $query->fetchAll(); // Fetch the single row from the result set.
            }else{
                echo 'error';
            }
    
            return $data; // Return the fetched data.
        } 
        function truncateDescription($description, $maxLength = 100) {
            if (strlen($description) > $maxLength) {
                return substr($description, 0, $maxLength) . '...'; // Truncate and append ellipsis
            }
            return $description; // Return the original description if within the limit
        }

        
}