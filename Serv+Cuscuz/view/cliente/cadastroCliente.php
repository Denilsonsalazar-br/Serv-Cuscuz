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
    <link rel="stylesheet" href="../../assets/css/headerCadastro.css">
    <link rel="stylesheet" href="../../assets/css/cadastroCliente.css">
    <title>Páginan de Cadastro</title>
</head>
<body>
    <?php 
        include '../../includes/headerCadastro.php';
    ?>
    <main>
    <div class="tituloCadastroCliente">
        <h1>Serv+Cuscuz</h1> 
        <h3>"Mais sabor, mais praticidade!"</h3>
    </div>
    
    <!--Mensagem de sucesso-->
    <?php if (isset($_SESSION['sucesso'])): ?>
        <span style="color:green;">
            <?php echo $_SESSION['sucesso']; ?>
        </span>
        <?php unset($_SESSION['sucesso']); // Limpa a mensagem após exibi-la ?>
    <?php endif; ?>
    <!--Mensagem de erro-->

    <?php if (isset($_SESSION['error'])): ?>
        <span style="color:red;">
            <?php echo $_SESSION['error']; ?>
        </span>
        <?php unset($_SESSION['error']); // Limpa a mensagem após exibi-la ?>
    <?php endif; ?>

        <div class="containerCadastroCliente">
            <div class="containerFormulario">
                <form method="POST" action="../../controller/cliente/createClienteController.php">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" placeholder=""  required>
                    <br><br>
                    <label for="sobrenome">Sobrenome:</label>
                    <input type="text" name="sobrenome" placeholder=""  required>
                    <br><br>
                    <label for="cpf">CPF:</label>
                    <input type="text" name="cpf" placeholder=""  required>
                    <br><br>
                    <label for="email">Email:</label>
                    <input type="email" name="email" placeholder=""  required>
                    <br><br>
                    <label for="confirmarEmail">Confirme o Email:</label>
                    <input type="email" name="confirmarEmail" placeholder=""  required>
                    <br><br>
                    <label for="telefone">Telefone:</label>
                    <input type="text" name="telefone" placeholder=""  required>
                    <br><br>
                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" placeholder=""  required>
                    <br><br>
                    <label for="confirmarSenha">Confirme a Senha:</label>
                    <input type="password" name="confirmarSenha" placeholder=""  required>
                    <br><br>
                    <div class="termos">
                        <input type="checkbox" id="termos" required>
                        <label for="termos">Aceito os <a href="#">termos e condições</a></label>
                    </div>
                    <br><br>
                    <button type="submit">Cadastrar</button>
                </form>
            </div>
            <button><a href="../../pages/login.php">Ops, já tenho cadastro</a></button>
        </div>
</main>
</body>
</html>
