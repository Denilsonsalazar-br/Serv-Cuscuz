let currentSlide = 0;
const slides = document.querySelectorAll('.carrossel-item');
const carrosselContainer = document.querySelector('.carrossel-container');

function showSlide(index) {
    const slideWidth = slides[0].clientWidth;
    carrosselContainer.style.transform = `translateX(-${index * slideWidth}px)`;
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % slides.length;
    showSlide(currentSlide);
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    showSlide(currentSlide);
}

// Inicializa o primeiro slide
showSlide(currentSlide);

window.addEventListener('resize', () => {
    showSlide(currentSlide);
});