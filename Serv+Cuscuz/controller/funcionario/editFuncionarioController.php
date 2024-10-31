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

// Verificar se o ID foi passado (no GET) para carregar dados do funcionário
$idFuncionario = $_GET['id'] ?? null;
if ($idFuncionario) {
    $funcionario = $funcionarioDAO->buscarFuncionarioPorId($idFuncionario);
    if (!$funcionario) {
        $_SESSION['erroreditFun'] = "Funcionário não encontrado.";
        header("Location: ../../view/admin/listaFuncionarios.php");
        exit();
    }
}

// Se for uma requisição POST, processar o formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar e obter dados do formulário
    $idFuncionario = $_POST['id'];
    $nomeFuncionario = strip_tags($_POST["nome"]);
    $cpfFuncionario = str_replace(['.', '-'], '', strip_tags($_POST["cpf"]));
    $emailFuncionario = strip_tags($_POST["email"]);
    $telefoneFuncionario = str_replace(['(', ')',' ','-'], '', strip_tags($_POST["telefone"]));
    $novaSenha = $_POST["senha"] ?? null; // Captura a nova senha (se fornecida)
    $t_perfil_idFuncionario = strip_tags($_POST["t_perfil_id"]);

    // Validações
    if (!ValidadorCPF::validar($cpfFuncionario)) {
        $_SESSION['cpf_error'] = "CPF inválido.";
        header("Location: ../../view/admin/editarFuncionario.php?id=$idFuncionario");
        exit();
    }

    // Se o usuário forneceu uma nova senha, valide-a
    if ($novaSenha && !validarSenha($novaSenha)) {
        $_SESSION['senha_error'] = "Nova senha inválida.";
        header("Location: ../../view/admin/editarFuncionario.php?id=$idFuncionario");
        exit();
    }

    // Se tudo estiver correto, prosseguir com a atualização
    $funcionarioDTO = new FuncionarioDTO();
    $funcionarioDTO->setId($idFuncionario);
    $funcionarioDTO->setNome($nomeFuncionario);
    $funcionarioDTO->setCpf($cpfFuncionario);
    $funcionarioDTO->setEmail($emailFuncionario);
    $funcionarioDTO->setTelefone($telefoneFuncionario);

    // Atualizar a senha apenas se uma nova senha for fornecida
    if ($novaSenha) {
        $funcionarioDTO->setSenha(password_hash($novaSenha, PASSWORD_DEFAULT));
    }

    $funcionarioDTO->setPerfilId($t_perfil_idFuncionario);

    // Atualizar no banco de dados
    $sucesso = $funcionarioDAO->atualizarFuncionario($funcionarioDTO);
    if ($sucesso) {
        $_SESSION['successeditFun'] = "Funcionário atualizado com sucesso!";
    } else {
        $_SESSION['erroreditFun'] = "Erro na atualização do funcionário.";
    }

    // Redirecionar
    header("Location: ../../view/admin/editarFuncionario.php?id=$idFuncionario");
    exit();
}

// Rredireciona para a pagina de edição
require_once '../../view/admin/editarFuncionario.php';