<?php
session_start();

require_once __DIR__ . "../../../model/DAO/enderecoDAO.php";

try {
    $enderecoDAO = new EnderecoDAO();
    $dadosDashboard = $enderecoDAO->getDashboardData();

    $_SESSION['dadosDashboard'] = $dadosDashboard; // Armazena os dados para exibição
    $_SESSION['msg'] = [
        'tipo' => 'sucesso',
        'mensagem' => 'Dados do dashboard carregados com sucesso!'
    ];

    header('Location: ../../view/admin/dashboardEnderecos.php');
    exit();
} catch (Exception $e) {
    $_SESSION['msg'] = [
        'tipo' => 'erro',
        'mensagem' => $e->getMessage()
    ];
    header('Location: ../../view/admin/dashboardEnderecos.php');
    exit();
}
