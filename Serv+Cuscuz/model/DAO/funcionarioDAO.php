<?php

include "src/conexaobd.php";
require_once __DIR__ . '../../../model/DTO/funcionarioDTO.php';

class FuncionarioDAO {
    public $pdo = null;

    public function __construct() {
        $this->pdo = Conexao::getInstance();
    }

    // Cadastrar Funcionário
    public function cadastrarFuncionario(FuncionarioDTO $funcionarioDTO)
    {
        try {
            $sql = "INSERT INTO t_funcionario (nome, cpf, email, telefone, senha, t_perfil_id) VALUES (?,?,?,?,?,?)";
            $stmt = $this->pdo->prepare($sql);

            $nomeFuncionario = $funcionarioDTO->getNome();
            $cpfFuncionario = $funcionarioDTO->getCpf();
            $emailFuncionario = $funcionarioDTO->getEmail();
            $telefoneFuncionario =$funcionarioDTO->getTelefone();
            $senhaFuncionario = $funcionarioDTO->getSenha();
            $t_perfil_idFuncionario = $funcionarioDTO->getPerfilId();

            $stmt->bindValue(1, $nomeFuncionario);
            $stmt->bindValue(2, $cpfFuncionario);
            $stmt->bindValue(3, $emailFuncionario);
            $stmt->bindValue(4, $telefoneFuncionario);
            $stmt->bindValue(5, $senhaFuncionario);
            $stmt->bindValue(6, $t_perfil_idFuncionario);

            $retorno = $stmt->execute();
            return $retorno;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }  
    // Verificar se o CPF já está cadastrado
     public function cpfJaCadastrado($cpf) {
        $sql = "SELECT COUNT(*) FROM t_funcionario WHERE cpf = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$cpf]);
            // Retorna verdadeiro se o CPF já existe
        return $stmt->fetchColumn() > 0; 
    }

    public function listarFuncionarios() {
        try {
            $sql = "SELECT * FROM t_funcionario"; 
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna um array associativo
        } catch (PDOException $e) {
            // Debug: Se houver um erro na consulta
            echo "Erro: " . $e->getMessage();
            return []; // Retorna um array vazio em caso de erro
        }
    }

    public function buscarFuncionarioPorId($id) {
        $sql = "SELECT * FROM t_funcionario WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchObject(FuncionarioDTO::class);
         // Retorna um objeto FuncionarioDTO
    }
    
    public function atualizarFuncionario(FuncionarioDTO $funcionarioDTO) {
        $sql = "UPDATE t_funcionario SET nome = ?, cpf = ?, email = ?, telefone = ?, senha = ?, t_perfil_id = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->bindValue(1, $funcionarioDTO->getNome());
        $stmt->bindValue(2, $funcionarioDTO->getCpf());
        $stmt->bindValue(3, $funcionarioDTO->getEmail());
        $stmt->bindValue(4, $funcionarioDTO->getTelefone());
        $stmt->bindValue(5, $funcionarioDTO->getSenha());
        $stmt->bindValue(6, $funcionarioDTO->getPerfilId());
        $stmt->bindValue(7, $funcionarioDTO->getId());
    
        return $stmt->execute();
         // Retorna verdadeiro se a atualização for bem-sucedida
    }
    
    public function deleteFuncionario($id) {
        $sql = "DELETE FROM t_funcionario WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]); 
        // Retorna verdadeiro se a exclusão for bem-sucedida
    }
}
