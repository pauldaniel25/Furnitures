// Function to handle AJAX requests
function ajaxRequest(method, url, data, callback) {
    $.ajax({
      type: method,
      url: url,
      data: data,
      dataType: 'html',
      beforeSend: function() {
        $('.modal-container').html('<div class="loader"></div>');
      },
      success: function(response) {
        callback(response);
      },
      error: function(xhr, status, error) {
        console.error('Error:', error);
        $('.modal-container').html('<p>Error loading modal.</p>');
      }
    });
  }
  
  // Event listeners
  $('.add-cart-btn').on('click', function(e) {
    e.preventDefault();
    const productId = $(this).data('id');
    ajaxRequest('GET', 'add-product.php', { id: productId }, function(response) {
      $('.modal-container').html(response);
      $('#modal-add-product').modal('show');
    });
  });
  
  $('.btn-view').on('click', function(e) {
    e.preventDefault();
    const orderId = $(this).data('id');
    ajaxRequest('GET', 'order_details.php', { id: orderId }, function(response) {
      $('.modal-container').html(response);
      $('#order-details-modal').modal('show');
    });
  });
  
  $('.review-btn').on('click', function(e) {
    e.preventDefault();
    const productId = $(this).data('id');
    ajaxRequest('GET', 'review_modal.php', { id: productId }, function(response) {
      $('.modal-container').html(response);
      $('#review-modal').modal('show');
    });
  });
  
  // Cancel order button event listener
  $('.btn-cancel').on('click', function(e) {
    e.preventDefault();
    const orderDetailId = $(this).data('id');
    $.ajax({
      type: 'POST',
      url: '/cancel-order.php',
      data: { order_detail_id: orderDetailId },
      success: function(message) {
        console.log(message);
        $(this).text('Cancelled').prop('disabled', true);
      },
      error: function(xhr, status, error) {
        console.error('Error:', error);
      }
    });
  });