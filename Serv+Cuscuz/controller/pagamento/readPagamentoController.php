<?php
session_start();

require_once __DIR__ . "../../../model/DAO/PagamentoDAO.php";
require_once __DIR__ . "../../../model/DTO/PagamentoDTO.php";

try {
    // Verifica se o ID do cliente está na sessão
    if (!isset($_SESSION['id']) || !is_numeric($_SESSION['id'])) {
        throw new Exception("ID do cliente não encontrado.");
    }

    // Verifica se o ID do pedido foi fornecido
    if (!isset($_GET['pedido_id']) || !is_numeric($_GET['pedido_id'])) {
        throw new Exception("ID do pedido não fornecido.");
    }

    // Recupera os pagamentos do pedido usando o DAO
    $pagamentoDAO = new PagamentoDAO($pdo);
    $pagamento = $pagamentoDAO->getAllByPedidoId($_GET['pedido_id']);

    if ($pagamento) {
        // Exibe o pagamento na página de detalhes
        $_SESSION['pagamento'] = $pagamento;
    } else {
        throw new Exception('Nenhum pagamento encontrado para este pedido.');
    }

    // Redireciona para a página de detalhes do pagamento ou outra página de sua escolha
    header('Location: ../../view/cliente/pagamentoDetalhes.php?id=' . $_GET['pedido_id']);
    exit();
} catch (Exception $e) {
    // Mensagem de erro
    $_SESSION['msg'] = [
        'tipo' => 'erroPagamento',
        'mensagem' => $e->getMessage()
    ];

    // Redireciona para a página de erro ou para a página anterior
    header('Location: ../../view/cliente/finalizarPedido.php');
    exit();
}
