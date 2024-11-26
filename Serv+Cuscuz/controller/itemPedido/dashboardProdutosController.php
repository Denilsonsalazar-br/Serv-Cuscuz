<?php
session_start();

require_once __DIR__ . "../../../model/DAO/ItemPedidoDAO.php";

try {
    // Verifica se o ID do cliente está na sessão
    if (!isset($_SESSION['id']) || !is_numeric($_SESSION['id'])) {
        throw new Exception("ID do cliente não encontrado.");
    }

    // Instancia o DAO
    $itemPedidoDAO = new ItemPedidoDAO($pdo);

    // Obtém o produto mais vendido
    $produtoMaisVendido = $itemPedidoDAO->getProdutoMaisVendido();

    // Armazena os dados na sessão para uso posterior no front-end
    $_SESSION['produtoMaisVendido'] = $produtoMaisVendido;

    // Redireciona para a página do dashboard (onde o produto mais vendido será exibido)
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