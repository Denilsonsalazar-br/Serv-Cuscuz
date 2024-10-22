<?php
// Iniciar a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir o controlador que carrega os funcionários
require_once "../../controller/funcionario/readFuncionarioController.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Funcionarios</title>
</head>
<body>
    <h1>Lista de Funcionários</h1>
    <table border="1px">
        <tr border="1px">
            <th>ID</th>
            <th>Nome</th>
            <th>Cpf</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Senha</th>
            <th>Tipo Perfil</th>
        </tr>
        <?php if (isset($funcionarios) && is_array($funcionarios)): ?>
            <?php foreach ($funcionarios as $funcionario): ?>
            <tr>
                <td><?php echo htmlspecialchars($funcionario['id']); ?></td>
                <td><?php echo htmlspecialchars($funcionario['nome']); ?></td>
                <td><?php echo htmlspecialchars($funcionario['cpf']); ?></td>
                <td><?php echo htmlspecialchars($funcionario['email']); ?></td>
                <td><?php echo htmlspecialchars($funcionario['telefone']); ?></td>
                <td><?php echo htmlspecialchars($funcionario['senha']); ?></td>
                <td><?php echo htmlspecialchars($funcionario['t_perfil_id']); ?></td>          
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Nenhum funcionário encontrado.</td>
            </tr>
        <?php endif; ?>
    </table>
    <a href="../../controller/admin/adminPainelController.php">Voltar</a>
</body>
</html>
