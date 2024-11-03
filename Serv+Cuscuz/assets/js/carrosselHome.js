let currentSlide = 0;
const slides = document.querySelectorAll('.carrossel-item');
const carrosselContainer = document.querySelector('.carrossel-container');

if (slides.length > 0) {
    // Adiciona uma transição suave ao container (caso não esteja no CSS)
    carrosselContainer.style.transition = 'transform 0.5s ease';

    function showSlide(index) {
        // Garante que o índice do slide está dentro do intervalo
        currentSlide = (index + slides.length) % slides.length;
        const slideWidth = slides[0].clientWidth;
        carrosselContainer.style.transform = `translateX(-${currentSlide * slideWidth}px)`;
    }

    function nextSlide() {
        showSlide(currentSlide + 1);
    }

    function prevSlide() {
        showSlide(currentSlide - 1);
    }

    // Inicializa o primeiro slide
    showSlide(currentSlide);

    // Ajusta o slide atual ao redimensionar a janela
    window.addEventListener('resize', () => {
        showSlide(currentSlide);
    });
}