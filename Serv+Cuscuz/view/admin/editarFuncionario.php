<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Funcionário</title>
</head>
<body>
    <h1>Editar Funcionário</h1>
    <form action="../../controller/funcionario/editFuncionarioController.php?id=<?php echo $funcionario->getId(); ?>" method="POST">
        <label>Nome:</label>
        <input type="text" name="nome" value="<?php echo $funcionario->getNome(); ?>" required>
        <br>
        <label>CPF:</label>
        <input type="text" name="cpf" value="<?php echo $funcionario->getCpf(); ?>" required>
        <br>
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $funcionario->getEmail(); ?>" required>
        <br>
        <label>Telefone:</label>
        <input type="text" name="telefone" value="<?php echo $funcionario->getTelefone(); ?>" required>
        <br>
        <label>Senha:</label>
        <input type="password" name="senha" required>
        <br>
        <label>Perfil:</label>
        <select name="t_perfil_id">
            <option value="1" <?php echo $funcionario->getPerfilId() == 1 ? 'selected' : ''; ?>>Admin</option>
            <option value="2" <?php echo $funcionario->getPerfilId() == 2 ? 'selected' : ''; ?>>Funcionário</option>
        </select>
        <br>
        <button type="submit">Atualizar Funcionário</button>
    </form>
    <a href="../../controller/admin/adminPainelController.php">voltar</a>
</body>
</html>
