<?php

// Iniciar a sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "../../../model/DAO/PedidoDAO.php";
require_once __DIR__ . "../../../model/DTO/PedidoDTO.php";
include '../../model/DAO/src/conexaobd.php';

try {
    // Verifica o perfil do usuário
    if (isset($_SESSION['perfil']) && $_SESSION['perfil'] === 'FUNCIONARIO') {
        // Se for um funcionário, não há necessidade de verificar o ID do cliente
        $pdo = Conexao::getInstance();
        $pedidoDAO = new PedidoDAO($pdo);
        $pedidos = $pedidoDAO->getAll(); // Aqui você pode usar getAll para todos os pedidos, não filtrando por cliente
    } elseif (isset($_SESSION['id']) && is_numeric($_SESSION['id'])) {
        // Se for um cliente, pega os pedidos dele
        $pdo = Conexao::getInstance();
        $pedidoDAO = new PedidoDAO($pdo);
        $pedidos = $pedidoDAO->getAllByClienteId($_SESSION['id']);
    } else {
        throw new Exception("ID do cliente ou perfil não encontrado.");
    }

    if ($pedidos) {
        // Exibe os pedidos na página
        $_SESSION['pedidos'] = $pedidos;
    } else {
        throw new Exception('Nenhum pedido encontrado.');
    }

} catch (Exception $e) {
    // Mensagem de erro
    $_SESSION['msg'] = [
        'tipo' => 'erroPedido',
        'mensagem' => $e->getMessage()
    ];

    // Redireciona para a página de erro ou para a página anterior
    if ($_SESSION['perfil'] === 'FUNCIONARIO') {
        header('Location: ../../view/funcionario/pedidos.php');
    } else {
        header('Location: ../../view/cliente/perfil.php');
    }
    exit();
}
