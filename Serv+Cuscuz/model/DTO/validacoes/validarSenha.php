<?php
function validarSenha($senha, $config = []) {
    // Array com as configurações padrão
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

    if ($config['requerMaiuscula']) {
        $regex .= '(?=.*[A-Z])'; // Pelo menos uma letra maiúscula
    }
    if ($config['requerMinuscula']) {
        $regex .= '(?=.*[a-z])'; // Pelo menos uma letra minúscula
    }
    if ($config['requerNumero']) {
        $regex .= '(?=.*\d)'; // Pelo menos um dígito
    }
    if ($config['requerEspecial']) {
        $regex .= '(?=.*[' . preg_quote($config['caracteresEspeciais'], '/') . '])'; // Pelo menos um caractere especial
    }
    $regex .= '.{' . $config['minimoCaracteres'] . ',}$/';

    // Verificar a complexidade da senha
    if (!preg_match($regex, $senha)) {
        return 'A senha não atende aos requisitos de segurança. "No minio 8 caracteres, entre eles uma letra maiúscula, uma minúscula, um número, e um caractere especial." ';
    }

    // Verificar se a senha não contém o nome de usuário
    if (isset($_POST['nome']) && stripos($senha, $_POST['nome']) !== false) {
        return 'A senha não pode conter o nome de usuário.';
    }

    return true;
}