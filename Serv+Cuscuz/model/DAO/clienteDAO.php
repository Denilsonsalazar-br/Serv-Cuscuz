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
}