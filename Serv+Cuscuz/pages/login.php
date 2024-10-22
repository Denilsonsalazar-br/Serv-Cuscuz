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
                require_once '../pages/private.php';
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

                    <p>Não tem conta? <a href="../view/cliente/cadastroCliente.php">Cadastre-se</a></p>     
                </form>
            </div>
        </main>
        <!--<footer>
            <?php
            //require_once'../includes/footer.php';
            ?> 
        </footer>-->
</body>
</html>
