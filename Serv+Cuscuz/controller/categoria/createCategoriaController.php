<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "../../../model/DTO/categoriaDTO.php";
require_once __DIR__ . "../../../model/DAO/categoriaDAO.php";

class CategoriaCreateController {

    private $categoriaDAO;

    public function __construct() {
        $this->categoriaDAO = new CategoriaDAO();
    }

    public function execute() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome = $_POST['nome'];

            $categoriaDTO = new CategoriaDTO();
            $categoriaDTO->setNome($nome);

            if ($this->categoriaDAO->create($categoriaDTO)) {
                // Definir mensagem de sucesso na sessão
                $_SESSION['successCategoria'] = "Categoria criada com sucesso!";

                header("Location: ../../view/admin/categoria.php"); // Redireciona após sucesso
                exit();
            } else {
                // Definir mensagem de erro na sessão
                $_SESSION['errorCategoria'] = "Erro ao criar categoria!";

                header("Location: ../../view/admin/categoria.php"); // Redireciona após erro
                exit(); 
            }
        }
    }
}
