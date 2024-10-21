<?php
require_once '../pages/private.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php
    include'../includes/headerLogin.php';
    ?>
    <h1>Login</h1>
    <form method="POST" action="../pages/login.php"> 
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <br><br>
        <label for="senha">Senha:</label>
        <input type="password" name="senha" required>
        <br><br>
        <button type="submit">Login</button>

        <p>Não tem conta? aproveite e <a href="../view/cliente/cadastroCliente.php">Cadastre-se</a></p>     
    </form>   
</body>
</html>
