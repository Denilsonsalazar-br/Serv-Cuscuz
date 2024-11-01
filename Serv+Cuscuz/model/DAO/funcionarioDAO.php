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
            $senhaFuncionario = password_hash($funcionarioDTO->getSenha(), PASSWORD_DEFAULT); // Use password_hash para segurança
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
            throw new Exception("Erro ao cadastrar funcionário: " . $exc->getMessage()); // Lança exceção em vez de ecoar
        }
    }  

    // Verificar se o CPF já está cadastrado
    public function cpfJaCadastrado($cpf, $idFuncionario = null) {
        $sql = "SELECT COUNT(*) FROM t_funcionario WHERE cpf = ?" . ($idFuncionario ? " AND id != ?" : "");
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($idFuncionario ? [$cpf, $idFuncionario] : [$cpf]);
        return $stmt->fetchColumn() > 0; 
    }
    
    public function verificarEmailExistente($email, $idFuncionario) {
        $sql = "SELECT COUNT(*) FROM t_funcionario WHERE email = ? AND id != ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email, $idFuncionario]);
        return $stmt->fetchColumn() > 0; 
    }

    public function listarFuncionarios() {
        try {
            $sql = "SELECT * FROM t_funcionario"; 
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            return []; 
        }
    }

    public function buscarFuncionarioPorId($idFuncionario) {
        try {
            $sql = "SELECT * FROM t_funcionario WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $idFuncionario);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($data) {
                $funcionarioDTO = new FuncionarioDTO();
                $funcionarioDTO->setId($data['id']);
                $funcionarioDTO->setNome($data['nome']);
                $funcionarioDTO->setCpf($data['cpf']);
                $funcionarioDTO->setEmail($data['email']);
                $funcionarioDTO->setTelefone($data['telefone']);
                $funcionarioDTO->setPerfilId($data['t_perfil_id']);
                return $funcionarioDTO;
            }
            
            return null;
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    public function atualizarFuncionario(FuncionarioDTO $funcionarioDTO) {
        // Verifica se o e-mail já está em uso
        if ($this->verificarEmailExistente($funcionarioDTO->getEmail(), $funcionarioDTO->getId())) {
            throw new Exception("O e-mail já está em uso por outro funcionário.");
        }
    
        // Monta a query de atualização
        $sql = "UPDATE t_funcionario SET 
                    nome = ?, 
                    cpf = ?, 
                    email = ?, 
                    telefone = ?," . 
                    (!empty($funcionarioDTO->getSenha()) ? " senha = ?," : "") . 
                    " t_perfil_id = ? 
                WHERE id = ?";
        
        $stmt = $this->pdo->prepare($sql);
        
        // Preenche os valores da query
        $stmt->bindValue(1, $funcionarioDTO->getNome());
        $stmt->bindValue(2, $funcionarioDTO->getCpf());
        $stmt->bindValue(3, $funcionarioDTO->getEmail());
        $stmt->bindValue(4, $funcionarioDTO->getTelefone());
    
        // Se a senha não estiver vazia, adiciona a nova senha hashada
        if (!empty($funcionarioDTO->getSenha())) {
            $stmt->bindValue(5, $funcionarioDTO->getSenha()); // Usa a senha já hashada
            $stmt->bindValue(6, $funcionarioDTO->getPerfilId());
            $stmt->bindValue(7, $funcionarioDTO->getId());
        } else {
            $stmt->bindValue(5, $funcionarioDTO->getPerfilId());
            $stmt->bindValue(6, $funcionarioDTO->getId());
        }
        
        return $stmt->execute();
    }
     
    public function deleteFuncionario($id) {
        $sql = "DELETE FROM t_funcionario WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]); 
    }
}
