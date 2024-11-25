<?php
session_start();

require_once __DIR__ . "../../../model/DAO/enderecoDAO.php";
require_once __DIR__ . "../../../model/DTO/enderecoDTO.php";

try {
    // Recebe os dados do formulário e valida
    $dados = [
        'estado' => htmlspecialchars($_POST['estado']),
        'cidade' => htmlspecialchars($_POST['cidade']),
        'cep' => htmlspecialchars($_POST['cep']),
        'bairro' => htmlspecialchars($_POST['bairro']),
        'rua' => htmlspecialchars($_POST['rua']),
        'numero' => htmlspecialchars($_POST['numero']),
        'complemento' => htmlspecialchars($_POST['complemento']),
    ];

    if (!preg_match('/^[0-9]{5}-?[0-9]{3}$/', $dados['cep'])) {
        throw new Exception("CEP inválido.");
    }

    // Verifica se o ID do endereço foi enviado
    if (!isset($_POST['endereco_id']) || !is_numeric($_POST['endereco_id'])) {
        throw new Exception("ID do endereço não encontrado.");
    }

    // Preenche o DTO com os dados
    $endereco = new EnderecoDTO();
    $endereco->setEstado($dados['estado']);
    $endereco->setCidade($dados['cidade']);
    $endereco->setCep($dados['cep']);
    $endereco->setBairro($dados['bairro']);
    $endereco->setRua($dados['rua']);
    $endereco->setNumero($dados['numero']);
    $endereco->setComplemento($dados['complemento']);
    $endereco->setId($_POST['endereco_id']);

    // Atualiza o endereço no banco
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

    // Redireciona para a página de pagamento
    header('Location: ../../view/cliente/pagamento.php');
    exit();
} catch (Exception $e) {
    // Salva mensagem de erro na sessão
    $_SESSION['msg'] = [
        'tipo' => 'erro',
        'mensagem' => $e->getMessage()
    ];

    // Redireciona para a página de pagamento
    header('Location: ../../view/cliente/pagamento.php');
    exit();
}