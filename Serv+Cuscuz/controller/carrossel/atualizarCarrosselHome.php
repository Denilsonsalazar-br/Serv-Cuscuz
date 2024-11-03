<?php

require_once __DIR__ . "../../carrossel/carrosselHomeController.php";
session_start(); // Inicie a sessão para poder usar $_SESSION

$controller = new CarrosselController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $imagem = $_FILES['imagem'];

    // Tente atualizar o item e armazene a mensagem na sessão
    if ($controller->atualizarItem($id, $titulo, $descricao, $imagem)) {
        $_SESSION['msg'] = [
            'tipo' => 'sucesso',
            'mensagem' => 'Produto atualizado com sucesso!'
        ];
    } else {
        $_SESSION['msg'] = [
            'tipo' => 'erro',
            'mensagem' => 'Falha ao atualizar o produto.'
        ];
    }

    header("Location: ../../view/admin/carrosselHome.php");
    exit();
}
