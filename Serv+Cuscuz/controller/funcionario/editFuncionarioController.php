<?php
// Iniciar a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir os arquivos necessários
require_once "../../model/DAO/funcionarioDAO.php";
require_once "../../model/DTO/funcionarioDTO.php";

// Verificar se o ID do funcionário foi passado
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "ID do funcionário não fornecido.";
    header("Location: ../../controller/funcionario/readFuncionarioController.php");
    exit();
}

$idFuncionario = $_GET['id'];
$funcionarioDAO = new FuncionarioDAO();
$funcionario = $funcionarioDAO->buscarFuncionarioPorId($idFuncionario); // Implemente este método no DAO

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter dados do formulário
    $nomeFuncionario = strip_tags($_POST["nome"]);
    $cpfFuncionario = strip_tags($_POST["cpf"]);
    $emailFuncionario = strip_tags($_POST["email"]);
    $telefoneFuncionario = strip_tags($_POST["telefone"]);
    $senhaFuncionario = password_hash($_POST["senha"], PASSWORD_DEFAULT);
    $t_perfil_idFuncionario = strip_tags($_POST["t_perfil_id"]);

    // Atualizar DTO
    $funcionarioDTO = new FuncionarioDTO();
    $funcionarioDTO->setId($idFuncionario);
    $funcionarioDTO->setNome($nomeFuncionario);
    $funcionarioDTO->setCpf($cpfFuncionario);
    $funcionarioDTO->setEmail($emailFuncionario);
    $funcionarioDTO->setTelefone($telefoneFuncionario);
    $funcionarioDTO->setSenha($senhaFuncionario);
    $funcionarioDTO->setPerfilId($t_perfil_idFuncionario);

    // Atualizar funcionário
    $sucesso = $funcionarioDAO->atualizarFuncionario($funcionarioDTO); // Implemente esse método no DAO

    if ($sucesso) {
        $_SESSION['success'] = "Funcionário atualizado com sucesso!";
    } else {
        $_SESSION['error'] = "Aconteceu algum imprevisto no processo de atualização.";
    }

    // Redirecionar para a lista de funcionários
    header("Location: ../../controller/funcionario/readFuncionarioController.php");
    exit();
}

// Exibir a página de edição
require_once '../../view/admin/listaFuncionarios.php';
