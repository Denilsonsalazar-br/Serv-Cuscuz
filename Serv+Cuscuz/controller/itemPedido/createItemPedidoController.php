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
    if (!isset($_POST['pedido_id']) || !is_numeric($_POST['pedido_id'])) {
        throw new Exception("ID do pedido não fornecido.");
    }

    // Sanitização e Validação dos dados recebidos
    $dados = [
        'pedido_id' => (int)$_POST['pedido_id'],
        'produto_id' => isset($_POST['produto_id']) ? (int)$_POST['produto_id'] : 0,
        'quantidade' => isset($_POST['quantidade']) ? (int)$_POST['quantidade'] : 1
    ];

    // Instancia o DTO e popula os dados
    $itemPedido = new ItemPedidoDTO();
    $itemPedido->setTPedidoId($dados['pedido_id']);
    $itemPedido->setTProdutoId($dados['produto_id']);
    $itemPedido->setQuantidade($dados['quantidade']);

    // Cria o item no pedido usando o DAO
    $itemPedidoDAO = new ItemPedidoDAO($pdo);
    $resultado = $itemPedidoDAO->create($itemPedido);

    if ($resultado) {
        // Mensagem de sucesso
        $_SESSION['msg'] = [
            'tipo' => 'sucessoItemPedido',
            'mensagem' => 'Item adicionado ao pedido com sucesso!'
        ];
    } else {
        throw new Exception('Erro ao adicionar item ao pedido.');
    }

    // Redireciona para a página de detalhes do pedido ou outra página de sua escolha
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
