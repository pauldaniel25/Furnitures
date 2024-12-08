const ratingInput = document.getElementById('rating-input');
const ratingButtons = document.querySelectorAll('.rating-btn');

ratingButtons.forEach((button) => {
  button.addEventListener('click', (e) => {
    const selectedRating = e.target.getAttribute('data-rating');
    ratingInput.value = selectedRating;

    // Remove active class from all buttons
    ratingButtons.forEach((btn) => btn.classList.remove('active'));

    // Add active class to selected button
    e.target.classList.add('active');
  });
});