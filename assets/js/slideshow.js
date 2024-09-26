let slideIndex = 1;
let slideInterval;

document.addEventListener("DOMContentLoaded", function () {
    showSlides(slideIndex); // Show the first slide only on load
    startSlideShow(); // Start the automatic slideshow
});

// Function to start the automatic slideshow
function startSlideShow() {
    slideInterval = setInterval(() => changeSlide(1), 3000); // Change slide every 2 seconds
}

// Next/previous controls
function changeSlide(n) {
    clearInterval(slideInterval); // Clear the automatic slideshow interval
    showSlides(slideIndex += n);
    startSlideShow(); // Restart the automatic slideshow after manual navigation
}

// Thumbnail image controls
function setCurrentSlide(n) {
    clearInterval(slideInterval); // Clear the automatic slideshow interval
    showSlides(slideIndex = n);
    startSlideShow(); // Restart the automatic slideshow after manual navigation
}

function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("slide");
    let dots = document.getElementsByClassName("dot");

    // Wrap around the slide index
    if (n > slides.length) { slideIndex = 1 }
    if (n < 1) { slideIndex = slides.length }

    // Hide all slides
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none"; // Hide each slide
    }

    // Remove "active" class from all dots
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }

    // Display the current slide
    slides[slideIndex - 1].style.display = "block"; // Show the current slide

    // Highlight the current dot
    dots[slideIndex - 1].className += " active";
}
