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
        'status_pagamento' => isset($_POST['status_pagamento']) ? htmlspecialchars($_POST['status_pagamento'], ENT_QUOTES, 'UTF-8') : '',
        'valor' => isset($_POST['valor']) ? (float)$_POST['valor'] : 0
    ];

    // Validação do valor do pagamento
    if ($dados['valor'] <= 0) {
        throw new Exception("O valor do pagamento deve ser maior que zero.");
    }

    // Instancia o DTO e popula os dados
    $pagamento = new PagamentoDTO();
    $pagamento->setId($dados['pagamento_id']);
    $pagamento->setStatusPagamento($dados['status_pagamento']);
    $pagamento->setValor($dados['valor']);

    // Atualiza o pagamento usando o DAO
    $pagamentoDAO = new PagamentoDAO($pdo);
    $resultado = $pagamentoDAO->update($pagamento);

    if ($resultado) {
        // Mensagem de sucesso
        $_SESSION['msg'] = [
            'tipo' => 'sucessoPagamento',
            'mensagem' => 'Pagamento atualizado com sucesso!'
        ];
    } else {
        throw new Exception('Erro ao atualizar o pagamento.');
    }

    // Redireciona para a página de detalhes do pedido ou outra página de sua escolha
    header('Location: ../../view/cliente/pagamentoConfirmado.php?id=' . $_POST['pedido_id']);
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