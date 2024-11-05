<?php
// Iniciar a sessão, caso ainda não tenha sido iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "../../../controller/produto/readProdutoController.php";

// Verificar se o ID do produto foi passado pela URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idProduto = $_GET['id'];
    $readProdutoController = new ReadProdutoController();
    $produto = $readProdutoController->getProdutoById($idProduto);

    // Verifica se o produto foi encontrado
    if (!$produto) {
        echo "<p>Produto não encontrado.</p>";
        exit;
    }
} else {
    echo "<p>ID do produto não foi especificado.</p>";
    exit;
}
