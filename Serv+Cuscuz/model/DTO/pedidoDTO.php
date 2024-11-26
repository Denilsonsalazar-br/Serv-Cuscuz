<?php
require_once __DIR__ . "../../DAO/src/conexaobd.php";
class PedidoDTO {
    private $id;
    private $data;
    private $status;
    private $entregaDomicilio;
    private $precoTotal;
    private $tClienteId;

    // Getters e Setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getEntregaDomicilio() {
        return $this->entregaDomicilio;
    }

    public function setEntregaDomicilio($entregaDomicilio) {
        $this->entregaDomicilio = $entregaDomicilio;
    }

    public function getPrecoTotal() {
        return $this->precoTotal;
    }

    public function setPrecoTotal($precoTotal) {
        $this->precoTotal = $precoTotal;
    }

    public function getTClienteId() {
        return $this->tClienteId;
    }

    public function setTClienteId($tClienteId) {
        $this->tClienteId = $tClienteId;
    }
}