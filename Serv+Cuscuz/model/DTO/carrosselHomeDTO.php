<?php

require_once __DIR__ . "../../DAO/src/conexaobd.php";
class CarrosselDTO {
    private $id;
    private $imagemUrl;
    private $titulo;
    private $descricao;

    public function getId() {
         return $this->id; 
    }
    public function setId($id) { 
        $this->id = $id; 
    }

    public function getImagemUrl() {
         return $this->imagemUrl; 
    }
    public function setImagemUrl($imagemUrl) { 
        $this->imagemUrl = $imagemUrl; 
    }

    public function getTitulo() {
         return $this->titulo; 
    }
    public function setTitulo($titulo) {
         $this->titulo = $titulo; 
    }

    public function getDescricao() {
         return $this->descricao; 
    }
    public function setDescricao($descricao) {
         $this->descricao = $descricao; 
    }
}
