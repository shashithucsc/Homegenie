let currentSlide = 0;
let slideInterval;

function showSlide(index) {
    const slides = document.querySelectorAll('.carousel-image');
    const indicators = document.querySelectorAll('.indicator');
    
    if (index >= slides.length) {
        currentSlide = 0;
    } else if (index < 0) {
        currentSlide = slides.length - 1;
    } else {
        currentSlide = index;
    }

    slides.forEach((slide, i) => {
        slide.classList.remove('active');
        if (i === currentSlide) {
            slide.classList.add('active');
        }
    });

    indicators.forEach((indicator, i) => {
        indicator.classList.remove('active');
        if (i === currentSlide) {
            indicator.classList.add('active');
        }
    });
}

function changeSlide(direction) {
    console.log("Changing slide, direction:", direction); // Debug
    showSlide(currentSlide + direction);
}

function startCarousel() {
    console.log("Carousel started"); // Debug
    slideInterval = setInterval(() => {
        console.log("Moving to next slide"); // Debug
        changeSlide(1);
    }, 3000); // Change slide every 3 seconds
}

document.addEventListener('DOMContentLoaded', () => {
    console.log("DOM loaded, starting carousel"); // Debug
    startCarousel();
});
