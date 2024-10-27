<?php
class ValidadorCPF
{
    public static function validar($cpf)
{
    // Remove todos os caracteres não numéricos
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    // Verifica se o número contém 11 dígitos
    if (strlen($cpf) != 11) {
        return false;
    }

    // Calcula os dígitos verificadores
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $p = 0; $p < $t; $p++) {
            $d += $cpf[$p] * (($t + 1) - $p);
        }
        //cálculo dos dígitos verificadores de um CPF
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$t] != $d) {
            return false;
        }
    }
    return true;
}


    public static function cpfJaCadastradoFuncionario($cpf, $pdo)
    {
        // Remove todos os caracteres não numéricos
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // Prepara a consulta para verificar se o CPF já está cadastrado
        $sql = "SELECT COUNT(*) FROM t_funcionario WHERE cpf = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$cpf]);
        return $stmt->fetchColumn() > 0; // Retorna true se CPF já estiver cadastrado
    }

    public static function cpfJaCadastradoCliente($cpf, $pdo)
    {
        // Remove todos os caracteres não numéricos
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // Prepara a consulta para verificar se o CPF já está cadastrado
        $sql = "SELECT COUNT(*) FROM t_cliente WHERE cpf = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$cpf]);
        return $stmt->fetchColumn() > 0; // Retorna true se CPF já estiver cadastrado
    }
}