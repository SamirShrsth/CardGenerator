<section class="main-content">
    <div class="left-content">
        <h1>Create Your Card</h1>
        <p>Create professional and high-quality cards in a matter of minutes! Whether you need business or ID cards, our system lets you design and generate the perfect card quickly and easily. You can also request an official ID card from your institution!</p>
        <div class="home-button">
            <a href="#" class="create-card-btn">Create a Card</a>
            <a href="#" class="create-card-btn">View Templates</a>
        </div>
    </div>

    <!-- Slideshow (Right Content) -->
    <div class="right-content">
        <div class="slideshow-container">
            <div class="slide">
                <img src="./assets/img/templates/template1.jpg" alt="Template 1">
            </div>
            <div class="slide">
                <img src="./assets/img/templates/template2.jpg" alt="Template 2">
            </div>
            <div class="slide">
                <img src="./assets/img/templates/template3.jpg" alt="Template 3">
            </div>
            <div class="slide">
                <img src="./assets/img/templates/template4.jpg" alt="Template 4">
            </div>
    
        </div>
        <div class="navigation-buttons">
            <!-- Next/Prev buttons below the images -->
            <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
            <!-- Dots for navigation -->
            <div class="dots-container">
                <span class="dot" onclick="setCurrentSlide(1)"></span>
                <span class="dot" onclick="setCurrentSlide(2)"></span>
                <span class="dot" onclick="setCurrentSlide(3)"></span>
                <span class="dot" onclick="setCurrentSlide(4)"></span>
            </div>
            <a class="next" onclick="changeSlide(1)">&#10095;</a>
        </div>
    </div>
</section>