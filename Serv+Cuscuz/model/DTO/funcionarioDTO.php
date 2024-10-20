<?php
class FuncionarioDTO {
    private $id;
    private $nome;
    private $cpf;
    private $email;
    private $telefone;
    private $senha;
    private $t_perfil_id;

    // Métodos Get e Set
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
    public function getCpf() {
        return $this->cpf;
    }
    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }
    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
    public function getTelefone() {
        return $this->telefone;
    }
    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }
    public function getSenha() {
        return $this->senha;
    }
    public function setSenha($senha) {
        $this->senha = $senha;
    }
    public function getPerfilId() {
        return $this->t_perfil_id;
    }
    public function setPerfilId($t_perfil_id) {
        $this->t_perfil_id = $t_perfil_id;
    }
}