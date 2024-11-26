<?php
session_start();

require_once __DIR__ . "../../../model/DAO/PedidoDAO.php";
require_once __DIR__ . "../../../model/DTO/PedidoDTO.php";

try {
    // Verifica se o ID do cliente está na sessão
    if (!isset($_SESSION['id']) || !is_numeric($_SESSION['id'])) {
        throw new Exception("ID do cliente não encontrado.");
    }

    // Verifica se o ID do pedido foi fornecido
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        throw new Exception("ID do pedido não fornecido.");
    }

    // Sanitização e Validação dos dados recebidos
    $dados = [
        'id' => (int)$_POST['id'],
        'status' => isset($_POST['status']) ? htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8') : 'PENDENTE',
        'entrega_domicilio' => isset($_POST['entrega_domicilio']) ? (int)$_POST['entrega_domicilio'] : 0,
        'preco_total' => isset($_POST['preco_total']) ? (float)$_POST['preco_total'] : 0
    ];

    // Instancia o DTO e popula os dados
    $pedido = new PedidoDTO();
    $pedido->setId($dados['id']);
    $pedido->setStatus($dados['status']);
    $pedido->setEntregaDomicilio($dados['entrega_domicilio']);
    $pedido->setPrecoTotal($dados['preco_total']);
    $pedido->setTClienteId($_SESSION['id']); // Passa o ID do cliente da sessão

    // Edita o pedido usando o DAO
    $pedidoDAO = new PedidoDAO($pdo);
    $resultado = $pedidoDAO->update($pedido);

    if ($resultado) {
        // Mensagem de sucesso
        $_SESSION['msg'] = [
            'tipo' => 'sucessoPedido',
            'mensagem' => 'Pedido atualizado com sucesso!'
        ];
    } else {
        throw new Exception('Erro ao atualizar o pedido.');
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