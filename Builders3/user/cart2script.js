// Update quantity input field and total price
document.querySelectorAll('.quantity input').forEach((input) => {
    input.addEventListener('input', () => {
        const quantity = parseInt(input.value);
        if (quantity < 1) {
            input.value = 1;
        }
        const price = parseFloat(input.parentNode.parentNode.querySelector('.unit-price p').textContent.replace('$', ''));
        input.parentNode.parentNode.querySelector('.total-price p').textContent = `$${(price * quantity).toFixed(2)}`;
        updateTotalPrice();
    });
});

// Remove product from cart
document.querySelectorAll('.remove').forEach((button) => {
    button.addEventListener('click', (e) => {
        const product = e.target.parentNode.parentNode;
        product.remove();
        updateTotalPrice();
    });
});

// Update total price
function updateTotalPrice() {
    const totalPrice = Array.from(document.querySelectorAll('.cart-product')).reduce((acc, product) => {
        const price = parseFloat(product.querySelector('.total-price p').textContent.replace('$', ''));
        return acc + price;
    }, 0);
    document.querySelector('.cart-footer .total').textContent = `Total: $${totalPrice.toFixed(2)}`;
}

// Initialize total price
updateTotalPrice();