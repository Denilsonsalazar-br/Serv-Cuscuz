<?php
session_start();

require_once __DIR__ . "../../../model/DAO/ItemPedidoDAO.php";
require_once __DIR__ . "../../../model/DTO/ItemPedidoDTO.php";

try {
    // Verifica se o ID do cliente está na sessão
    if (!isset($_SESSION['id']) || !is_numeric($_SESSION['id'])) {
        throw new Exception("ID do cliente não encontrado.");
    }

    // Verifica se o ID do pedido foi fornecido
    if (!isset($_GET['pedido_id']) || !is_numeric($_GET['pedido_id'])) {
        throw new Exception("ID do pedido não fornecido.");
    }

    // Recupera os itens do pedido usando o DAO
    $itemPedidoDAO = new ItemPedidoDAO($pdo);
    $itens = $itemPedidoDAO->getAllByPedidoId($_GET['pedido_id']);

    if ($itens) {
        // Exibe os itens na página de detalhes do pedido
        $_SESSION['itensPedido'] = $itens;
    } else {
        throw new Exception('Nenhum item encontrado para este pedido.');
    }

    // Redireciona para a página de detalhes do pedido
    header('Location: ../../view/cliente/detalhesPedido.php?id=' . $_GET['pedido_id']);
    exit();
} catch (Exception $e) {
    // Mensagem de erro
    $_SESSION['msg'] = [
        'tipo' => 'erroItemPedido',
        'mensagem' => $e->getMessage()
    ];

    // Redireciona para a página de erro ou para a página anterior
    header('Location: ../../view/cliente/detalhesPedido.php?id=' . $_GET['pedido_id']);
    exit();
}