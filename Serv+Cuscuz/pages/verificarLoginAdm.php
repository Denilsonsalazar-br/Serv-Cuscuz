<?php
// Verifica se a sessão está ativa e se o usuário está logado
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['id']);
?>

<?php if ($isLoggedIn): ?>
    <div class="login-button">
        <a href="../../pages/logoutAdm.php">Sair</a>
    </div>
<?php else: ?>
    <div class="login-button">
        <a href="../../pages/login.php">Login</a>
    </div>
<?php endif; ?>