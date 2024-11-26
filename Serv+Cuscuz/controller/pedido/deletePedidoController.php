<?php
session_start();

require_once __DIR__ . "../../../model/DAO/PedidoDAO.php";
require_once __DIR__ . "../../../model/DTO/PedidoDTO.php";

try {
    // Verifica se o ID do cliente está na sessão
    if (!isset($_SESSION['id']) || !is_numeric($_SESSION['id'])) {
        throw new Exception("ID do cliente não encontrado.");
    }

    // Verifica se o ID do pedido foi fornecido
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        throw new Exception("ID do pedido não fornecido.");
    }

    // Sanitização e Validação dos dados recebidos
    $dados = [
        'id' => (int)$_POST['id']
    ];

    // Instancia o DAO e deleta o pedido
    $pedidoDAO = new PedidoDAO($pdo);
    $resultado = $pedidoDAO->delete($dados['id']);

    if ($resultado) {
        // Mensagem de sucesso
        $_SESSION['msg'] = [
            'tipo' => 'sucessoPedido',
            'mensagem' => 'Pedido deletado com sucesso!'
        ];
    } else {
        throw new Exception('Erro ao deletar o pedido.');
    }

    // Redireciona para a página de pedidos ou outra página de sua escolha
    header('Location: ../../view/cliente/meusPedidos.php');
    exit();
} catch (Exception $e) {
    // Mensagem de erro
    $_SESSION['msg'] = [
        'tipo' => 'erroPedido',
        'mensagem' => $e->getMessage()
    ];

    // Redireciona para a página de erro ou para a página anterior
    header('Location: ../../view/cliente/meusPedidos.php');
    exit();
}