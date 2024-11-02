<?php
// Iniciar a sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/login.css">
    <title>Login</title>
</head>
<body>
        <header>
            <?php
            require_once'../includes/headerLogin.php';
            ?>
        </header>
        <main>
            <div class="container"> 
            <?php
                require_once __DIR__ . "../../private/private.php";
            ?>  
                <div class="titulo">
                    <!--<span class="loader"></span>-->
                    <h1>Login</h1>
                </div>
                <div class="form-container">
                    <form method="POST" action="../pages/login.php"> 
                        <label for="email">Email</label>
                        <input type="email" name="email" placeholder="Digite seu email" required>
                        <br><br>
                        <label for="senha">Senha</label>
                        <input type="password" name="senha" placeholder="Digite sua senha" required>
                        <br><br>
                        <button type="submit">Login</button>
                        <div class="cadastre-se">
                            <p>Não tem conta? <a href="../view/cliente/cadastroCliente.php">Cadastre-se</a></p>
                        </div>    
                    </form>
                </div>
            </div>
        </main>
        <footer>
            <?php
            include '../includes/footer.php';
            ?> 
        </footer>
</body>
</html>
