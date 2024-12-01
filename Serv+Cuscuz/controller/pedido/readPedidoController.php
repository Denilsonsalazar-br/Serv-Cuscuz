<?php

// Iniciar a sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "../../../model/DAO/PedidoDAO.php";
require_once __DIR__ . "../../../model/DTO/PedidoDTO.php";
include '../../model/DAO/src/conexaobd.php';

try {
    $pdo = Conexao::getInstance();
    $pedidoDAO = new PedidoDAO($pdo);

    // Verifica o perfil do usuário
    if (isset($_SESSION['perfil']) && $_SESSION['perfil'] === 'FUNCIONARIO') {
        // Funcionário: obtém todos os pedidos com os nomes dos clientes
        $pedidos = $pedidoDAO->getAll();
    } elseif (isset($_SESSION['id']) && is_numeric($_SESSION['id'])) {
        // Cliente: obtém apenas os pedidos dele com seu nome
        $pedidos = $pedidoDAO->getAllByClienteId($_SESSION['id']);
    } else {
        throw new Exception("Usuário não autorizado ou ID inválido.");
    }

    // Configura os pedidos na sessão
    $_SESSION['pedidos'] = $pedidos ? $pedidos : []; // Array vazio se não houver pedidos

} catch (Exception $e) {
    // Configura pedidos como vazio e adiciona mensagem de erro
    $_SESSION['pedidos'] = [];
    $_SESSION['msg'] = [
        'tipo' => 'erroPedido',
        'mensagem' => $e->getMessage()
    ];
}