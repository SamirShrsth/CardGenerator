let slideIndex = 1;
let slideInterval;

document.addEventListener("DOMContentLoaded", function () {
    showSlides(slideIndex); // Show the first slide on load
    startSlideShow(); // Start the automatic slideshow
});

function startSlideShow() {
    slideInterval = setInterval(() => changeSlide(1), 3000); // Change slide every 3 seconds
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
    let slides = document.getElementsByClassName("slide");
    let dots = document.getElementsByClassName("dot");

    if (n > slides.length) { slideIndex = 1 }
    if (n < 1) { slideIndex = slides.length }

    for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove("active", "prev-slide", "next-slide");
    }

    let prevIndex = slideIndex - 2 < 0 ? slides.length - 1 : slideIndex - 2;
    let nextIndex = slideIndex % slides.length;

    slides[slideIndex - 1].classList.add("active");
    slides[prevIndex].classList.add("prev-slide");
    slides[nextIndex].classList.add("next-slide");

    for (let i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    dots[slideIndex - 1].className += " active";
}

