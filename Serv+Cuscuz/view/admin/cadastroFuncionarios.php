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
    <link rel="stylesheet" href="../../assets/css/mensagens.css">
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
    <div class="painelAdm">
        <nav >
            <a href="../../view/admin/adminPainelController.php">Home</a>
            <a href="#">Produtos</a>
            <a href="#">Pedidos</a>
            <a href="../../view/admin/listaFuncionarios.php">Funcionários</a>
            <a href="../../view/admin/listaCliente.php">Clientes</a>
            <a href="../../view/admin/carrosselHome.php">Carrossel Home</a>
            <a href="#">Relatórios</a>
        </nav>
    </div>

    <!--<section class="BemVindoAdm">
        <?php 
        // Verifica se o usuário é um administrador
        /*if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 'ADMINISTRADOR') {
            header("Location: ../../controller/admin/adminPainelController.php");
            exit;
        }

        echo "<h1>Bem-vindo, " . $_SESSION['nome'] . "!</h1> <h2>Hoje será um ótimo dia. </h2>";*/
        
        ?>
    </section>-->

    <main>
     <div class="formCadastroFuncionario"> 

     <h2>Cadastrar Funcionário</h2>
            <div class="msg">
                <span>
                <!-- Mensagem de sucesso -->
                <?php if (isset($_SESSION['sucesso'])): ?>
                    <div class="msgsucesso">
                        <?php echo $_SESSION['sucesso']; ?>
                    </div>
                    <?php unset($_SESSION['sucesso']); // Limpa a mensagem após exibi-la ?>
                <?php endif; ?>

                <!-- Mensagem de erro -->
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="msgerro">
                        <?php echo $_SESSION['error']; ?>
                    </div>
                    <?php unset($_SESSION['error']); // Limpa a mensagem após exibi-la ?>
                <?php endif; ?>
                </span>
            </div>

    
            <form method="POST" action="../../controller/funcionario/createFuncionarioController.php" onsubmit="return validarFormulario()">
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" placeholder="Digite o nome completo do funcionário." required>
                <span id="mensagemErroNome" class="erro"></span>

                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" placeholder="Digite o CPF do funcionário" maxlength="14" required>
                <span id="mensagemErroCpf" class="erro"></span>
                    <?php if (isset($_SESSION['cpf_error'])): ?>
                        <span style="color:#000000;"><?php echo $_SESSION['cpf_error']; ?></span>
                        <?php unset($_SESSION['cpf_error']); // Limpa a mensagem após exibi-la ?>
                    <?php endif; ?>

                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" placeholder="Digite o telefone do funcionário" maxlength="15" required>
                <span id="mensagemErroTelefone" class="erro"></span>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Digite o email do funcionário." required>
                <span id="mensagemErroEmail" class="erro"></span>
                    <?php if (isset($_SESSION['email_error'])): ?>
                        <span style="color:#000000;"><?php echo $_SESSION['email_error']; ?></span>
                        <?php unset($_SESSION['email_error']); 
                        // Limpa a mensagem após exibi-la ?>
                    <?php endif; ?>

                <label for="confirmarEmail">Confirme o Email:</label>
                <input type="email" id="confirmarEmail" name="confirmarEmail" placeholder="Por favor, confirme o email" required>
                <span id="mensagemErroEmailDiferente" class="erro"></span>
                
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" placeholder="Insira a senha do funcionário" required>
                <span id="mensagemErroSenha" class="erro"></span>
                    <?php if (isset($_SESSION['senha_error'])): ?>
                        <span style="color: #000000;"><?php echo $_SESSION['senha_error']; ?></span>
                        <?php unset($_SESSION['senha_error']); // Limpa a mensagem após exibi-la ?>
                    <?php endif; ?>
                <label for="confirmarSenha">Confirme a Senha:</label>
                <input type="password" id="confirmarSenha" name="confirmarSenha" placeholder="Confirme a senha" required>
                <span id="mensagemErroSenhaDiferente" class="erro"></span>
                <div class="tipoPerfil">
                <label for="t_perfil_id">Perfil:</label>
                    <select class="selecaoPerfil" name="t_perfil_id" required>
                        <option value="1">Administrador</option>
                        <option value="2">Funcionário</option>
                    </select>
                </div>
                <br><br>
                <button class="formButton" type="submit">Cadastrar Funcionário</button>
            </form>

    </div>
    </main>
    <script src="../../assets/js/mascarasFuncionario.js"></script>
</body>
</html>
