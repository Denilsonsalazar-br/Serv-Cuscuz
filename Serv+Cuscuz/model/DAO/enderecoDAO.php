<?php

include "src/conexaobd.php";
require_once __DIR__ . "../../../model/DTO/enderecoDTO.php";

class EnderecoDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexao::getInstance();
    }

    // Método para inserir um endereço no banco de dados
    public function create(EnderecoDTO $endereco) {
        try {
            $sql = "INSERT INTO t_endereco (estado, cidade, cep, bairro, rua, numero, complemento) 
                    VALUES (:estado, :cidade, :cep, :bairro, :rua, :numero, :complemento)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":estado", $endereco->getEstado());
            $stmt->bindValue(":cidade", $endereco->getCidade());
            $stmt->bindValue(":cep", $endereco->getCcep());
            $stmt->bindValue(":bairro", $endereco->getBairro());
            $stmt->bindValue(":rua", $endereco->getRua());
            $stmt->bindValue(":numero", $endereco->getNumero());
            $stmt->bindValue(":complemento", $endereco->getComplemento());
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erro ao criar endereço: " . $e->getMessage());
        }
    }

    // Método para buscar um endereço por ID
    public function readById($id) {
        try {
            $sql = "SELECT * FROM t_endereco WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":id", $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erro ao buscar endereço: " . $e->getMessage());
        }
    }

    // Método para listar todos os endereços
    public function readAll() {
        try {
            $sql = "SELECT * FROM t_endereco";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erro ao listar endereços: " . $e->getMessage());
        }
    }

    // Método para atualizar um endereço
    public function update(EnderecoDTO $endereco) {
        try {
            $sql = "UPDATE t_endereco SET estado = :estado, cidade = :cidade, cep = :cep, bairro = :bairro, 
                    rua = :rua, numero = :numero, complemento = :complemento WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":estado", $endereco->getEstado());
            $stmt->bindValue(":cidade", $endereco->getCidade());
            $stmt->bindValue(":cep", $endereco->getCcep());
            $stmt->bindValue(":bairro", $endereco->getBairro());
            $stmt->bindValue(":rua", $endereco->getRua());
            $stmt->bindValue(":numero", $endereco->getNumero());
            $stmt->bindValue(":complemento", $endereco->getComplemento());
            $stmt->bindValue(":id", $endereco->getId());
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erro ao atualizar endereço: " . $e->getMessage());
        }
    }

    // Método para excluir um endereço
    public function delete($id) {
        try {
            $sql = "DELETE FROM t_endereco WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":id", $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erro ao excluir endereço: " . $e->getMessage());
        }
    }

    // Método para gerar dados para relatórios ou dashboards
    public function getDashboardData() {
        try {
            $sql = "SELECT estado, COUNT(*) as total 
                    FROM t_endereco 
                    GROUP BY estado 
                    ORDER BY total DESC";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erro ao gerar dados de dashboard: " . $e->getMessage());
        }
    }
}
