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

    // Adiciona a troca automática de slides
    let autoSlideInterval = setInterval(() => nextSlide(), 5000); // Troca de slide a cada 5 segundos

    // Função para parar a troca automática
    function stopAutoSlide() {
        clearInterval(autoSlideInterval);
    }

    // Retoma a troca automática ao sair do carrossel
    function startAutoSlide() {
        autoSlideInterval = setInterval(() => nextSlide(), 5000);
    }

    // Pausa a troca automática ao passar o mouse sobre o carrossel
    const carrossel = document.querySelector('.carrossel');
    carrossel.addEventListener('mouseover', stopAutoSlide);
    carrossel.addEventListener('mouseleave', startAutoSlide);
}