<?php
require_once __DIR__ . "../../../controller/carrossel/carrosselHomeController.php";
session_start();

$controller = new CarrosselController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deletar_id'])) {
    $id = $_POST['deletar_id'];

    // Depuração: verificar se o ID foi recebido
    if (!$id) {
        $_SESSION['msg'] = [
            'tipo' => 'erro',
            'mensagem' => 'ID não recebido para exclusão.'
        ];
        header("Location: ../../view/admin/carrosselHome.php");
        exit();
    }

    // Tenta deletar o item
    if ($controller->deletarImagem($id)) {
        // Sucesso, a mensagem já foi definida no controller
    } else {
        // Caso ocorra erro
        $_SESSION['msg'] = [
            'tipo' => 'erro',
            'mensagem' => 'Erro ao excluir o item.'
        ];
    }

    // Redireciona para a página de edição após a exclusão
    header("Location: ../../view/admin/carrosselHome.php");
    exit();
} else {
    // Se a requisição não for POST ou não tiver o id para deletar
    $_SESSION['msg'] = [
        'tipo' => 'erro',
        'mensagem' => 'Requisição inválida.'
    ];
    header("Location: ../../view/admin/carrosselHome.php");
    exit();
}
