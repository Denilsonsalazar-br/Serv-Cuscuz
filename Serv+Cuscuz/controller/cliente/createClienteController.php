<?php
//var_dump($_POST);

// Habilitar exibição de erros
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir os arquivos necessários "DAO e DTO"
require_once __DIR__ . "../../../model/DAO/clienteDAO.php";
require_once __DIR__ . "../../../model/DTO/clienteDTO.php";
require_once __DIR__ . "../../../model/DTO/validacoes/validarCpf.php";

    $nomeCliente = strip_tags($_POST["nome"]);
    $sobrenomeCliente = strip_tags($_POST["sobrenome"]);
    $cpfCliente = strip_tags($_POST["cpf"]);
    $emailCliente = strip_tags($_POST["email"]);
    $telefoneCliente = strip_tags($_POST["telefone"]);
    $senhaCliente = password_hash($_POST["senha"], PASSWORD_DEFAULT);

    $clienteDTO = new ClienteDTO();
    $clienteDTO->setNome($nomeCliente);
    $clienteDTO->setSobrenome($sobrenomeCliente);
    $clienteDTO->setCpf($cpfCliente);
    $clienteDTO->setEmail($emailCliente);
    $clienteDTO->setTelefone($telefoneCliente);
    $clienteDTO->setSenha($senhaCliente);

    $ClienteDAO = new ClienteDAO();
    $sucesso = $ClienteDAO->cadastrarCliente($clienteDTO);
    //var_dump($clienteDTO);

    if($sucesso){
        $_SESSION['sucesso'] = " Seu Cadastro foi realizado com sucesso.<br> Bem vindo a familia Serv+Cuscuz!";
    } else {
        $_SESSION['error'] = "Desculpe, aconteceu algum imprevisto no seu cadastro. <br> Vamos tentar novamente";
    }
    // Redirecionar de volta para a página do funcionário
    header( "Location: ../../view/cliente/cadastroCliente.php");
    exit();

    // Validação do CPF
    if (!ValidadorCPF::validar($cliente->getCpf())) {
        $_SESSION['error'] = "CPF inválido.<br> Por favor, forneça um CPF verdadeiro!";
        echo "Vai redirecionar..."; // Para verificar se essa linha é executada
        header("Location: ../../view/cliente/cadastroCliente.php");
        exit();
    }
