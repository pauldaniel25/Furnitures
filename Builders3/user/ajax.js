// Function to load the Add Product form via AJAX
function addProduct(productId) {
    $.ajax({
        type: 'GET',
        url: 'add-product.php',  // The URL of the form to load
        data: { id: productId }, // Send the product ID in the request
        dataType: 'html',
        success: function(view) {
            // Inject the HTML into the modal container
            $('.modal-container').html(view);
            // Show the modal (assuming you're using Bootstrap or another modal library)
            $('#modal-add-product').modal('show');
        }
    });
}

// Event listener for the 'Add Product' button
$('#add-to-cart').on('click', function(e) {
    e.preventDefault();  // Prevent default action of the button (if any)
    const productId = $(this).data('id');  // Get the product ID (make sure this is set in the button)
    addProduct(productId);  // Call the addProduct function to load the modal
});
