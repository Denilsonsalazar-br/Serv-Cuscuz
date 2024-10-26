
<?php
// Iniciar a sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "../../../model/DTO/validacoes/validarCpf.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/headerCadastro.css">
    <link rel="stylesheet" href="../../assets/css/cadastroFuncionario.css">
    <title>Cadastro de Funcionário</title>
</head>
<body>
    <header>
        <nav class="nav-bar">    
            <div class="logo">
                <a href="../../pages/home.php">
                    <img src="../../assets/img/logo-png-reduzida.png" alt="Serv+Cuscuz">
                </a>
            </div>
            <div class="botao">
                <button>
                    <?php 
                        include '../../pages/verificarLoginAdm.php';
                    ?>
                </button>
            </div>
        </nav>
    </header>
    <section class="BemVindoAdm">
        <?php 
        // Verifica se o usuário é um administrador
        if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 'ADMINISTRADOR') {
            header("Location: ../../controller/admin/adminPainelController.php");
            exit;
        }

        echo "<h1>Bem-vindo, " . $_SESSION['nome'] . "!</h1> <h2>Hoje será um ótimo dia. </h2>";
        
        ?>
    </section>
    
    <div class="painelAdm">
        <nav >
            <a href="#">Home</a>
            <a href="../../view/admin/listaFuncionarios.php">Funcionários</a>
            <a href="../../view/cliente/listaCliente.php">Clientes</a>
            <a href="#">Produtos</a>
            <a href="#">Pedidos</a>
            <a href="#">Relatórios</a>
        </nav>
    </div>
    <main>
     <div class="formCadastroFuncionario"> 

     <h2>Cadastrar Funcionário</h2>
        <!--Mensagem de sucesso-->

    <?php if (isset($_SESSION['sucesso'])): ?>
        <span style=" width: 100%; color: #ffffff; text-align: center;">
            <?php echo $_SESSION['sucesso']; ?>
        </span>
        <?php unset($_SESSION['sucesso']); // Limpa a mensagem após exibi-la ?>
    <?php endif; ?>

    <!--Mensagem de erro-->

    <?php if (isset($_SESSION['error'])): ?>
        <span style=" width: 100%;  color: #ffffff; text-align: center;">
            <?php echo $_SESSION['error']; ?>
        </span>
        <?php unset($_SESSION['error']); // Limpa a mensagem após exibi-la ?>
    <?php endif; ?>

            <form method="POST" action="../../controller/funcionario/createFuncionarioController.php">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" required>
                <br><br>
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" required>
                    <?php if (isset($_SESSION['cpf_error'])): ?>
                        <span style="color:red;"><?php echo $_SESSION['cpf_error']; ?></span>
                        <?php unset($_SESSION['cpf_error']); // Limpa a mensagem após exibi-la ?>
                    <?php endif; ?>
                <br><br>
                <label for="email">Email:</label>
                <input type="email" name="email" required>
                <br><br>
                <label for="telefone">Telefone:</label>
                <input type="text" name="telefone" required>
                <br><br>
                <label for="senha">Senha:</label>
                <input type="password" name="senha" required>
                <br><br>
                <div>
                <label for="t_perfil_id">Perfil:</label>
                <br>
                <select class="selecaoPerfil" name="t_perfil_id" required>
                    <option value="1">Administrador</option>
                    <option value="2">Funcionário</option>
                </select>
                <br><br>
                <button class="formButton" type="submit">Cadastrar Funcionário</button>

                    <?php if (isset($_SESSION['success'])): ?>
                        <span style="color:green;">
                            <?php echo $_SESSION['success']; ?>
                        </span>
                        <?php unset($_SESSION['success']); // Limpa a mensagem após exibi-la ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <span style="color:red;">
                            <?php echo $_SESSION['error']; ?>
                        </span>
                        <?php unset($_SESSION['error']); // Limpa a mensagem após exibi-la ?>
                    <?php endif; ?>
            </form>

    </div>
    </main>
</body>
</html>
