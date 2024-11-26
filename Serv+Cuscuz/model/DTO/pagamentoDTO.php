<?php

require_once __DIR__ . "../../DAO/src/conexaobd.php";
class PagamentoDTO {
    private $id;
    private $valor;
    private $data;
    private $statusPagamento;
    private $formaPagamento;
    private $tPedidoId;

    // Getters e Setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getValor() {
        return $this->valor;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function getStatusPagamento() {
        return $this->statusPagamento;
    }

    public function setStatusPagamento($statusPagamento) {
        $this->statusPagamento = $statusPagamento;
    }

    public function getFormaPagamento() {
        return $this->formaPagamento;
    }

    public function setFormaPagamento($formaPagamento) {
        $this->formaPagamento = $formaPagamento;
    }

    public function getTPedidoId() {
        return $this->tPedidoId;
    }

    public function setTPedidoId($tPedidoId) {
        $this->tPedidoId = $tPedidoId;
    }
}
