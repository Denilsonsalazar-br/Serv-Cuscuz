// Função para abrir o modal
function openLoginModal() {
    document.getElementById('loginModal').style.display = 'block';
}

// Função para fechar o modal
function closeLoginModal() {
    document.getElementById('loginModal').style.display = 'none';
}

// Função para redirecionar para a página de login
function redirectToLogin() {
    window.location.href = '/login.php';
}
