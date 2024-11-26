<?php

include "src/conexaobd.php";
require_once __DIR__ . "../../DTO/pedidoDTO.php";

class PedidoDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create(PedidoDTO $pedido) {
        $sql = "INSERT INTO t_pedido (data, status, entrega_domicilio, preco_total, t_cliente_id) VALUES (:data, :status, :entrega_domicilio, :preco_total, :t_cliente_id)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':data', $pedido->getData());
        $stmt->bindParam(':status', $pedido->getStatus());
        $stmt->bindParam(':entrega_domicilio', $pedido->getEntregaDomicilio(), PDO::PARAM_INT);
        $stmt->bindParam(':preco_total', $pedido->getPrecoTotal(), PDO::PARAM_STR);
        $stmt->bindParam(':t_cliente_id', $pedido->getTClienteId(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function update(PedidoDTO $pedido) {
        $sql = "UPDATE t_pedido SET status = :status, entrega_domicilio = :entrega_domicilio, preco_total = :preco_total WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':status', $pedido->getStatus());
        $stmt->bindParam(':entrega_domicilio', $pedido->getEntregaDomicilio(), PDO::PARAM_INT);
        $stmt->bindParam(':preco_total', $pedido->getPrecoTotal(), PDO::PARAM_STR);
        $stmt->bindParam(':id', $pedido->getId(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM t_pedido WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getById($id) {
        $sql = "SELECT * FROM t_pedido WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllByClienteId($t_cliente_id) {
        $sql = "SELECT * FROM t_pedido WHERE t_cliente_id = :t_cliente_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':t_cliente_id', $t_cliente_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        // Método para contar pedidos por dia, semana, quinzena e mês
        public function countPedidosPorPeriodo($periodo = 'dia') {
            // Define o agrupamento baseado no período solicitado
            switch ($periodo) {
                case 'semana':
                    $sql = "SELECT YEAR(data) AS ano, WEEK(data) AS semana, COUNT(*) AS total_pedidos
                            FROM t_pedido
                            GROUP BY YEAR(data), WEEK(data)
                            ORDER BY YEAR(data) DESC, WEEK(data) DESC";
                    break;
                    
                case 'quinzena':
                    $sql = "SELECT YEAR(data) AS ano, FLOOR((DAY(data)-1)/15) + 1 AS quinzena, COUNT(*) AS total_pedidos
                            FROM t_pedido
                            GROUP BY YEAR(data), quinzena
                            ORDER BY YEAR(data) DESC, quinzena DESC";
                    break;
    
                case 'mes':
                    $sql = "SELECT YEAR(data) AS ano, MONTH(data) AS mes, COUNT(*) AS total_pedidos
                            FROM t_pedido
                            GROUP BY YEAR(data), MONTH(data)
                            ORDER BY YEAR(data) DESC, MONTH(data) DESC";
                    break;
    
                case 'dia':
                default:
                    // Contagem de pedidos por dia
                    $sql = "SELECT DATE(data) AS data_pedido, COUNT(*) AS total_pedidos
                            FROM t_pedido
                            GROUP BY DATE(data)
                            ORDER BY DATE(data) DESC";
                    break;
            }
    
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
}