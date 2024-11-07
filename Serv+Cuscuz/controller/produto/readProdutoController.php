<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . ".../../../model/DAO/produtoDAO.php";

class ReadProdutoController {
    private $produtoDAO;

    public function __construct() {
        $this->produtoDAO = new ProdutoDAO();
    }

    public function getProdutoById($id) {
        // Retorna o produto com o ID fornecido
        return $this->produtoDAO->getProdutoById($id);
    }

    public function getAllProdutos() {
        // Retorna todos os produtos
        return $this->produtoDAO->getAllProdutos();
    }
}