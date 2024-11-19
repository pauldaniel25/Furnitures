<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="cart2style.css">
</head>
<body>
<div class="cart-container">
    <div class="cart-header">
        <i class="fa-solid fa-shopping-cart"></i>
        <h2>Cart</h2>
    </div>
    <div class="cart-body">
        <div class="cart-product">
            <div class="product-image">
                <img src="https://picsum.photos/100/100" alt="Product 1">
            </div>
            <div class="product-details">
                <h4>Product 1</h4>
            </div>
            <div class="unit-price">
                <p>$10.99</p>
            </div>
            <div class="quantity">
                <input type="number" value="1" min="1">
            </div>
            <div class="total-price">
                <p>$10.99</p>
            </div>
            <div class="action">
                <button class="remove">Remove</button>
            </div>
        </div>
        <div class="cart-product">
            <div class="product-image">
                <img src="https://picsum.photos/101/101" alt="Product 2">
            </div>
            <div class="product-details">
                <h4>Product 2</h4>
            </div>
            <div class="unit-price">
                <p>$20.99</p>
            </div>
            <div class="quantity">
                <input type="number" value="1" min="1">
            </div>
            <div class="total-price">
                <p>$20.99</p>
            </div>
            <div class="action">
                <button class="remove">Remove</button>
            </div>
        </div>
        <div class="cart-product">
            <div class="product-image">
                <img src="https://picsum.photos/102/102" alt="Product 3">
            </div>
            <div class="product-details">
                <h4>Product 3</h4>
            </div>
            <div class="unit-price">
                <p>$30.99</p>
            </div>
            <div class="quantity">
                <input type="number" value="1" min="1">
            </div>
            <div class="total-price">
                <p>$30.99</p>
            </div>
            <div class="action">
                <button class="remove">Remove</button>
            </div>
        </div>
        <div class="cart-product">
            <div class="product-image">
                <img src="https://picsum.photos/103/103" alt="Product 4">
            </div>
            <div class="product-details">
                <h4>Product 4</h4>
            </div>
            <div class="unit-price">
                <p>$40.99</p>
            </div>
            <div class="quantity">
                <input type="number" value="1" min="1">
            </div>
            <div class="total-price">
                <p>$40.99</p>
            </div>
            <div class="action">
                <button class="remove">Remove</button>
            </div>
        </div>
        <div class="cart-product">
            <div class="product-image">
                <img src="https://picsum.photos/104/104" alt="Product 5">
            </div>
            <div class="product-details">
                <h4>Product 5</h4>
            </div>
            <div class="unit-price">
                <p>$50.99</p>
            </div>
            <div class="quantity">
                <input type="number" value="1" min="1">
            </div>
            <div class="total-price">
                <p>$50.99</p>
            </div>
            <div class="action">
                <button class="remove">Remove</button>
            </div>
        </div>
    </div>
    <div class="cart-footer">
        <p>Subtotal: $153.94</p>
        <p>Shipping: $5.00</p>
        <p class="total">Total: $158.94</p>
        <button class="checkout">Checkout</button>
    </div>
</div>

    <script src="cart2script.js"></script>
</body>
</html>