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
    if (!isset($_POST['pedido_id']) || !is_numeric($_POST['pedido_id'])) {
        throw new Exception("ID do pedido não fornecido.");
    }

    // Sanitização e Validação dos dados recebidos
    $dados = [
        'pedido_id' => (int)$_POST['pedido_id'],
        'valor' => isset($_POST['valor']) ? (float)$_POST['valor'] : 0,
        'status_pagamento' => isset($_POST['status_pagamento']) ? htmlspecialchars($_POST['status_pagamento'], ENT_QUOTES, 'UTF-8') : '',
        'forma_pagamento' => isset($_POST['forma_pagamento']) ? (int)$_POST['forma_pagamento'] : 0
    ];

    // Validação do valor do pagamento
    if ($dados['valor'] <= 0) {
        throw new Exception("O valor do pagamento deve ser maior que zero.");
    }

    // Instancia o DTO e popula os dados
    $pagamento = new PagamentoDTO();
    $pagamento->setTPedidoId($dados['pedido_id']);
    $pagamento->setValor($dados['valor']);
    $pagamento->setStatusPagamento($dados['status_pagamento']);
    $pagamento->setFormaPagamento($dados['forma_pagamento']);

    // Cria o pagamento usando o DAO
    $pagamentoDAO = new PagamentoDAO($pdo);
    $resultado = $pagamentoDAO->create($pagamento);

    if ($resultado) {
        // Mensagem de sucesso
        $_SESSION['msg'] = [
            'tipo' => 'sucessoPagamento',
            'mensagem' => 'Pagamento registrado com sucesso!'
        ];
    } else {
        throw new Exception('Erro ao registrar o pagamento.');
    }

    // Redireciona para a página de pagamento ou outra página de sua escolha
    header('Location: ../../view/cliente/pagamentoConfirmado.php?id=' . $dados['pedido_id']);
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
