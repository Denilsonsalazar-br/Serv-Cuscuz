<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Confirmar Exclusão</title>
</head>
<body>
    <h1>Confirmar Exclusão</h1>
    <p>Tem certeza que deseja excluir este funcionário?</p>
    <form action="../../controller/funcionario/deleteFuncionarioController.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $funcionario['id']; ?>">
        <button type="submit">Sim</button>
        <a href="../../controller/funcionario/readFuncionarioController.php">Não</a>
    </form>
</body>
</html>
