<!-- Review Modal -->
<div class="modal fade" id="review-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="review-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="review-modal-label">Leave a Review</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form action="" method="post">
        <input type="hidden" name="product_id" value="<?= $_GET['id'] ?>">
        <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
        
        <div class="modal-body">
          <div class="mb-3">
            <label for="rating-input" class="form-label">Rating:</label>
            <select name="rating" id="rating-input" required class="form-select">
              <option value="">Select Rating</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
          </div>
          
          <div class="mb-3">
            <label for="review" class="form-label">Review:</label>
            <textarea name="review" id="review" placeholder="Write your review" maxlength="500" class="form-control"></textarea>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit Review</button>
        </div>
      </form>
    </div>
  </div>
</div>