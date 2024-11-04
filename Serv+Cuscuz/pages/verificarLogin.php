<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['id']) && isset($_SESSION['nome'])) {
    echo '<span class="user-name">' . htmlspecialchars($_SESSION['nome']) . '</span>';
} else {
    echo '<a href="../pages/login.php" class="login-link">Login</a>';
}
