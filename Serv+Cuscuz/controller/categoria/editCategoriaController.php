<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "../../../model/DTO/categoriaDTO.php";
require_once __DIR__ . "../../../model/DAO/categoriaDAO.php";

class CategoriaEditController {
    private $categoriaDAO;

    public function __construct() {
        $this->categoriaDAO = new CategoriaDAO();
    }

    public function execute($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Processa o envio do formulário
            $nome = $_POST['nome'];

            $categoriaDTO = new CategoriaDTO();
            $categoriaDTO->setId($id);
            $categoriaDTO->setNome($nome);

            if ($this->categoriaDAO->update($categoriaDTO)) {
                $_SESSION['successeditCategoria'] = "Categoria atualizada com sucesso!";
            } else {
                $_SESSION['erroreditCategoria'] = "Erro ao atualizar categoria!";
            }
            header("Location: ../../view/admin/categoria.php");
            exit;
        } else {
            // Busca e armazena os dados da categoria existente na sessão para preenchimento do formulário
            $categoria = $this->categoriaDAO->findById($id);
            
            if ($categoria) {
                $_SESSION['categoriaEditar'] = [
                    'id' => $categoria->getId(),
                    'nome' => $categoria->getNome()
                ];
                var_dump("Categoria recuperada:", $_SESSION['categoriaEditar']); // Depuração
                header("Location: ../../view/admin/editarCategoria.php");
                exit;
            } else {
                $_SESSION['errorCategoria'] = "Categoria não encontrada!";
                header("Location: ../../view/admin/categoria.php");
                exit;
            }
        }
    }
}

// Para iniciar o controlador
if (isset($_GET['token'])) {
    $id = base64_decode($_GET['token']); // Decodifica o token para obter o ID da categoria
    
    if ($id !== false) { // Verifica se a decodificação foi bem-sucedida
        $controller = new CategoriaEditController();
        $controller->execute($id);
    } else {
        $_SESSION['errorCategoria'] = "Token inválido!";
        header("Location: ../../view/admin/categoria.php");
        exit;
    }
} elseif (isset($_POST['id'])) {
    $controller = new CategoriaEditController();
    $controller->execute($_POST['id']);
}
