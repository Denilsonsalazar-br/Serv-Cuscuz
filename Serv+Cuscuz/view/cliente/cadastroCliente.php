<?php
// Iniciar a sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/headerCadastro.css">
    <link rel="stylesheet" href="../../assets/css/cadastroCliente.css">
    <title>Páginan de Cadastro</title>
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
                <button><a href="../../pages/login.php">Login</a></button>
            </div>
        </nav>
    </header>
    <!--<div class="tituloCadastroCliente">
        <h1>Serv+Cuscuz</h1> 
        <h3>"Mais sabor, mais praticidade!"</h3>
    </div>-->
        <div class="containerCadastroCliente">
                <div class="msg">
                <span>
                    <!--Mensagem de sucesso-->
                    <?php if (isset($_SESSION['sucesso'])): ?>
                        <span style="color:green;">
                            <?php echo $_SESSION['sucesso']; ?>
                        </span>
                        <?php unset($_SESSION['sucesso']); // Limpa a mensagem após exibi-la ?>
                    <?php endif; ?>

                    <!--Mensagem de erro-->

                    <?php if (isset($_SESSION['error'])): ?>
                        <span style="color:red;">
                            <?php echo $_SESSION['error']; ?>
                        </span>
                        <?php unset($_SESSION['error']); // Limpa a mensagem após exibi-la ?>
                    <?php endif; ?>
                </span>
            </div>
            <form method="POST" action="../../controller/cliente/createClienteController.php" onsubmit="return validarFormulario()">

                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" placeholder="Digite seu nome." required>
                <span id="mensagemErroNome" class="erro"></span>
                <br>
                <label for="sobrenome">Sobrenome:</label>
                <input type="text" id="sobrenome" name="sobrenome" placeholder="Digite seu sobrenome completo." required>
                <span id="mensagemErroSobrenome" class="erro"></span>
                <br>
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF" maxlength="14" required>
                <span id="mensagemErroCpf" class="erro"></span>
                <br>
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" placeholder="Digite seu telefone" required>
                <span id="mensagemErroTelefone" class="erro"></span>
                <br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Digite seu email." required>
                <span id="mensagemErroEmail" class="erro"></span>
                <br>
                <label for="confirmarEmail">Confirme o Email:</label>
                <input type="email" id="confirmarEmail" name="confirmarEmail" placeholder="Por favor, confirme seu email" required>
                <span id="mensagemErroEmailDiferente" class="erro"></span>
                <br>
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" placeholder="Insira sua senha" required>
                <span id="mensagemErroSenha" class="erro"></span>
                <br>
                <label for="confirmarSenha">Confirme a Senha:</label>
                <input type="password" id="confirmarSenha" name="confirmarSenha" placeholder="Confirme sua senha" required>
                <span id="mensagemErroSenhaDiferente" class="erro"></span>
                <br><br>

                <div class="termos">
                    <div>
                        <input type="checkbox" id="termos" required>
                    </div>
                    <div>
                        <label for="termos">Aceito os <a href="#">termos e condições</a></label>
                    </div>
                </div>
                
                <div class="botaoCadastrarCliente">
                    <button type="submit">Cadastrar</button>
                </div> 
            </form>
        </div>
</main>

<!--<footer>
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <?php 
        //include '../../includes/footer.php';
    ?>
</footer>-->
<script href="../../assets/js/mascaras.js"></script>
</body>
</html>
