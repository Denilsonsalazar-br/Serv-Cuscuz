<?php
session_start();

require_once __DIR__ . "../../../model/DAO/ItemPedidoDAO.php";
require_once __DIR__ . "../../../model/DTO/ItemPedidoDTO.php";

try {
    // Verifica se o ID do cliente está na sessão
    if (!isset($_SESSION['id']) || !is_numeric($_SESSION['id'])) {
        throw new Exception("ID do cliente não encontrado.");
    }

    // Verifica se o ID do item foi fornecido
    if (!isset($_POST['item_id']) || !is_numeric($_POST['item_id'])) {
        throw new Exception("ID do item não fornecido.");
    }

    // Sanitização e Validação dos dados recebidos
    $dados = [
        'item_id' => (int)$_POST['item_id'],
        'pedido_id' => isset($_POST['pedido_id']) ? (int)$_POST['pedido_id'] : 0
    ];

    // Instancia o DAO e deleta o item
    $itemPedidoDAO = new ItemPedidoDAO($pdo);
    $resultado = $itemPedidoDAO->delete($dados['item_id']);

    if ($resultado) {
        // Mensagem de sucesso
        $_SESSION['msg'] = [
            'tipo' => 'sucessoItemPedido',
            'mensagem' => 'Item removido do pedido com sucesso!'
        ];
    } else {
        throw new Exception('Erro ao remover item do pedido.');
    }

    // Redireciona para a página de detalhes do pedido
    header('Location: ../../view/cliente/detalhesPedido.php?id=' . $dados['pedido_id']);
    exit();
} catch (Exception $e) {
    // Mensagem de erro
    $_SESSION['msg'] = [
        'tipo' => 'erroItemPedido',
        'mensagem' => $e->getMessage()
    ];

    // Redireciona para a página de erro ou para a página anterior
    header('Location: ../../view/cliente/detalhesPedido.php?id=' . $dados['pedido_id']);
    exit();
}