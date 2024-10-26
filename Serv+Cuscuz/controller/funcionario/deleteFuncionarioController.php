<?php
// Iniciar a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir os arquivos necessários
require_once __DIR__ . "../../../model/DAO/funcionarioDAO.php";

// Verificar se o ID do funcionário foi passado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $idFuncionario = $_POST['id'];
    $funcionarioDAO = new FuncionarioDAO();
    $sucesso = $funcionarioDAO->excluirFuncionario($idFuncionario); // Implemente esse método no DAO

    if ($sucesso) {
        $_SESSION['success'] = "Funcionário excluído com sucesso!";
    } else {
        $_SESSION['error'] = "Aconteceu algum imprevisto no processo de exclusão.";
    }

    // Redirecionar para a lista de funcionários
    header("Location: ../../controller/funcionario/readFuncionarioController.php");
    exit();
} else {
    $_SESSION['error'] = "Método inválido.";
    header("Location: ../../controller/funcionario/readFuncionarioController.php");
    exit();
}
