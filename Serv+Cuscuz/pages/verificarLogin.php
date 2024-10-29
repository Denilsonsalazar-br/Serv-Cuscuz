<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['id']) && isset($_SESSION['nome'])) {
    echo '<img src="../assets/img/usuarioBranco.png" alt="Ícone do usuário" class="user-icon">';
    echo '<span class="user-name">' . htmlspecialchars($_SESSION['nome']) . '</span>';
} else {
    echo '<a href="../pages/login.php" class="login-link">Login</a>';
}
