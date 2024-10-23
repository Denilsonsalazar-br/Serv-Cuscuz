<?Php
function validarSenha($senha) {
    // Define os requisitos mínimos para a senha
    $minimoCaracteres = 8;
    $requerMaiuscula = true;
    $requerMinuscula = true;
    $requerNumero = true;
    $requerEspecial = true;

    // Verificar a complexidade da senha
    $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%#*?&])[A-Za-z\d@$!%*?&]{' . $minimoCaracteres . ',}$/';

    // Verifica se a senha atende à expressão regular
    if (!preg_match($regex, $senha)) {
        return "A senha deve ter pelo menos 8 caracteres, incluindo letras maiúsculas e minúsculas, números e um caractere especial.";
    }

    // Verifica se a senha não contém o nome de usuario
    if (isset($_POST['nome']) && stripos($senha, $_POST['nome']) !== false) {
        return "Para sua segurança! <br> Evite digitar o seu nome como senha.";
    }

    // Se todas as verificações passarem, a senha é válida
    return true;
}