<?php

require_once __DIR__ . "../../../model/DAO/categoriaDAO.php";

class CategoriaListController {
        private $categoriaDAO;
    
        public function __construct() {
            $this->categoriaDAO = new CategoriaDAO();
        }
    
        public function execute() {
            // Recuperando categorias
            $categorias = $this->categoriaDAO->list();
            return $categorias;

        //var_dump($categorias); 
    }
}
