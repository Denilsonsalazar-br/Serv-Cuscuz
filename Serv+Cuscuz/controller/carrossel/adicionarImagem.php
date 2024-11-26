<?php
require_once __DIR__ . "../../../controller/carrossel/carrosselHomeController.php";
session_start();

$controller = new CarrosselController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $imagem = $_FILES['imagem'];

    if ($controller->adicionarItem($titulo, $descricao, $imagem)) {
        $_SESSION['msg'] = [
            'tipo' => 'sucesso',
            'mensagem' => 'Nova imagem adicionada ao carrossel com sucesso!'
        ];
    }

    header("Location: ../../view/admin/carrosselHome.php");
    exit();
}
