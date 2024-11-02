<?php
// Iniciar a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir arquivos necessários
require_once __DIR__ . "../../../model/DAO/funcionarioDAO.php";
require_once __DIR__ . "../../../model/DTO/funcionarioDTO.php";
require_once __DIR__ . "../../../model/DTO/validacoes/validarCpf.php";
require_once __DIR__ . "../../../model/DTO/validacoes/validarSenha.php";

// Instanciar o DAO
$funcionarioDAO = new FuncionarioDAO();

// Função auxiliar para redirecionamento com mensagem de erro
function redirecionarComErro($sessaoErro, $mensagemErro, $idFuncionario) {
    $_SESSION[$sessaoErro] = $mensagemErro;
    header("Location: ../../view/admin/editarFuncionario.php?token=" . urlencode(base64_encode($idFuncionario)));
    exit();
}

// Verificar se o ID foi passado (no GET) para carregar dados do funcionário
$token = $_GET['token'] ?? null;
$idFuncionario = $token ? base64_decode($token) : null; // Decodifica o token

if ($idFuncionario) {
    $funcionario = $funcionarioDAO->buscarFuncionarioPorId($idFuncionario);
    if (!$funcionario) {
        redirecionarComErro('erroreditFun', "Funcionário não encontrado.", $idFuncionario);
    }
}

// Se for uma requisição POST, processar o formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar e obter dados do formulário
    $idFuncionario = $_POST['id'];
    $nomeFuncionario = strip_tags($_POST["nome"]);
    $cpfFuncionario = str_replace(['.', '-'], '', strip_tags($_POST["cpf"]));
    $emailFuncionario = strip_tags($_POST["email"]);
    $telefoneFuncionario = str_replace(['(', ')', ' ', '-'], '', strip_tags($_POST["telefone"]));
    $novaSenha = $_POST["senha"] ?? null;
    $confirmarSenha = $_POST["confirmarSenha"] ?? null;
    $t_perfil_idFuncionario = strip_tags($_POST["t_perfil_id"]);

    // Validação de CPF
    if (!ValidadorCPF::validar($cpfFuncionario)) {
        redirecionarComErro('cpf_error', "CPF inválido.", $idFuncionario);
    }

    // Verifica se o CPF já está cadastrado, exceto para o próprio funcionário
    if ($funcionarioDAO->cpfJaCadastrado($cpfFuncionario, $idFuncionario)) {
        redirecionarComErro('cpf_error', "O CPF já está cadastrado.", $idFuncionario);
    }

    // Validação de e-mail
    if ($funcionarioDAO->verificarEmailExistente($emailFuncionario, $idFuncionario)) {
        redirecionarComErro('email_error', "O e-mail já está cadastrado.", $idFuncionario);
    }

    // Validação de senha
    if (!empty($novaSenha)) {
        if ($novaSenha !== $confirmarSenha) {
            redirecionarComErro('senha_error', "As senhas não coincidem.", $idFuncionario);
        }

        $senhaValidacao = validarSenha($novaSenha);
        if ($senhaValidacao !== true) {
            redirecionarComErro('senha_error', $senhaValidacao, $idFuncionario);
        }
    }

    // Preparar DTO para atualização
    $funcionarioDTO = new FuncionarioDTO();
    $funcionarioDTO->setId($idFuncionario);
    $funcionarioDTO->setNome($nomeFuncionario);
    $funcionarioDTO->setCpf($cpfFuncionario);
    $funcionarioDTO->setEmail($emailFuncionario);
    $funcionarioDTO->setTelefone($telefoneFuncionario);
    $funcionarioDTO->setPerfilId($t_perfil_idFuncionario);

    // Atualiza a senha apenas se uma nova senha for fornecida
    if (!empty($novaSenha)) {
        $funcionarioDTO->setSenha(password_hash($novaSenha, PASSWORD_DEFAULT));
    }

    try {
        // Atualiza o funcionário no banco de dados
        $funcionarioDAO->atualizarFuncionario($funcionarioDTO);
        $_SESSION['successeditFun'] = "Funcionário atualizado com sucesso!";
        header("Location: ../../view/admin/listaFuncionarios.php");
        exit();
    } catch (Exception $e) {
        redirecionarComErro('email_error', $e->getMessage(), $idFuncionario);
    }
}

// Redireciona para a página de edição
require_once '../../view/admin/editarFuncionario.php';
