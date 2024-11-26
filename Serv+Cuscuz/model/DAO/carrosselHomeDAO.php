<?php
include "src/conexaobd.php";
require_once __DIR__ . "../../DTO/carrosselHomeDTO.php";

class CarrosselDAO {
    private $pdo;

    public function __construct(){
        $this->pdo = Conexao::getInstance();
    }

    //adicionar imagem no carrossel
    public function adicionarImagemCarrossel(CarrosselDTO $item) {
        try {
            $sql = "INSERT INTO t_carrossel (imagem_url, titulo, descricao) VALUES (?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $item->getImagemUrl(),
                $item->getTitulo(),
                $item->getDescricao()
            ]);
        } catch (Exception $e) {
            // Lança uma exceção personalizada caso ocorra algum erro no banco
            throw new Exception("Erro ao adicionar a imagem no carrossel: " . $e->getMessage());
        }
    }
    
    public function listarItens() {
        $stmt = $this->pdo->query("SELECT * FROM t_carrossel");
        $itens = [];
        while ($row = $stmt->fetch()) {
            $item = new CarrosselDTO();
            $item->setId($row['id']);
            $item->setImagemUrl($row['imagem_url']);
            $item->setTitulo($row['titulo']);
            $item->setDescricao($row['descricao']);
            $itens[] = $item;
        }
        return $itens;
    }

    public function atualizarItem(CarrosselDTO $item) {
        $sql = "UPDATE t_carrossel SET imagem_url = ?, titulo = ?, descricao = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $item->getImagemUrl(),
            $item->getTitulo(),
            $item->getDescricao(),
            $item->getId()
        ]);
    }

    // Novo método para buscar item por ID
    public function buscarItemPorId($id) {
        $sql = "SELECT * FROM t_carrossel WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        if ($row) {
            $item = new CarrosselDTO();
            $item->setId($row['id']);
            $item->setImagemUrl($row['imagem_url']);
            $item->setTitulo($row['titulo']);
            $item->setDescricao($row['descricao']);
            return $item;
        }
        return null; // Retorna null caso o item não seja encontrado
    }

    public function deletarImagem($id) {
        // Primeiro, busque o item para pegar a URL da imagem associada a ele
        $sql = "SELECT imagem_url FROM t_carrossel WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$item) {
            return false; // Item não encontrado
        }
    
        // Deleta o item no banco de dados (mas não exclui a imagem)
        $sql = "DELETE FROM t_carrossel WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    
} 