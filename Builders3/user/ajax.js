// Function to load the Add Product form via AJAX
function addProduct(productId) {
    $.ajax({
        type: 'GET',
        url: 'add-product.php',
        data: { id: productId },
        dataType: 'html',
        beforeSend: function() {
            // Show loading animation
            $('.modal-container').html('<div class="loader"></div>');
        },
        success: function(view) {
            // Inject HTML into modal container
            $('.modal-container').html(view);
            // Show modal if exists
            if ($('#modal-add-product').length) {
                $('#modal-add-product').modal('show');
            } else {
                console.error('Modal #modal-add-product not found');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error loading modal:', error);
            // Display error message
            $('.modal-container').html('<p>Error loading modal.</p>');
        }
    });
}

// Event listener for 'Add Product' button
$('.add-cart-btn').on('click', function(e) {
    e.preventDefault();
    const productId = $(this).data('id');
    addProduct(productId);
});