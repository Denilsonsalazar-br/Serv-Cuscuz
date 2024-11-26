<?php

session_start();  // Iniciar a sessão para usar variáveis de sessão

require_once __DIR__ . "../../../model/DAO/categoriaDAO.php";

class CategoriaDeleteController {

    private $categoriaDAO;

    public function __construct() {
        $this->categoriaDAO = new CategoriaDAO();
    }

    public function execute($id) {
        // Verifique se o ID é válido
        if ($this->categoriaDAO->delete($id)) {
            $_SESSION['successDeleteCategoria'] = "Categoria deletada com sucesso!";
        } else {
            $_SESSION['errorDeleteCategoria'] = "Não é possível deletar a categoria porque há produtos associados a ela!";
        }

        // Redireciona para a página de categorias
        header("Location: ../../view/admin/categoria.php");
        exit();
    }
}

// Verificar se o ID foi passado e executar a exclusão
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $controller = new CategoriaDeleteController();
    $controller->execute($id);
} else {
    // Se não houver um ID válido, redireciona para a página de categorias
    $_SESSION['errorCategoria'] = "ID de categoria inválido!";
    header("Location: ../../view/admin/categoria.php");
    exit();
}
