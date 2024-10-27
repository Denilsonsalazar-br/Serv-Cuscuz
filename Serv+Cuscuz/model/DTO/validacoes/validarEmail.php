<?php

class ValidadorEmail{

    public static function emailJaCadastradoCliente($email, $pdo) {
        $sql = "SELECT COUNT(*) FROM t_cliente WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0; // Retorna true se o e-mail já estiver cadastrado
    }
    public static function emailJaCadastradoFuncionario($email, $pdo) {
        $sql = "SELECT COUNT(*) FROM t_funcionario WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0; // Retorna true se o e-mail já estiver cadastrado
    }
}