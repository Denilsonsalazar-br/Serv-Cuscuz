<?php
include "src/conexaobd.php";
require_once __DIR__ . "../../DTO/pagamentoDTO.php";
class PagamentoDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create(PagamentoDTO $pagamento) {
        $sql = "INSERT INTO pagamento (valor, data, status_pagamento, forma_pagamento, t_pedido_id) VALUES (:valor, :data, :status_pagamento, :forma_pagamento, :t_pedido_id)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':valor', $pagamento->getValor(), PDO::PARAM_STR);
        $stmt->bindParam(':data', $pagamento->getData());
        $stmt->bindParam(':status_pagamento', $pagamento->getStatusPagamento());
        $stmt->bindParam(':forma_pagamento', $pagamento->getFormaPagamento(), PDO::PARAM_INT);
        $stmt->bindParam(':t_pedido_id', $pagamento->getTPedidoId(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function update(PagamentoDTO $pagamento) {
        $sql = "UPDATE pagamento SET status_pagamento = :status_pagamento, forma_pagamento = :forma_pagamento WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':status_pagamento', $pagamento->getStatusPagamento());
        $stmt->bindParam(':forma_pagamento', $pagamento->getFormaPagamento(), PDO::PARAM_INT);
        $stmt->bindParam(':id', $pagamento->getId(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM pagamento WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getById($id) {
        $sql = "SELECT * FROM pagamento WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllByPedidoId($t_pedido_id) {
        $sql = "SELECT * FROM pagamento WHERE t_pedido_id = :t_pedido_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':t_pedido_id', $t_pedido_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para contar o número de pagamentos por status (PENDENTE, APROVADO, REJEITADO)
    public function countPagamentosPorStatus($status) {
        $sql = "SELECT COUNT(*) AS total_pagamentos
                FROM t_pagamento
                WHERE status_pagamento = :status";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':status' => $status]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para encontrar a forma de pagamento mais utilizada
    public function getFormaPagamentoMaisUtilizada() {
        $sql = "SELECT forma_pagamento, COUNT(*) AS total_usado
                FROM t_pagamento
                GROUP BY forma_pagamento
                ORDER BY total_usado DESC
                LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para calcular o total pago por cada forma de pagamento
    public function totalPagoPorFormaPagamento() {
        $sql = "SELECT forma_pagamento, SUM(valor) AS total_pago
                FROM t_pagamento
                GROUP BY forma_pagamento
                ORDER BY total_pago DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Método para calcular o valor bruto de todos os pagamentos realizados no mês, filtrando pelo status
    public function getValorBrutoPagamentosNoMesEAno($mes, $ano, $statusPagamento = null) {
        // Se o status for fornecido, ele será incluído na consulta
        $sql = "SELECT SUM(valor) AS total_pago
                FROM t_pagamento
                WHERE MONTH(data) = :mes AND YEAR(data) = :ano";
        
        // Adiciona o filtro para o status, se fornecido
        if ($statusPagamento) {
            $sql .= " AND status_pagamento = :status_pagamento";
        }

        // Prepara a consulta
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':mes', $mes, PDO::PARAM_INT);
        $stmt->bindParam(':ano', $ano, PDO::PARAM_INT);

        // Se o status for fornecido, o parâmetro será ligado
        if ($statusPagamento) {
            $stmt->bindParam(':status_pagamento', $statusPagamento, PDO::PARAM_STR);
        }

        // Executa a consulta
        $stmt->execute();

        // Retorna o valor total pago
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}