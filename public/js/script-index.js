document.addEventListener('DOMContentLoaded', function() {
    const profileContainer = document.querySelector('.profile-container');
    const profileName = profileContainer.querySelector('.name');

    profileName.addEventListener('click', function() {
        profileContainer.classList.toggle('show');
    });

    document.addEventListener('click', function(event) {
        if (!profileContainer.contains(event.target)) {
            profileContainer.classList.remove('show');
        }
    });
});

// Carousel Functionality
const carousel = document.querySelector('.carousel');
const cards = document.querySelectorAll('.carousel-card');
const prevBtn = document.querySelector('.prev');
const nextBtn = document.querySelector('.next');

let currentIndex = 0;
const cardWidth = cards[0].offsetWidth;
const cardsToShow = 3;
const totalCards = cards.length;

// Clone cards for infinite scroll
cards.forEach(card => {
    const clone = card.cloneNode(true);
    carousel.appendChild(clone);
});

function updateCarousel() {
    carousel.style.transform = `translateX(-${currentIndex * (cardWidth + 32)}px)`;
}

function moveToNext() {
    currentIndex++;
    if (currentIndex >= totalCards) {
        setTimeout(() => {
            carousel.style.transition = 'none';
            currentIndex = 0;
            updateCarousel();
            setTimeout(() => {
                carousel.style.transition = 'transform 0.5s ease';
            }, 50);
        }, 500);
    }
    updateCarousel();
}

function moveToPrev() {
    currentIndex--;
    if (currentIndex < 0) {
        setTimeout(() => {
            carousel.style.transition = 'none';
            currentIndex = totalCards - 1;
            updateCarousel();
            setTimeout(() => {
                carousel.style.transition = 'transform 0.5s ease';
            }, 50);
        }, 500);
    }
    updateCarousel();
}

// Auto-scroll functionality
let autoScrollInterval = setInterval(moveToNext, 3000);

// Pause auto-scroll on hover
carousel.addEventListener('mouseenter', () => {
    clearInterval(autoScrollInterval);
});

carousel.addEventListener('mouseleave', () => {
    autoScrollInterval = setInterval(moveToNext, 3000);
});

// Button controls
nextBtn.addEventListener('click', () => {
    clearInterval(autoScrollInterval);
    moveToNext();
    autoScrollInterval = setInterval(moveToNext, 3000);
});

prevBtn.addEventListener('click', () => {
    clearInterval(autoScrollInterval);
    moveToPrev();
    autoScrollInterval = setInterval(moveToNext, 3000);
});

// Intersection Observer for Animations
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, {
    threshold: 0.1
});

document.querySelectorAll('.card').forEach(element => {
    element.style.opacity = '0';
    element.style.transform = 'translateY(20px)';
    observer.observe(element);
});
