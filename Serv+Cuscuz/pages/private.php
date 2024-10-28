<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "../../model/DAO/src/conexaobd.php";

$conn = Conexao::getInstance(); // Obter a instância de conexão

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verifica se é um funcionário
    $sqlFuncionario = "SELECT f.id, f.nome, f.email, f.senha, p.tipo_perfil
                       FROM t_funcionario f
                       JOIN t_perfil p ON f.t_perfil_id = p.id
                       WHERE f.email = :email";
    $stmtFuncionario = $conn->prepare($sqlFuncionario);
    $stmtFuncionario->bindParam(':email', $email);
    $stmtFuncionario->execute();

    if ($stmtFuncionario->rowCount() > 0) {
        // Funcionário encontrado
        $user = $stmtFuncionario->fetch(PDO::FETCH_ASSOC);

        // Verifica se a senha fornecida corresponde ao hash no banco de dados
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['nome'] = $user['nome'];
            $_SESSION['perfil'] = $user['tipo_perfil'];

            // Redireciona com base no perfil
            if ($user['tipo_perfil'] == 'ADMINISTRADOR') {
                header("Location: ../controller/admin/adminPainelController.php");
            } else {
                header("Location: ../view/funcionario/paginaHomeFuncionario.php");
            }
            exit;
        } else {
            echo "<div class='mensagem-erro'>Senha incorreta</div>";
        }
    } else {
        // Se não for funcionário, verifica se é um cliente
        $sqlCliente = "SELECT id, nome, email, senha FROM t_cliente WHERE email = :email";
        $stmtCliente = $conn->prepare($sqlCliente);
        $stmtCliente->bindParam(':email', $email);
        $stmtCliente->execute();

        if ($stmtCliente->rowCount() > 0) {
            // Cliente encontrado
            $cliente = $stmtCliente->fetch(PDO::FETCH_ASSOC);

            // Verifica se a senha fornecida corresponde ao hash no banco de dados
            if (password_verify($senha, $cliente['senha'])) {
                $_SESSION['id'] = $cliente['id'];
                $_SESSION['nome'] = $cliente['nome'];

                // Redireciona para a página do cliente
                header("Location: ../pages/home.php");
                exit;
            } else {
                echo "<div class='mensagem-erro'>Senha incorreta</div>";
            }
        } else {
            echo "<div class='mensagem-erro'>Este email não está cadastrado no sistema!</div>";
        }
    }
}