<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "../../model/DAO/src/conexaobd.php";

// Supondo que a instância de conexão seja $pdo
$pdo = Conexao::getInstance(); // Obter a instância de conexão

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verifica se é um funcionário
    $sqlFuncionario = "SELECT f.id, f.nome, f.email, f.senha, p.tipo_perfil
                       FROM t_funcionario f
                       JOIN t_perfil p ON f.t_perfil_id = p.id
                       WHERE f.email = :email";
    $stmtFuncionario = $pdo->prepare($sqlFuncionario);
    $stmtFuncionario->bindParam(':email', $email);
    $stmtFuncionario->execute();

    if ($stmtFuncionario->rowCount() > 0) {
        // Funcionário encontrado
        $user = $stmtFuncionario->fetch(PDO::FETCH_ASSOC);

        // Verifica se a senha fornecida corresponde ao hash no banco de dados
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['nome'] = $user['nome'];
            $_SESSION['perfil'] = $user['tipo_perfil'];  // Guarda o tipo de perfil para controle de acesso

            // Mensagem de sucesso na sessão
            $_SESSION['msgLogin'] = [
                'tipo' => 'sucessoFuncionario',
                'mensagem' => 'Login realizado com sucesso!'
            ];

            // Redireciona com base no perfil
            if ($user['tipo_perfil'] == 'ADMINISTRADOR') {
                header("Location: ../view/admin/adminPainelController.php");
            } else {
                header("Location: ../view/funcionario/paginaHomeFuncionario.php");
            }
            exit;
        } else {
            // Mensagem de erro para senha incorreta
            $_SESSION['msg'] = [
                'tipo' => 'erroFuncionario',
                'mensagem' => 'Senha incorreta'
            ];
        }
    } else {
        // Se não for funcionário, vai verificar se é um cliente
        $sqlCliente = "SELECT id, nome, email, senha FROM t_cliente WHERE email = :email";
        $stmtCliente = $pdo->prepare($sqlCliente);
        $stmtCliente->bindParam(':email', $email);
        $stmtCliente->execute();

        if ($stmtCliente->rowCount() > 0) {
            // Cliente encontrado
            $cliente = $stmtCliente->fetch(PDO::FETCH_ASSOC);

            // Verifica se a senha fornecida corresponde ao hash no banco de dados
            if (password_verify($senha, $cliente['senha'])) {
                $_SESSION['id'] = $cliente['id'];
                $_SESSION['nome'] = $cliente['nome'];

                // Mensagem de sucesso na sessão
                $_SESSION['msgLogin'] = [
                    'tipo' => 'sucessoCliente',
                    'mensagem' => 'Login realizado com sucesso!'
                ];

                // Redireciona para a página do cliente
                header("Location: ../pages/home.php");
                exit;
            } else {
                // Mensagem de erro para senha incorreta
                $_SESSION['msg'] = [
                    'tipo' => 'erroCliente',
                    'mensagem' => 'Senha incorreta'
                ];
            }
        } else {
            // Mensagem de erro para email não cadastrado
            $_SESSION['msg'] = [
                'tipo' => 'erroCliente',
                'mensagem' => 'Email inocorreto ou não cadastrado!'
            ];
        }
    }
}
