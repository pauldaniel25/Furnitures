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
  
  function cancelOrderAjaxRequest(method, url, data, callback) {
    $.ajax({
      type: method,
      url: url,
      data: JSON.stringify(data),
      contentType: 'application/json',
      dataType: 'json',
      success: function(response) {
        console.log('Success:', response);
        callback(response);
      },
      error: function(xhr, status, error) {
        console.error('Error:', error);
        console.log('XHR:', xhr);
        console.log('Status:', status);
        console.log('Response Text:', xhr.responseText);
        alert(`Error: ${error}\nStatus: ${status}\nResponse: ${xhr.responseText}`);
      }
    });
  }
  
  $(document).on('click', '.btn-cancel', function(e) {
    e.preventDefault();
    e.stopPropagation();
    const orderId = $(this).data('id');
    const statusElement = $(`.status[data-id="${orderId}"]`);
  
    cancelOrderAjaxRequest('POST', 'ajax-handler/cancel-order.php', { orderId: orderId }, function(response) {
      if (response.success) {
        statusElement
          .text('Canceled')
          .addClass('Canceled') // Optional: Add class for styling
        ;
        $(`.btn-cancel[data-id="${orderId}"]`)
          .text('Canceled')
          .prop('disabled', true);
      } else {
        console.error('Cancel order failed:', response.message);
        alert(`Cancel order failed: ${response.message}`);
      }
    });
  });



// Function to handle AJAX requests
function sendAjaxRequest(method, url, data, callback) {
  $.ajax({
      type: method,
      url: url,
      data: JSON.stringify(data),
      contentType: 'application/json',
      dataType: 'json',
      success: function(response) {
          callback(response);
      },
      error: function(xhr, status, error) {
          console.error('Error:', error);
          console.log('XHR:', xhr);
          console.log('Status:', status);
          console.log('Response Text:', xhr.responseText);
          alert(`Error: ${error}\nStatus: ${status}\nResponse: ${xhr.responseText}`);
      }
  });
}

// Event listeners
$(document).on('click', '.btn-remove', function(e) {
  e.preventDefault();
  const orderId = $(this).data('id');
  if (confirm('Are you sure you want to remove this order?')) {
      sendAjaxRequest('POST', 'remove_order.php', { order_id: orderId }, function(response) {
          if (response.success) {
              alert('Order removed successfully.');
              location.reload();
          } else {
              alert('Error removing order: ' + response.message);
          }
      });
  }
});