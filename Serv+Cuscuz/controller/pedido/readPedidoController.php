<?php
session_start();

require_once __DIR__ . "../../../model/DAO/PedidoDAO.php";
require_once __DIR__ . "../../../model/DTO/PedidoDTO.php";

try {
    // Verifica se o ID do cliente está na sessão
    if (!isset($_SESSION['id']) || !is_numeric($_SESSION['id'])) {
        throw new Exception("ID do cliente não encontrado.");
    }

    // Instancia o DAO
    $pedidoDAO = new PedidoDAO($pdo);

    // Recupera todos os pedidos do cliente
    $pedidos = $pedidoDAO->getAllByClienteId($_SESSION['id']);

    if ($pedidos) {
        // Exibe os pedidos na página
        $_SESSION['pedidos'] = $pedidos;
    } else {
        throw new Exception('Nenhum pedido encontrado.');
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