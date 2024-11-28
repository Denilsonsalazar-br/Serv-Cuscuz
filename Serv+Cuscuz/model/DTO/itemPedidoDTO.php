<?php
require_once __DIR__ . "../../DAO/src/conexaobd.php";

class ItemPedidoDTO {
    private $id;
    private $quantidade;
    private $tPedidoId;
    private $tProdutoId;

    // Getters e Setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getQuantidade() {
        return $this->quantidade;
    }

    public function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }

    public function getTPedidoId() {
        return $this->tPedidoId;
    }

    public function setTPedidoId($tPedidoId) {
        $this->tPedidoId = $tPedidoId;
    }

    public function getTProdutoId() {
        return $this->tProdutoId;
    }

    public function setTProdutoId($tProdutoId) {
        $this->tProdutoId = $tProdutoId;
    }
}