<?php
session_start();

require_once __DIR__ . "../../../model/DAO/PagamentoDAO.php";
require_once __DIR__ . "../../../model/DTO/PagamentoDTO.php";

try {
    // Verifica se o ID do cliente está na sessão
    if (!isset($_SESSION['id']) || !is_numeric($_SESSION['id'])) {
        throw new Exception("ID do cliente não encontrado.");
    }

    // Verifica se o ID do pagamento foi fornecido
    if (!isset($_POST['pagamento_id']) || !is_numeric($_POST['pagamento_id'])) {
        throw new Exception("ID do pagamento não fornecido.");
    }

    // Sanitização e Validação dos dados recebidos
    $dados = [
        'pagamento_id' => (int)$_POST['pagamento_id'],
        'pedido_id' => isset($_POST['pedido_id']) ? (int)$_POST['pedido_id'] : 0
    ];

    // Instancia o DAO e deleta o pagamento
    $pagamentoDAO = new PagamentoDAO($pdo);
    $resultado = $pagamentoDAO->delete($dados['pagamento_id']);

    if ($resultado) {
        // Mensagem de sucesso
        $_SESSION['msg'] = [
            'tipo' => 'sucessoPagamento',
            'mensagem' => 'Pagamento removido com sucesso!'
        ];
    } else {
        throw new Exception('Erro ao remover o pagamento.');
    }

    // Redireciona para a página de detalhes do pedido
    header('Location: ../../view/cliente/detalhesPedido.php?id=' . $dados['pedido_id']);
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