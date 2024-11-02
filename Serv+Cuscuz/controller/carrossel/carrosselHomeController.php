<?php
require_once __DIR__ . "../../../model/DAO/carrosselHomeDAO.php";

class CarrosselController {
    private $carrosselDAO;

    public function __construct() {
        $this->carrosselDAO = new CarrosselDAO();
    }

    public function listarItens() {
        return $this->carrosselDAO->listarItens();
    }

    public function atualizarItem($id, $titulo, $descricao, $imagem) {
        $item = $this->carrosselDAO->buscarItemPorId($id); // Presumindo que você tem buscarItemPorId() no DAO

        if ($imagem['name']) { // Se uma nova imagem foi enviada
            $imagemUrl = 'caminho_das_imagens/' . basename($imagem['name']);
            move_uploaded_file($imagem['tmp_name'], $imagemUrl);
            $item->setImagemUrl($imagemUrl);
        }

        $item->setTitulo($titulo);
        $item->setDescricao($descricao);

        return $this->carrosselDAO->atualizarItem($item);
    }
}