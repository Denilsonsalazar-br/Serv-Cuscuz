<?php


include "src/conexaobd.php";
require_once __DIR__ . "../../DTO/categoriaDTO.php";

class CategoriaDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexao::getInstance(); //conexão com o banco
    }

    // Criar uma nova categoria
    public function create(CategoriaDTO $categoria) {
        $sql = "INSERT INTO t_categoria (nome) VALUES (:nome)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":nome", $categoria->getNome());
        return $stmt->execute();
    }

    // Editar uma categoria existente
    public function update(CategoriaDTO $categoria) {
        $sql = "UPDATE t_categoria SET nome = :nome WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":nome", $categoria->getNome());
        $stmt->bindValue(":id", $categoria->getId());
        return $stmt->execute();
    }

    // Deletar uma categoria
    public function delete($id) {
        // Verifica se há produtos associados
        $checkSql = "SELECT COUNT(*) AS total FROM t_produto WHERE t_categoria_id = :id";
        $checkStmt = $this->pdo->prepare($checkSql);
        $checkStmt->bindValue(":id", $id);
        $checkStmt->execute();
        $result = $checkStmt->fetch(PDO::FETCH_ASSOC);
    
        if ($result['total'] > 0) {
            // Impede a exclusão se houver produtos associados
            return false;
        }
    
        // Caso não haja associações, realiza a exclusão
        $sql = "DELETE FROM t_categoria WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id);
        return $stmt->execute();
    }
    

    // Listar todas as categorias
    public function list() {
        $sql = "SELECT * FROM t_categoria";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obter uma categoria pelo ID
    public function findById($id) {
        var_dump("ID passado para findById:", $id); // Depuração
    
        $sql = "SELECT * FROM t_categoria WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

    
        if ($result) {
            $categoria = new CategoriaDTO();
            $categoria->setId($result['id']);
            $categoria->setNome($result['nome']);
            return $categoria;
        }
        return null; // Retorna null se não encontrar a categoria
    }
    
    
}