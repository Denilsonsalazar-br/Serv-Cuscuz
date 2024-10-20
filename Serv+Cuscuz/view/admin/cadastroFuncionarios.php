<?php
// Iniciar a sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Funcionário</title>
</head>
<body>
    <h1>Cadastrar Funcionário</h1>
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
        <form method="POST" action="../../controller/funcionario/createFuncionarioController.php">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" required>
            <br><br>
            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" required>
                <?php if (isset($_SESSION['cpf_error'])): ?>
                    <span style="color:red;"><?php echo $_SESSION['cpf_error']; ?></span>
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
            <label for="t_perfil_id">Perfil:</label>
            <select name="t_perfil_id" required>
                <option value="1">Administrador</option>
                <option value="2">Funcionário</option>
            </select>
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
    <a href="../../controller/admin/adminPainelController.php">voltar</a>
</body>
</html>
