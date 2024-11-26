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
        'quantidade' => isset($_POST['quantidade']) ? (int)$_POST['quantidade'] : 1
    ];

    // Instancia o DTO e popula os dados
    $itemPedido = new ItemPedidoDTO();
    $itemPedido->setId($dados['item_id']);
    $itemPedido->setQuantidade($dados['quantidade']);

    // Edita o item no pedido usando o DAO
    $itemPedidoDAO = new ItemPedidoDAO($pdo);
    $resultado = $itemPedidoDAO->update($itemPedido);

    if ($resultado) {
        // Mensagem de sucesso
        $_SESSION['msg'] = [
            'tipo' => 'sucessoItemPedido',
            'mensagem' => 'Quantidade do item atualizada com sucesso!'
        ];
    } else {
        throw new Exception('Erro ao atualizar item no pedido.');
    }

    // Redireciona para a página de detalhes do pedido
    header('Location: ../../view/cliente/detalhesPedido.php?id=' . $_POST['pedido_id']);
    exit();
} catch (Exception $e) {
    // Mensagem de erro
    $_SESSION['msg'] = [
        'tipo' => 'erroItemPedido',
        'mensagem' => $e->getMessage()
    ];

    // Redireciona para a página de erro ou para a página anterior
    header('Location: ../../view/cliente/detalhesPedido.php?id=' . $_POST['pedido_id']);
    exit();
}