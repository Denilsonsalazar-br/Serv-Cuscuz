<?php
session_start();

require_once __DIR__ . "../../../model/DAO/PedidoDAO.php";

try {
    // Verifica se o ID do cliente está na sessão
    if (!isset($_SESSION['id']) || !is_numeric($_SESSION['id'])) {
        throw new Exception("ID do cliente não encontrado.");
    }

    // Instancia o DAO
    $pedidoDAO = new PedidoDAO($pdo);

    // Obtém as métricas de pedidos
    $pedidosPorDia = $pedidoDAO->countPedidosPorPeriodo();
    $pedidosPorSemana = $pedidoDAO->countPedidosPorPeriodo();
    $pedidosPorQuinzena = $pedidoDAO->countPedidosPorPeriodo();
    $pedidosPorMes = $pedidoDAO->countPedidosPorPeriodo();

    // Armazena os dados na sessão para uso posterior no front-end
    $_SESSION['dashboardPedidos'] = [
        'pedidosPorDia' => $pedidosPorDia,
        'pedidosPorSemana' => $pedidosPorSemana,
        'pedidosPorQuinzena' => $pedidosPorQuinzena,
        'pedidosPorMes' => $pedidosPorMes
    ];

    // Redireciona para a página do dashboard (onde as métricas serão exibidas)
    header('Location: ../../view/admin/dashboard.php');
    exit();
} catch (Exception $e) {
    // Mensagem de erro
    $_SESSION['msg'] = [
        'tipo' => 'erroDashboard',
        'mensagem' => $e->getMessage()
    ];

    // Redireciona para a página de erro ou para outra página apropriada
    header('Location: ../../view/admin/dashboard.php');
    exit();
}