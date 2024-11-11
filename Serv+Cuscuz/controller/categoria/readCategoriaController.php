<?php


require_once __DIR__ . "../../../model/DAO/categoriaDAO.php";

class CategoriaListController {

    private $categoriaDAO;

    public function __construct() {
        $this->categoriaDAO = new CategoriaDAO();
    }

    public function execute() {
        $categorias = $this->categoriaDAO->list();
        // Aqui você pode exibir as categorias em formato HTML ou JSON
        foreach ($categorias as $categoria) {
            echo "ID: " . $categoria['id'] . " - Nome: " . $categoria['nome'] . "<br>";
        }
    }
}
