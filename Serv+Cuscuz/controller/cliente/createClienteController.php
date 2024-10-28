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
require_once __DIR__ . "../../../model/DTO/validacoes/validarSenha.php";
require_once __DIR__ . "../../../model/DTO/validacoes/validarEmail.php";

// Função para coletar e sanitizar dados de entrada com strip_tags
function getPostData($key) {
    return isset($_POST[$key]) ? strip_tags($_POST[$key]) : null;
}
    // Coletar os dados do formulário
    $nomeCliente = getPostData("nome");
    $sobrenomeCliente = getPostData("sobrenome");
    $cpfCliente = getPostData("cpf");
    $emailCliente = getPostData("email");
    $telefoneCliente = getPostData("telefone");
    $senhaCliente = isset($_POST["senha"]) ? $_POST["senha"] : null; // a senha só vai ser criptografada após a verificação.

    // Normaliza o CPF removendo pontos e traços
    $cpfCliente = str_replace(['.', '-'], '', $cpfCliente);

    $telefoneCliente = str_replace(['(', ')',' ','-'], '', $telefoneCliente);

    //var_dump($nomeCliente, $sobrenomeCliente, $cpfCliente, $emailCliente, $telefoneCliente, $senhaCliente);
    //exit(); 

    if(!$nomeCliente || !$sobrenomeCliente || !$cpfCliente || !$emailCliente || !$telefoneCliente || !$senhaCliente){
        $_SESSION ['error'] = "Por favor, preencha todos os campos.";
        header("Location: ../../view/cliente/cadastroCliente.php");
        exit();
    }

    // Validação do CPF
    if (!ValidadorCPF::validar($cpfCliente)) {
        $_SESSION['cpf_error'] = "CPF inválido. Por favor, forneça um CPF verdadeiro!";
        header("Location: ../../view/cliente/cadastroCliente.php");
        exit();
    }

    // Verifica se o CPF já está cadastrado
    $clienteDAO = new ClienteDAO();
    if (ValidadorCPF::cpfJaCadastradoCliente($cpfCliente, $clienteDAO->pdo)) {
        $_SESSION['cpf_error'] = "CPF já está cadastrado!";
        header("Location: ../../view/cliente/cadastroCliente.php");
        exit();
    }

    // Verifica se o e-mail já está cadastrado
    if (ValidadorEmail::emailJaCadastradoCliente($emailCliente, $clienteDAO->pdo)) {
        $_SESSION['email_error'] = "E-mail já está cadastrado!";
        header("Location: ../../view/cliente/cadastroCliente.php");
        exit();
    }

    // Validação da senha
    $senhaValidacao = validarSenha($senhaCliente);
    if ($senhaValidacao !== true) {
        $_SESSION['senha_error'] = $senhaValidacao;
        header("Location: ../../view/cliente/cadastroCliente.php");
        exit();
    }

    // Criptografa a senha após validação
    $senhaCliente = password_hash($senhaCliente, PASSWORD_DEFAULT);

    // Criar objeto FuncionarioDTO e definir os dados
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
    //exit();

    if($sucesso){
        $_SESSION['sucesso'] = " Seu Cadastro foi realizado com sucesso.<br> Bem vindo a familia Serv+Cuscuz!";
    } else {
        $_SESSION['error'] = "Desculpe, aconteceu algum imprevisto no seu cadastro. <br> Por favor, tente novamente.";
    }
    // Redirecionar de volta para a página do funcionário
    header( "Location: ../../view/cliente/cadastroCliente.php");
    exit();