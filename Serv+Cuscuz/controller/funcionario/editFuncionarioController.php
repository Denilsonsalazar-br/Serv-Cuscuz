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
$token = $_GET['token'] ?? null; 
$idFuncionario = $token ? base64_decode($token) : null; // Decodifica o token

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
        header("Location: ../../view/admin/editarFuncionario.php?token=" . urlencode(base64_encode($idFuncionario)));
        exit();
    }

    // Verifica se o CPF já está cadastrado, exceto para o próprio funcionário
    if ($funcionarioDAO->cpfJaCadastrado($cpfFuncionario, $idFuncionario)) {
        $_SESSION['cpf_error'] = "O CPF já está cadastrado.";
        header("Location: ../../view/admin/editarFuncionario.php?token=" . urlencode(base64_encode($idFuncionario)));
        exit();
    }

    // Se o usuário forneceu uma nova senha, valide-a
    if ($novaSenha && !validarSenha($novaSenha)) {
        $_SESSION['senha_error'] = "Nova senha inválida.";
        header("Location: ../../view/admin/editarFuncionario.php?token=" . urlencode(base64_encode($idFuncionario)));
        exit();
    }

    // Verifica se o e-mail já está cadastrado, exceto para o próprio funcionário
    if ($funcionarioDAO->verificarEmailExistente($emailFuncionario, $idFuncionario)) {
        $_SESSION['email_error'] = "O e-mail já está cadastrado.";
        header("Location: ../../view/admin/editarFuncionario.php?token=" . urlencode(base64_encode($idFuncionario)));
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
        // Aqui é onde garantimos que a nova senha é hashada corretamente
        $funcionarioDTO->setSenha(password_hash($novaSenha, PASSWORD_DEFAULT));
    }

    $funcionarioDTO->setPerfilId($t_perfil_idFuncionario);

    try {
        // Atualiza o funcionário no banco de dados
        $funcionarioDAO->atualizarFuncionario($funcionarioDTO);
        // Redireciona para a lista de funcionários após a edição
        $_SESSION['successeditFun'] = "Funcionário atualizado com sucesso!";
        header("Location: ../../view/admin/listaFuncionarios.php");
        exit();
    } catch (Exception $e) {
        $_SESSION['email_error'] = $e->getMessage(); // Mensagem de erro para o usuário
        header("Location: ../../view/admin/editarFuncionario.php?token=" . urlencode(base64_encode($idFuncionario)));
        exit();
    }
}

// Redireciona para a página de edição
require_once '../../view/admin/editarFuncionario.php';