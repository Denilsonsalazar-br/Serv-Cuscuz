<?php
//var_dump($_POST);

// Habilitar exibição de erros
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir os arquivos necessários
require_once "../../model/DAO/funcionarioDAO.php";
require_once "../../model/DTO/funcionarioDTO.php";
require_once "../../model/DTO/validacoes/validarCpf.php";

    $nomeFuncionario = strip_tags($_POST["nome"]);
    $cpfFuncionario = strip_tags($_POST["cpf"]);
    $emailFuncionario = strip_tags($_POST["email"]);
    $telefoneFuncionario = strip_tags($_POST["telefone"]);
    $senhaFuncionario = password_hash($_POST["senha"],PASSWORD_DEFAULT);
    $t_perfil_idFuncionario = strip_tags($_POST["t_perfil_id"]);

    $funcionarioDTO = new FuncionarioDTO();
    $funcionarioDTO->setNome($nomeFuncionario);
    $funcionarioDTO->setCpf($cpfFuncionario);
    $funcionarioDTO->setEmail($emailFuncionario);
    $funcionarioDTO->setTelefone($telefoneFuncionario);
    $funcionarioDTO->setSenha($senhaFuncionario);
    $funcionarioDTO->setPerfilId($t_perfil_idFuncionario);

    $funcionarioDAO = new FuncionarioDAO();
    $sucesso = $funcionarioDAO->cadastrarFuncionario($funcionarioDTO);
    //var_dump($funcionarioDTO);

    if ($sucesso) {
        $_SESSION['sucesso'] = "Funcionário cadastrado com sucesso!";
    } else {
        $_SESSION['error'] = "Aconteceu algum imprevisto no processo de cadastro. <br> tente novamente!";
    }
    // Redirecionar de volta para a página de criação do funcionário
    header("Location: ../../view/admin/cadastroFuncionarios.php");
    exit();

    // Validação do CPF
    if (!ValidadorCPF::validar($funcionario->getCpf())) {
        $_SESSION['cpf_error'] = "CPF inválido.<br> Por favor, forneça um CPF verdadeiro!";
        echo "Vai redirecionar..."; // Para verificar se essa linha é executada
        header("Location: ../../view/admin/cadastroFuncionarios.php");
        exit();
    }
