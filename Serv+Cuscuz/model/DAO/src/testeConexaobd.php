<?php
require_once '../src/conexaobd.php';

try {
    $conexao = Conexao::getInstance();
    $stmt = $conexao->query("SELECT * FROM t_funcionario");
    $perfil = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($perfil) > 0) {
        echo "Conexão bem-sucedida! Foram encontrados " . count($perfil) . " Perfil.";
    } else {
        echo "Nenhum perfil encontrado.";
    }
} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
}