<?php
class ProdutoDTO {
    private $id;
    private $nome;
    private $descricao;
    private $imagem;
    private $preco;
    private $tamanho;
    private $funcionarioId;
    private $categoriaId;  // Adicionando a categoria

    // Métodos get e set para cada atributo.

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getImagem() {
        return $this->imagem;
    }

    public function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    public function getPreco() {
        return $this->preco;
    }

    public function setPreco($preco) {
        $this->preco = $preco;
    }

    public function getTamanho() {
        return $this->tamanho;
    }

    public function setTamanho($tamanho) {
        $this->tamanho = $tamanho;
    }

    public function getFuncionarioId() {
        return $this->funcionarioId;
    }

    public function setFuncionarioId($funcionarioId) {
        $this->funcionarioId = $funcionarioId;
    }

    // Getter e Setter para categoria
    public function getCategoriaId() {
        return $this->categoriaId;
    }

    public function setCategoriaId($categoriaId) {
        $this->categoriaId = $categoriaId;
    }
}
