<?Php
function validarSenha($senha, $config = []) {
    //  array com os tipos de dados que poderão ser inseridos
    $config = array_merge([
        'minimoCaracteres' => 8,
        'requerMaiuscula' => true,
        'requerMinuscula' => true,
        'requerNumero' => true,
        'requerEspecial' => true,
        'caracteresEspeciais' => '@$!%*?&_-#+',
    ], $config);

    // Gerar a expressão regular com base nas configurações
    $regex = '/^';
    if ($config['requerMaiuscula']) $regex .= '(?=.*[A-Z])';
    if ($config['requerMinuscula']) $regex .= '(?=.*[a-z])';
    if ($config['requerNumero']) $regex .= '(?=.*\d)';
    if ($config['requerEspecial']) $regex .= "(?=.*[$config[caracteresEspeciais]])";
    $regex .= ".{$config['minimoCaracteres']},$/";

    // Verificar a complexidade da senha
    if (!preg_match($regex, $senha)) {
        return 'A senha não atende aos requisitos de segurança.';
    }

    // Verifica se a senha não contém o nome de usuário
    if (isset($_POST['nome']) && stripos($senha, $_POST['nome']) !== false) {
        return 'A senha não pode conter o nome de usuário.';
    }
    return true;
}