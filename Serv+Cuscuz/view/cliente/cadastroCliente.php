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
    <title>Páginan de Cadastro</title>
</head>
<body>
    <h1>Pagina de cadastro do cliente</h1> 
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
    <fieldset>
        <legend>Cadastro</legend>
        <form method="POST" action="../../controller/cliente/createClienteController.php">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" required>
            <br><br>
            <label for="sobrenome">Sobrenome:</label>
            <input type="text" name="sobrenome" required>
            <br><br>
            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" required>
                <?php if (isset($_SESSION['cpf_error'])): ?>
                        <span style="color:red;">
                            <?php echo $_SESSION['cpf_error']; ?>
                        </span>
                        <?php unset($_SESSION['cpf_error']); // Limpa a mensagem após exibi-la ?>
                <?php endif; ?>
            <br><br>
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <br><br>
            <label for="telefone">Telefone:</label>
            <input type="text" name="telefone" required>
            <br><br>
            <label for="senha">Senha:</label>
            <input type="password" name="senha" required>
            <br><br>

            <button type="submit">Cadastrar</button>
            <?php if (isset($_SESSION['success'])): ?>
                    <span style="color:green;">
                        <?php echo $_SESSION['success']; ?>
                    </span>
                    <?php unset($_SESSION['success']); // Limpa a mensagem após exibi-la ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <span style="color:red;">
                        <?php echo $_SESSION['error']; ?>
                    </span>
                    <?php unset($_SESSION['error']); // Limpa a mensagem após exibi-la ?>
                <?php endif; ?>
        </form>
    </fieldset>
<a href="../../view/pages/login.php">Ops, já tenho cadastro</a>
</body>
</html>
