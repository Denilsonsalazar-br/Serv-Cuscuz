<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/header.css">
    <title></title>
</head>

<body>
    <header>
        <nav class="nav-bar">
            <div class="logo" href="../pages/home.php">
                <a href="../pages/home.php">
                    <img src="../assets/img/logo-png-reduzida.png" alt="Serv+Cuscuz">
                </a>
            </div>
            <div class="nav-list">
                <ul>
                <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Quem somos</a></li>
                <!--<li class="nav-item"><a href="#" class="nav-link">Promoções</a></li>-->
                <li class="nav-item"><a href="#" class="nav-link">Promoções</a></li>
                </ul>
            </div>

            <div class="containerPerfilNome">
                <div class="nomeperfil">
                    <?php include '../pages/verificarLogin.php'; ?>
                </div>
                <div class="login-button">
                    <?php if (isset($_SESSION['id'])): ?>
                        <button><a href="../pages/logout.php">Sair</a></button>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mobile-menu-icon">
                <button onclick="menuShow()"><img class="icon" src="../assets/img/abrirMenu.png" alt=""></button>
            </div>
        </nav>
        <div class="mobile-menu">
            <ul>
                <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Quem somos?</a></li>
                <!--<li class="nav-item"><a href="#" class="nav-link">Promoções</a></li>-->
                <li class="nav-item"><a href="#" class="nav-link">Promoções</a></li>
            </ul>
            <div class="nomeperfil">
                    <?php include '../pages/verificarLogin.php'; ?>
            </div>
            <div class="login-button">
                    <?php if (isset($_SESSION['id'])): ?>
                        <button><a href="../pages/logout.php">Sair</a></button>
                    <?php endif; ?>
            </div>
        </div>
    </header>

    <script src="../assets/js/header.js"></script>
</body>

</html>