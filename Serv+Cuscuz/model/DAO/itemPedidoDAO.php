<?php

include "src/conexaobd.php";
require_once __DIR__ . "../../DTO/itemPedidoDTO.php";

class ItemPedidoDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create(ItemPedidoDTO $itemPedido) {
        $sql = "INSERT INTO t_itemPedido (quantidade, t_pedido_id, t_produto_id) VALUES (:quantidade, :t_pedido_id, :t_produto_id)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':quantidade', $itemPedido->getQuantidade(), PDO::PARAM_INT);
        $stmt->bindParam(':t_pedido_id', $itemPedido->getTPedidoId(), PDO::PARAM_INT);
        $stmt->bindParam(':t_produto_id', $itemPedido->getTProdutoId(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function update(ItemPedidoDTO $itemPedido) {
        $sql = "UPDATE t_itemPedido SET quantidade = :quantidade, t_pedido_id = :t_pedido_id, t_produto_id = :t_produto_id WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':quantidade', $itemPedido->getQuantidade(), PDO::PARAM_INT);
        $stmt->bindParam(':t_pedido_id', $itemPedido->getTPedidoId(), PDO::PARAM_INT);
        $stmt->bindParam(':t_produto_id', $itemPedido->getTProdutoId(), PDO::PARAM_INT);
        $stmt->bindParam(':id', $itemPedido->getId(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM t_itemPedido WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getById($id) {
        $sql = "SELECT * FROM t_itemPedido WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllByPedidoId($t_pedido_id) {
        $sql = "SELECT * FROM t_itemPedido WHERE t_pedido_id = :t_pedido_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':t_pedido_id', $t_pedido_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        // Método para contar a quantidade de produtos vendidos por período (dia, semana, quinzena, mês)
        public function countProdutosVendidosPorPeriodo($periodo = 'dia') {
            // Define o agrupamento baseado no período solicitado
            switch ($periodo) {
                case 'semana':
                    $sql = "SELECT YEAR(ip.data) AS ano, WEEK(ip.data) AS semana, ip.t_produto_id, p.nome AS produto, SUM(ip.quantidade) AS total_vendido
                            FROM t_itemPedido ip
                            JOIN t_produto p ON ip.t_produto_id = p.id
                            GROUP BY YEAR(ip.data), WEEK(ip.data), ip.t_produto_id
                            ORDER BY YEAR(ip.data) DESC, WEEK(ip.data) DESC, total_vendido DESC";
                    break;
                    
                case 'quinzena':
                    $sql = "SELECT YEAR(ip.data) AS ano, FLOOR((DAY(ip.data)-1)/15) + 1 AS quinzena, ip.t_produto_id, p.nome AS produto, SUM(ip.quantidade) AS total_vendido
                            FROM t_itemPedido ip
                            JOIN t_produto p ON ip.t_produto_id = p.id
                            GROUP BY YEAR(ip.data), quinzena, ip.t_produto_id
                            ORDER BY YEAR(ip.data) DESC, quinzena DESC, total_vendido DESC";
                    break;
    
                case 'mes':
                    $sql = "SELECT YEAR(ip.data) AS ano, MONTH(ip.data) AS mes, ip.t_produto_id, p.nome AS produto, SUM(ip.quantidade) AS total_vendido
                            FROM t_itemPedido ip
                            JOIN t_produto p ON ip.t_produto_id = p.id
                            GROUP BY YEAR(ip.data), MONTH(ip.data), ip.t_produto_id
                            ORDER BY YEAR(ip.data) DESC, MONTH(ip.data) DESC, total_vendido DESC";
                    break;
    
                case 'dia':
                default:
                    // Contagem de produtos vendidos por dia
                    $sql = "SELECT DATE(ip.data) AS data_venda, ip.t_produto_id, p.nome AS produto, SUM(ip.quantidade) AS total_vendido
                            FROM t_itemPedido ip
                            JOIN t_produto p ON ip.t_produto_id = p.id
                            GROUP BY DATE(ip.data), ip.t_produto_id
                            ORDER BY DATE(ip.data) DESC, total_vendido DESC";
                    break;
            }
    
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    
        // Método para buscar o produto mais vendido (já fornecido por você)
        public function getProdutoMaisVendido() {
            $sql = "SELECT ip.t_produto_id, p.nome AS produto, SUM(ip.quantidade) AS total_vendido
                    FROM t_itemPedido ip
                    JOIN t_produto p ON ip.t_produto_id = p.id
                    GROUP BY ip.t_produto_id
                    ORDER BY total_vendido DESC
                    LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
    
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
}
