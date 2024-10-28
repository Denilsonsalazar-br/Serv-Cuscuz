<!--pare aqui-->

<?php
// Habilitar exibição de erros
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir os arquivos necessários
require_once __DIR__ . "../../../model/DAO/funcionarioDAO.php";
require_once __DIR__ . "../../../model/DTO/funcionarioDTO.php";
require_once __DIR__ . "../../../model/DTO/validacoes/validarCpf.php";
require_once __DIR__ . "../../../model/DTO/validacoes/validarEmail.php";
require_once __DIR__ . "../../../model/DTO/validacoes/validarSenha.php"; 

// Função para coletar e sanitizar dados de entrada com strip_tags
function getPostData($key) {
    return isset($_POST[$key]) ? strip_tags($_POST[$key]) : null;
}

// Coletar os dados do formulário
$nomeFuncionario = getPostData("nome");
$cpfFuncionario = getPostData("cpf");
$emailFuncionario = getPostData("email");
$telefoneFuncionario = getPostData("telefone");
$senhaFuncionario = isset($_POST["senha"]) ? $_POST["senha"] : null; // a senha só vai ser criptografada após a verificação.
$t_perfil_idFuncionario = getPostData("t_perfil_id");

$cpfFuncionario = str_replace(['.', '-'], '', $cpfFuncionario);

$telefoneFuncionario = str_replace(['(', ')',' ','-'], '', $telefoneFuncionario);


// Verificação apenas dos campos obrigatórios para o banco de dados
if (!$nomeFuncionario || !$cpfFuncionario || !$emailFuncionario || !$telefoneFuncionario || !$senhaFuncionario || !$t_perfil_idFuncionario) {
    $_SESSION['error'] = "Todos os campos são obrigatórios.";
    header("Location: ../../view/admin/cadastroFuncionarios.php");
    exit();
}


// Validação do CPF
//var_dump($cpfFuncionario); 
if (!ValidadorCPF::validar($cpfFuncionario)) {
    $_SESSION['cpf_error'] = "CPF inválido. Por favor, forneça um CPF verdadeiro!";
    header("Location: ../../view/admin/cadastroFuncionarios.php");
    exit();
}

// Verifica se o CPF já está cadastrado
$funcionarioDAO = new FuncionarioDAO();
if (ValidadorCPF::cpfJaCadastradoFuncionario($cpfFuncionario, $funcionarioDAO->pdo)) {
    $_SESSION['cpf_error'] = "CPF já está cadastrado!";
    header("Location: ../../view/admin/cadastroFuncionarios.php");
    exit();
}

// Verifica se o e-mail já está cadastrado
if (ValidadorEmail::emailJaCadastradoFuncionario($emailFuncionario, $funcionarioDAO->pdo)) {
    $_SESSION['email_error'] = "E-mail já está cadastrado!";
    header("Location: ../../view/admin/cadastroFuncionarios.php");
    exit();
}

// Validação da senha
$senhaValidacao = validarSenha($senhaFuncionario);
if ($senhaValidacao !== true) {
    $_SESSION['senha_error'] = $senhaValidacao;
    header("Location: ../../view/admin/cadastroFuncionarios.php");
    exit();
}

// Criptografa a senha após validação
$senhaFuncionario = password_hash($senhaFuncionario, PASSWORD_DEFAULT);

// Criar objeto FuncionarioDTO e definir os dados
$funcionarioDTO = new FuncionarioDTO();
$funcionarioDTO->setNome($nomeFuncionario);
$funcionarioDTO->setCpf($cpfFuncionario);
$funcionarioDTO->setEmail($emailFuncionario);
$funcionarioDTO->setTelefone($telefoneFuncionario);
$funcionarioDTO->setSenha($senhaFuncionario);
$funcionarioDTO->setPerfilId($t_perfil_idFuncionario);

// Salvar dados no banco de dados
$sucesso = $funcionarioDAO->cadastrarFuncionario($funcionarioDTO);

if ($sucesso) {
    $_SESSION['sucesso'] = "Funcionário cadastrado com sucesso!";
} else {
    $_SESSION['error'] = "Aconteceu algum imprevisto no processo de cadastro.<br> Tente novamente!";
}

// Redirecionar de volta para a página de criação do funcionário
header("Location: ../../view/admin/cadastroFuncionarios.php");
exit();