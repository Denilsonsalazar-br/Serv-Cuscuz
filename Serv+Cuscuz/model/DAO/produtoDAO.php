<?php

include "src/conexaobd.php";
require_once __DIR__ . "../../DTO/produtoDTO.php";

class ProdutoDAO {
    private $pdo = null;

    public function __construct() {
        $this->pdo = Conexao::getInstance();
    }

    public function cadastrarProduto(ProdutoDTO $produto) {
        try {
            $sql = "INSERT INTO t_produto (nome, descricao, imagem, preco, tamanho, t_funcionario_id, t_categoria_id) 
                    VALUES (:nome, :descricao, :imagem, :preco, :tamanho, :t_funcionario_id, :t_categoria_id)";
            $stmt = $this->pdo->prepare($sql);
    
            $stmt->bindValue(":nome", $produto->getNome());
            $stmt->bindValue(":descricao", $produto->getDescricao());
            $stmt->bindValue(":imagem", $produto->getImagem());
            $stmt->bindValue(":preco", number_format((float) $produto->getPreco(), 2, '.', ''));
            $stmt->bindValue(":tamanho", $produto->getTamanho());
            $stmt->bindValue(":t_funcionario_id", $produto->getFuncionarioId());
            $stmt->bindValue(":t_categoria_id", $produto->getCategoriaId());
    
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro ao cadastrar produto: " . $e->getMessage());
            return false;
        }
    }    
    
    public function editarProduto(ProdutoDTO $produto) {
        try {
            $sql = "UPDATE t_produto SET 
                        nome = :nome, 
                        descricao = :descricao, 
                        imagem = :imagem, 
                        preco = :preco, 
                        tamanho = :tamanho, 
                        t_funcionario_id = :t_funcionario_id,
                        t_categoria_id = :t_categoria_id
                    WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
    
            $stmt->bindValue(":id", $produto->getId());
            $stmt->bindValue(":nome", $produto->getNome());
            $stmt->bindValue(":descricao", $produto->getDescricao());
            $stmt->bindValue(":imagem", $produto->getImagem());
            $stmt->bindValue(":preco", $produto->getPreco());
            $stmt->bindValue(":tamanho", $produto->getTamanho());
            $stmt->bindValue(":t_funcionario_id", $produto->getFuncionarioId());
            $stmt->bindValue(":t_categoria_id", $produto->getCategoriaId());
    
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erro ao atualizar produto: " . $e->getMessage());
        }
    }
    
    
    
    public function excluirProduto($id) {
        try {
            $sql = "DELETE FROM t_produto WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":id", $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao excluir produto: " . $e->getMessage();
            return false;
        }
    }

    public function getProdutoById($id) {
        try {
            $sql = "SELECT * FROM t_produto WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":id", $id);
            $stmt->execute();
            return $stmt->fetchObject("ProdutoDTO");
        } catch (PDOException $e) {
            echo "Erro ao buscar produto: " . $e->getMessage();
            return null;
        }
    }

    public function getAllProdutos() {
        try {
            $sql = "SELECT * FROM t_produto";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_CLASS, "ProdutoDTO");
        } catch (PDOException $e) {
            echo "Erro ao buscar produtos: " . $e->getMessage();
            return [];
        }
    }
    public function listarTodosProdutos() {
        $stmt = $this->pdo->query("SELECT * FROM t_produto");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

public function contarProdutosPorTamanho($tamanho) {
    $conn = Conexao::getInstance();
    $query = "SELECT COUNT(*) FROM t_produto WHERE tamanho = :tamanho";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':tamanho', $tamanho);
    $stmt->execute();
    return $stmt->fetchColumn();  // Retorna o número de produtos do tamanho específico
}


public function contarProdutosPorCategoriaETamanho($categoriaId, $tamanho) {
    $query = "SELECT COUNT(*) as total FROM t_produto WHERE t_categoria_id = :categoria_id AND tamanho = :tamanho";
    $stmt = $this->pdo->prepare($query);
    $stmt->bindParam(':categoria_id', $categoriaId, PDO::PARAM_INT);
    $stmt->bindParam(':tamanho', $tamanho, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'] ?? 0;
}


}