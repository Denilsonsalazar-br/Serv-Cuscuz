<?php
// Iniciar a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir o controlador que carrega os clientes
require_once "../../controller/cliente/readClienteController.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
</head>
<body>
    <h1>Lista de Clientes</h1>
    <table border="1px">
        <tr border="1px">
            <th>ID</th>
            <th>Nome</th>
            <th>Sobrenome</th>
            <th>Cpf</th>
            <th>Email</th>
            <th>Telefone</th>
        </tr>
        <?php if (isset($clientes) && is_array($clientes)): ?>
            <?php foreach ($clientes as $cliente): ?>
            <tr>
                <td><?php echo htmlspecialchars($cliente['id']); ?></td>
                <td><?php echo htmlspecialchars($cliente['nome']); ?></td>
                <td><?php echo htmlspecialchars($cliente['sobrenome']); ?></td>
                <td><?php echo htmlspecialchars($cliente['cpf']); ?></td>
                <td><?php echo htmlspecialchars($cliente['email']); ?></td>
                <td><?php echo htmlspecialchars($cliente['telefone']); ?></td>       
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