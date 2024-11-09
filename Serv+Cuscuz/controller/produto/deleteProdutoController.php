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
        try {
            $controller = new DeleteProdutoController();
            $controller->deleteProduto($idProduto);
            
            // Mensagem de sucesso
            $_SESSION['msg'] = [
                'tipo' => 'sucesso',
                'mensagem' => 'Produto excluído com sucesso!'
            ];
        } catch (Exception $e) {
            // Mensagem de erro
            $_SESSION['msg'] = [
                'tipo' => 'erro',
                'mensagem' => $e->getMessage()
            ];
        }
        
        // Redirecionar de volta para a página de produtos após a exclusão
        header("Location: ../../view/admin/produtos.php");
        exit;
    }
}