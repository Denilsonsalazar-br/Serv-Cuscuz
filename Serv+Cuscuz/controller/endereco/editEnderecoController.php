<?php
session_start();

require_once __DIR__ . "../../../model/DAO/enderecoDAO.php";
require_once __DIR__ . "../../../model/DTO/enderecoDTO.php";

try {
    $dados = [
        'id' => $_POST['id'],
        'estado' => $_POST['estado'],
        'cidade' => $_POST['cidade'],
        'cep' => $_POST['cep'],
        'bairro' => $_POST['bairro'],
        'rua' => $_POST['rua'],
        'numero' => $_POST['numero'],
        'complemento' => $_POST['complemento']
    ];

    $endereco = new EnderecoDTO();
    $endereco->setId($dados['id']);
    $endereco->setEstado($dados['estado']);
    $endereco->setCidade($dados['cidade']);
    $endereco->setCcep($dados['cep']);
    $endereco->setBairro($dados['bairro']);
    $endereco->setRua($dados['rua']);
    $endereco->setNumero($dados['numero']);
    $endereco->setComplemento($dados['complemento']);

    $enderecoDAO = new EnderecoDAO();
    $resultado = $enderecoDAO->update($endereco);

    if ($resultado) {
        $_SESSION['msg'] = [
            'tipo' => 'sucesso',
            'mensagem' => 'Endereço atualizado com sucesso!'
        ];
    } else {
        throw new Exception('Erro ao atualizar o endereço.');
    }

    header('Location: ../../view/cliente/perfil.php');
    exit();
} catch (Exception $e) {
    $_SESSION['msg'] = [
        'tipo' => 'erro',
        'mensagem' => $e->getMessage()
    ];
    header('Location: ../../view/cliente/perfil.php');
    exit();
}
