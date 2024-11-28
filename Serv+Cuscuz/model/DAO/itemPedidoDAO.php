<?php

include "src/conexaobd.php";
require_once __DIR__ . "../../DTO/itemPedidoDTO.php";

class ItemPedidoDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create(ItemPedidoDTO $itemPedido) {
        $sql = "INSERT INTO t_itempedido (quantidade, t_pedido_id, t_produto_id) 
                VALUES (:quantidade, :t_pedido_id, :t_produto_id)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':quantidade', $itemPedido->getQuantidade(), PDO::PARAM_INT);
        $stmt->bindParam(':t_pedido_id', $itemPedido->getTPedidoId(), PDO::PARAM_INT);
        $stmt->bindParam(':t_produto_id', $itemPedido->getTProdutoId(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function update(ItemPedidoDTO $itemPedido) {
        $sql = "UPDATE t_itempedido 
                SET quantidade = :quantidade, t_pedido_id = :t_pedido_id, t_produto_id = :t_produto_id 
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':quantidade', $itemPedido->getQuantidade(), PDO::PARAM_INT);
        $stmt->bindParam(':t_pedido_id', $itemPedido->getTPedidoId(), PDO::PARAM_INT);
        $stmt->bindParam(':t_produto_id', $itemPedido->getTProdutoId(), PDO::PARAM_INT);
        $stmt->bindParam(':id', $itemPedido->getId(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM t_itempedido WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteByPedidoId($t_pedido_id) {
        // Usando transação para garantir consistência dos dados
        try {
            $this->pdo->beginTransaction();
            $sql = "DELETE FROM t_itempedido WHERE t_pedido_id = :t_pedido_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':t_pedido_id', $t_pedido_id, PDO::PARAM_INT);
            $result = $stmt->execute();

            if ($result) {
                $this->pdo->commit();
            } else {
                $this->pdo->rollBack();
            }

            return $result;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception("Erro ao excluir itens do pedido: " . $e->getMessage());
        }
    }

    public function getById($id) {
        $sql = "SELECT * FROM t_itempedido WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllByPedidoId($t_pedido_id) {
        $sql = "SELECT * FROM t_itempedido WHERE t_pedido_id = :t_pedido_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':t_pedido_id', $t_pedido_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countProdutosVendidosPorPeriodo($periodo = 'dia') {
        $periodoSQL = '';
        switch ($periodo) {
            case 'semana':
                $periodoSQL = "YEAR(pe.data) AS ano, WEEK(pe.data) AS semana";
                break;
            case 'quinzena':
                $periodoSQL = "YEAR(pe.data) AS ano, FLOOR((DAY(pe.data)-1)/15) + 1 AS quinzena";
                break;
            case 'mes':
                $periodoSQL = "YEAR(pe.data) AS ano, MONTH(pe.data) AS mes";
                break;
            case 'dia':
            default:
                $periodoSQL = "DATE(pe.data) AS data_venda";
                break;
        }

        $sql = "SELECT $periodoSQL, ip.t_produto_id, pr.nome AS produto, SUM(ip.quantidade) AS total_vendido
                FROM t_itempedido ip
                JOIN t_pedido pe ON ip.t_pedido_id = pe.id
                JOIN t_produto pr ON ip.t_produto_id = pr.id
                GROUP BY $periodoSQL, ip.t_produto_id
                ORDER BY total_vendido DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProdutoMaisVendido() {
        $sql = "SELECT ip.t_produto_id, pr.nome AS produto, SUM(ip.quantidade) AS total_vendido
                FROM t_itempedido ip
                JOIN t_produto pr ON ip.t_produto_id = pr.id
                GROUP BY ip.t_produto_id
                ORDER BY total_vendido DESC
                LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}