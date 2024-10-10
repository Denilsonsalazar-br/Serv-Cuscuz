<?php
include 'src/conexao.php'; // arquivo de conexão

function cadastrarUsuario($nome, $sobrenome, $email, $telefone, $cpf, $senha) {
    $pdo = Conexao::getConexao();
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT); // Hash da senha

    $stmt = $pdo->prepare("INSERT INTO usuario (nome, sobrenome, email, cpf, telefone, senha) VALUES (?, ?, ?, ?, ?, ?)");
    
    if ($stmt->execute([$nome, $sobrenome, $email, $cpf, $telefone, $senhaHash])) {
        return true;
    } else {
        return false;
    }
}