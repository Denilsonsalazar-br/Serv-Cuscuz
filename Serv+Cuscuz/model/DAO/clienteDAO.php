<?php

include "src/conexaobd.php";
require_once __DIR__ . "../../../model/DTO/clienteDTO.php";

class ClienteDAO{
    public $pdo = null;

    public function __construct(){
        $this->pdo = Conexao::getInstance();
    }
    public function cadastrarCliente (ClienteDTO $clienteDTO) 
    {
        try{
            $sql = "INSERT INTO t_cliente (nome, sobrenome, cpf, email, telefone, senha) VALUES (?,?,?,?,?,?)";
            $stmt = $this->pdo->prepare($sql);

            $nomeCliente = $clienteDTO->getNome();
            $sobrenomeCliente = $clienteDTO->getSobrenome();
            $cpfCliente = $clienteDTO->getCpf();
            $emailCliente = $clienteDTO->getEmail();
            $telefoneCliente = $clienteDTO->getTelefone();
            $senhaCliente = $clienteDTO->getSenha();

            $stmt->bindValue(1, $nomeCliente);
            $stmt->bindValue(2, $sobrenomeCliente);
            $stmt->bindValue(3, $cpfCliente);
            $stmt->bindValue(4, $emailCliente);
            $stmt->bindValue(5, $telefoneCliente);
            $stmt->bindValue(6, $senhaCliente);

            $retorno = $stmt->execute();
            return $retorno;
        } catch(PDOException $exc) {
            echo $exc->getMessage();
        }
        
    }
    //Verifica se o CPF já está cadastrado
    public function cpfJaCadastradoCliente($cpf) {
        $sql = "SELECT COUNT(*) FROM t_cliente WHERE cpf = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$cpf]);
            // Retorna verdadeiro se o CPF já existe
        return $stmt->fetchColumn() > 0; 
    }

    public function listarCliente() {
        try {
            $sql = "SELECT * FROM t_cliente"; 
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna um array associativo
        } catch (PDOException $e) {
            // Debug: Se houver um erro na consulta
            echo "Erro: " . $e->getMessage();
            return []; // Retorna um array vazio em caso de erro
        }
    }
    public function buscarClientePorId($id) {
        $sql = "SELECT * FROM t_cliente WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchObject(ClienteDTO::class);
         // Retorna um objeto ClienteDTO
    }

    public function atualizarCliente(ClienteDTO $clienteDTO) {
        $sql = "UPDATE t_cliente SET nome = ?, sobrenome = ?, cpf = ?, email = ?, telefone = ?, senha = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->bindValue(1, $clienteDTO->getNome());
        $stmt->bindValue(2, $clienteDTO->getSobrenome());
        $stmt->bindValue(3, $clienteDTO->getCpf());
        $stmt->bindValue(4, $clienteDTO->getEmail());
        $stmt->bindValue(5, $clienteDTO->getTelefone());
        $stmt->bindValue(6, $clienteDTO->getSenha());
        $stmt->bindValue(7, $clienteDTO->getId());
    
        return $stmt->execute();
         // Retorna verdadeiro se a atualização for bem-sucedida
    }
    public function deleteCliente($id) {
        $sql = "DELETE FROM t_cliente WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]); 
        // Retorna verdadeiro se a exclusão for bem-sucedida
    }
    public function contarClientesPorPeriodo($periodo, $ano = null, $mes = null) {
        try {
            if (!$ano) {
                $ano = date('Y');
            }
    
            if ($periodo === 'MONTH') {
                if (!$mes) {
                    $mes = date('m');
                }
    
                // Total atual para o mês atual
                $sql = "SELECT COUNT(*) as total FROM t_cliente WHERE MONTH(data_criacao) = :mes AND YEAR(data_criacao) = :ano";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([':mes' => $mes, ':ano' => $ano]);
                $totalAtual = $stmt->fetchColumn();
    
                // Total para o mês anterior
                $mesAnterior = $mes == 1 ? 12 : $mes - 1;
                $anoAnterior = $mes == 1 ? $ano - 1 : $ano;
    
                $sql = "SELECT COUNT(*) as total FROM t_cliente WHERE MONTH(data_criacao) = :mesAnterior AND YEAR(data_criacao) = :anoAnterior";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([':mesAnterior' => $mesAnterior, ':anoAnterior' => $anoAnterior]);
                $totalAnterior = $stmt->fetchColumn();
    
                return [
                    'atual' => $totalAtual,
                    'anterior' => $totalAnterior
                ];
            } elseif ($periodo === 'QUARTER') {
                // Total atual para o trimestre atual
                $sql = "SELECT COUNT(*) as total FROM t_cliente 
                        WHERE QUARTER(data_criacao) = QUARTER(CURRENT_DATE()) AND YEAR(data_criacao) = :ano";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([':ano' => $ano]);
                return [
                    'atual' => $stmt->fetchColumn(),
                    'anterior' => 0 // Adicione lógica para trimestre anterior, se necessário
                ];
            } elseif ($periodo === 'YEAR') {
                // Total atual para o ano atual
                $sql = "SELECT COUNT(*) as total FROM t_cliente WHERE YEAR(data_criacao) = :ano";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([':ano' => $ano]);
                return [
                    'atual' => $stmt->fetchColumn(),
                    'anterior' => 0 // Adicione lógica para ano anterior, se necessário
                ];
            }
    
            return 0; // Retorno padrão se nenhum período for identificado
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            return 0;
        }
    }    
    
    public function contarClientesPorSemestre() {
        try {
            $sqlAtual = "SELECT COUNT(*) as total FROM t_cliente 
                         WHERE CEIL(MONTH(data_criacao) / 6) = CEIL(MONTH(CURRENT_DATE()) / 6) 
                         AND YEAR(data_criacao) = YEAR(CURRENT_DATE())";
            $stmt = $this->pdo->prepare($sqlAtual);
            $stmt->execute();
            $totalAtual = $stmt->fetchColumn();
    
            // Total para o semestre anterior
            $sqlAnterior = "SELECT COUNT(*) as total FROM t_cliente 
                            WHERE CEIL(MONTH(data_criacao) / 6) = CEIL(MONTH(CURRENT_DATE()) / 6) - 1
                            AND YEAR(data_criacao) = YEAR(CURRENT_DATE())";
            $stmt = $this->pdo->prepare($sqlAnterior);
            $stmt->execute();
            $totalAnterior = $stmt->fetchColumn();
    
            return [
                'atual' => $totalAtual,
                'anterior' => $totalAnterior
            ];
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            return [
                'atual' => 0,
                'anterior' => 0
            ];
        }
    }
    
}
