<body class="bg_light">
    <h2>Insert Product</h2>
    <form method="post" action="insert_product.php" enctype="multipart/form-data">
        <label for="product_title">Product Title:</label>
        <input type="text" name="product_title" required><br>

        <label for="product_description">Product Description:</label>
        <textarea name="product_description" required></textarea><br>

        <label for="product_keywords">Product Keywords:</label>
        <input type="text" name="product_keywords" required><br>

        <label for="product_category">Category:</label>
        <select name="product_category" required>
            <option value="">Select Category</option>
            <!-- Replace these options with your actual categories -->
            <option value="1">Category 1</option>
            <option value="2">Category 2</option>
            <option value="3">Category 3</option>
        </select><br>

        <label for="product_image1">Product Image 1:</label>
        <input type="file" name="product_image1" required><br>

        <label for="product_image2">Product Image 2:</label>
        <input type="file" name="product_image2" required><br>

        <label for="product_image3">Product Image 3:</label>
        <input type="file" name="product_image3" required><br>

        <label for="product_price">Product Price:</label>
        <input type="number" name="product_price" required><br>

        <input type="submit" name="insert_product" value="Insert Product">
    </form>
</body>
</html>