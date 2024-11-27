// Selectors
const quantityInputs = document.querySelectorAll('.quantity input');
const removeButtons = document.querySelectorAll('.remove');
const cartProducts = document.querySelectorAll('.cart-product');
const totalPriceElement = document.querySelector('.cart-footer .total');

// Functions
const cartFunctions = {
  updateQuantity: (event) => {
    const quantity = parseInt(event.target.value);
    if (quantity < 1) quantity = 1;
    const cartItem = event.target.closest('.cart-product');
    const price = parseFloat(cartItem.querySelector('.unit-price p').innerText.replace('$', '').replace(',', ''));
    cartItem.querySelector('.total-price p').innerText = `$${(price * quantity).toFixed(2)}`;

    fetch('update_cart_item.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `cart_item_id=${cartItem.querySelector('.cart-item-id').innerText}&quantity=${quantity}`,
    })
      .then((response) => response.text())
      .then((message) => {
        console.log(message);
        cartFunctions.updateTotalPrice();
      })
      .catch((error) => console.error('Error:', error));
  },

  removeItem: (event) => {
    const cartItem = event.target.closest('.cart-product');
    const cartItemId = cartItem.querySelector('.cart-item-id').innerText;
    fetch('remove_cart_item.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `cart_item_id=${cartItemId}`,
    })
      .then((response) => response.text())
      .then((message) => {
        console.log(message);
        if (message === 'success') {
          cartItem.remove();
          cartFunctions.updateTotalPrice();
        } else {
          alert(`Error removing item: ${message}`);
        }
      })
      .catch((error) => console.error('Error:', error));
  },

  updateTotalPrice: () => {
    fetch('get_total_price.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    })
    .then(response => response.text())
    .then(totalPrice => {
      totalPriceElement.innerText = `Total: $${totalPrice}`;
    })
    .catch(error => console.error('Error:', error));
  },

  initialize: () => {
    quantityInputs.forEach((input) => input.addEventListener('input', cartFunctions.updateQuantity));
    removeButtons.forEach((button) => button.addEventListener('click', cartFunctions.removeItem));
    cartFunctions.updateTotalPrice();
  },
};

// Initialize
cartFunctions.initialize();

function showErrorMessage() {
  document.getElementById("error-message").style.display = "block";
}