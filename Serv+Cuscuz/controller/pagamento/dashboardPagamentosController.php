<?php
session_start();

require_once __DIR__ . "../../../model/DAO/PagamentoDAO.php";

try {
    // Verifica se o ID do cliente está na sessão
    if (!isset($_SESSION['id']) || !is_numeric($_SESSION['id'])) {
        throw new Exception("ID do cliente não encontrado.");
    }

    // Instancia o DAO
    $pagamentoDAO = new PagamentoDAO($pdo);

    // Obtém o valor bruto dos pagamentos aprovados no mês
    $valorBrutoPagamentos = $pagamentoDAO->getValorBrutoPagamentosNoMesEAno($mes, $ano, $statusPagamento = null);//Concertar depois...

    // Armazena os dados na sessão para uso posterior no front-end
    $_SESSION['valorBrutoPagamentos'] = $valorBrutoPagamentos;

    // Redireciona para a página do dashboard (onde o valor bruto será exibido)
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
?>
