<?php

class EnderecoDTO{
    private $id;
    private $estado;
    private $cidade;
    private $cep;
    private $bairro;
    private $rua;
    private $numero;
    private $complemento;
    private $cliente_id;

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function getEstado() {
        return $this->estado;
    }
    public function setEstado($estado) {
        $this->estado = $estado;
    }   
    public function getCidade() {
        return $this->cidade;
    }
    public function setCidade($cidade) {
        $this->cidade = $cidade;
    }
    public function getCcep() {
        return $this->cep;
    }
    public function setCcep($cep) {
        $this->cep = $cep;
    }
    public function getBairro() {
        return $this->bairro;
    }
    public function setBairro($bairro) {
        $this->bairro = $bairro;
    }
    public function getRua() {
        return $this->rua;
    }
    public function setRua($rua) {
        $this->rua = $rua;
    }
    public function getNumero() {
        return $this->numero;
    }
    public function setNumero($numero) {
        $this->numero = $numero;
    }
    public function getComplemento() {
        return $this->complemento;
    }
    public function setComplemento($complemento) {
        $this->complemento = $complemento;
    }
    public function setClienteId($cliente_id) {
        $this->cliente_id = $cliente_id;
    }

    public function getClienteId() {
        return $this->cliente_id;
    }
    
}