<section class="review-section">
    <h2>Leave a Review</h2>
    <p>We value your feedback! Please leave a review below and rate your experience with our website.</p>

    <div class="review-form-box">
        <form class="review-form" method="POST" action="/CardGenerator/controllers/ReviewController.php">
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name">
                <span id="name-error" class="error-message" style="color: red;"></span>
            </div>

            <div class="form-group">
                <label for="email">Your Email</label>
                <input type="text" id="email" name="email" placeholder="Enter your email">
                <span id="email-error" class="error-message" style="color: red;"></span>
            </div>

            <div class="form-group">
                <label for="description">Your Review</label>
                <textarea id="description" name="description" rows="6" placeholder="Write your review"></textarea>
                <span id="description-error" class="error-message" style="color: red;"></span>
            </div>

            <div class="form-group">
                <label for="rating">Rate Us</label>
                <div class="star-rating">
                    <input type="radio" id="star5" name="rating" value="5">
                    <label for="star5" title="5 stars">★</label>

                    <input type="radio" id="star4" name="rating" value="4">
                    <label for="star4" title="4 stars">★</label>

                    <input type="radio" id="star3" name="rating" value="3">
                    <label for="star3" title="3 stars">★</label>

                    <input type="radio" id="star2" name="rating" value="2">
                    <label for="star2" title="2 stars">★</label>

                    <input type="radio" id="star1" name="rating" value="1">
                    <label for="star1" title="1 star">★</label>
                </div>
                <span id="rating-error" class="error-message" style="color: red;"></span>
            </div>
            <button type="submit" class="review-submit-btn">Submit Review</button>
        </form>
    </div>

    <div id="thankYouModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2>Thank You!</h2>
            <p>Your feedback has been submitted successfully.</p>
        </div>
    </div>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const modal = document.getElementById("thankYouModal");
        const closeButton = document.querySelector(".close-button");

        if (urlParams.has('success')) {
            modal.style.display = "block"; 
            urlParams.delete('success'); 
            window.history.replaceState({}, document.title, window.location.pathname + '?' + urlParams.toString()); 
        }

        closeButton.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        document.querySelector('.review-form').addEventListener('submit', function(event) {
            let isValid = true;
            
            // Name validation (only letters and spaces allowed)
            const nameInput = document.getElementById('name');
            const nameError = document.getElementById('name-error');
            const nameRegex = /^[A-Za-z ]+$/;
            if (nameInput.value.trim() === '') {
                nameError.textContent = 'Name is required.';
                isValid = false;
            } else if (!nameRegex.test(nameInput.value.trim())) {
                nameError.textContent = 'Please enter a valid name (letters and spaces only).';
                isValid = false;
            } else {
                nameError.textContent = '';
            }
            
            // Email validation
            const emailInput = document.getElementById('email');
            const emailError = document.getElementById('email-error');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailInput.value.trim() === '') {
                emailError.textContent = 'Email is required.';
                isValid = false;
            } else if (!emailRegex.test(emailInput.value.trim())) {
                emailError.textContent = 'Please enter a valid email address.';
                isValid = false;
            } else {
                emailError.textContent = '';
            }

            // Description validation
            const descriptionInput = document.getElementById('description');
            const descriptionError = document.getElementById('description-error');
            if (descriptionInput.value.trim() === '') {
                descriptionError.textContent = 'Review description is required.';
                isValid = false;
            } else {
                descriptionError.textContent = '';
            }

            // Rating validation
            const ratingInputs = document.getElementsByName('rating');
            const ratingError = document.getElementById('rating-error');
            let ratingSelected = false;
            for (const ratingInput of ratingInputs) {
                if (ratingInput.checked) {
                    ratingSelected = true;
                    break;
                }
            }
            if (!ratingSelected) {
                ratingError.textContent = 'Rating is required.';
                isValid = false;
            } else {
                ratingError.textContent = '';
            }
            
            // Prevent form submission if validation fails
            if (!isValid) {
                event.preventDefault();
            }
        });
    </script>
</section>