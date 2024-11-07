<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "../../../model/DAO/produtoDAO.php";

class DeleteProdutoController {
    private $produtoDAO;

    public function __construct() {
        $this->produtoDAO = new ProdutoDAO();
    }

    public function deleteProduto($idProduto) {
        return $this->produtoDAO->excluirProduto($idProduto);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idProduto = $_POST['id'] ?? null;
    
    if ($idProduto) {
        $controller = new DeleteProdutoController();
        $controller->deleteProduto($idProduto);
        
        // Redirecionar de volta para a página de produtos após a exclusão
        header("Location: ../../view/funcionario/produtos.php");
        exit;
    }
}