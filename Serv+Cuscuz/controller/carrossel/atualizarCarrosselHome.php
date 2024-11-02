<?php

require_once __DIR__ . "../../carrossel/carrosselHomeController.php";
$controller = new CarrosselController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $imagem = $_FILES['imagem'];

    $controller->atualizarItem($id, $titulo, $descricao, $imagem);
    header("Location: ../../view/admin/carrosselHome.php");
    exit();
}
