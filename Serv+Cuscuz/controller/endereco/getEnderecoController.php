<?php
session_start();

require_once __DIR__ . "../../../model/DAO/enderecoDAO.php";

try {
    // Recebe os dados do formulário
    $dados = [
        'estado' => $_POST['estado'],
        'cidade' => $_POST['cidade'],
        'cep' => $_POST['cep'],
        'bairro' => $_POST['bairro'],
        'rua' => $_POST['rua'],
        'numero' => $_POST['numero'],
        'complemento' => $_POST['complemento']
    ];

    // Instancia o DTO e popula os dados
    $endereco = new EnderecoDTO();
    $endereco->setEstado($dados['estado']);
    $endereco->setCidade($dados['cidade']);
    $endereco->setCcep($dados['cep']);
    $endereco->setBairro($dados['bairro']);
    $endereco->setRua($dados['rua']);
    $endereco->setNumero($dados['numero']);
    $endereco->setComplemento($dados['complemento']);

    // Cria um endereço usando o DAO
    $enderecoDAO = new EnderecoDAO();
    $resultado = $enderecoDAO->create($endereco);

    if ($resultado) {
        // Mensagem de sucesso
        $_SESSION['msg'] = [
            'tipo' => 'sucesso',
            'mensagem' => 'Endereço cadastrado com sucesso!'
        ];
    } else {
        throw new Exception('Erro ao cadastrar o endereço.');
    }

    // Redireciona para a página desejada
    header('Location: ../../view/cliente/perfil.php');
    exit();
} catch (Exception $e) {
    // Mensagem de erro
    $_SESSION['msg'] = [
        'tipo' => 'erro',
        'mensagem' => $e->getMessage()
    ];

    // Redireciona para a página de cadastro
    header('Location: ../../view/cliente/perfil.php');
    exit();
}
