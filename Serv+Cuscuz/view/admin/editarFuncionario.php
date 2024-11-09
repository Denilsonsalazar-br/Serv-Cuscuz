<?php
// Iniciar a sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "../../../model/DTO/validacoes/validarCpf.php";
require_once __DIR__ . "../../../model/DTO/validacoes/validarSenha.php";
require_once __DIR__ . "../../../controller/funcionario/editFuncionarioController.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../assets/css/headerCadastro.css">
    <link rel="stylesheet" href="../../assets/css/cadastroFuncionario.css">
    <link rel="stylesheet" href="../../assets/css/mensagens.css">
    <link rel="stylesheet" href="../../assets/css/mensagens/mensagens.css">
    <title>Editar Funcionário</title>
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
                <?php include '../../pages/verificarLoginAdm.php'; ?>
            </button>
        </div>
    </nav>
</header>
<div class="painelAdm">
    <nav>
            <a href="../../view/admin/adminPainelController.php">Home</a>
            <a href="#">Produtos</a>
            <a href="#">Pedidos</a>
            <a href="../../view/admin/listaFuncionarios.php">Funcionários</a>
            <a href="../../view/admin/listaCliente.php">Clientes</a>
            <a href="../../view/admin/carrosselHome.php">Carrossel Home</a>
            <a href="#">Relatórios</a>
    </nav>
</div>

<main>
    <div class="formCadastroFuncionario"> 
        <h2>Editar informações do funcionário</h2>

        <form action="../../controller/funcionario/editFuncionarioController.php" method="POST" onsubmit="return validarFormulario()">
            <!--ID do funcionário oculto-->
            <input type="hidden" name="id" value="<?php echo $funcionario->getId(); ?>">

            <label>Nome completo:</label>
            <input type="text" id="nome" name="nome" placeholder="Digite o nome completo do funcionário" value="<?php echo $funcionario->getNome(); ?>" required>
            <span id="mensagemErroNome" class="erro"></span>
            
            <label>CPF:</label>
            <input type="text" id="cpf" maxlength="14" name="cpf" value="<?php echo $funcionario->getCpf(); ?>" required>
            <span id="mensagemErroCpf" class="erro"></span>

            <?php if (isset($_SESSION['cpf_error'])): ?>
                <span class="erro">
                    <?php echo $_SESSION['cpf_error']; ?>
                </span>
                <?php unset($_SESSION['cpf_error']); ?>
            <?php endif; ?>

            <label>Telefone:</label>
            <input type="text" id="telefone" name="telefone" value="<?php echo $funcionario->getTelefone(); ?>" required>
            <span id="mensagemErroTelefone" class="erro"></span>
            
            <label>Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $funcionario->getEmail(); ?>" required>
            <span id="mensagemErroEmail" class="erro"></span>

                <?php if (isset($_SESSION['email_error'])): ?>
                    <span class="erro">
                        <?php echo $_SESSION['email_error']; ?>
                    </span>
                    <?php unset($_SESSION['email_error']); ?>
                <?php endif; ?>

            <label>Confirme o Email:</label>
            <input type="email" id="confirmarEmail" name="confirmarEmail" placeholder="Por favor, confirme o email" required>
            <span id="mensagemErroEmailDiferente" class="erro"></span>
                    
            <label>Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Nova senha ou (deixe em branco para não alterar)">
            <span id="mensagemErroSenha" class="erro"></span>

            <?php if (isset($_SESSION['senha_error'])): ?>
                <span class="erro">
                    <?php echo $_SESSION['senha_error']; ?>
                </span>
                <?php unset($_SESSION['senha_error']); ?>
            <?php endif; ?>

            <label>Confirme a Senha:</label>
            <input type="password" id="confirmarSenha" name="confirmarSenha" placeholder="Confirme a nova senha (se alterada)">
            <span id="mensagemErroSenhaDiferente" class="erro"></span>


            <label>Perfil:</label>
            <select name="t_perfil_id">
                <option value="1" <?php echo $funcionario->getPerfilId() == 1 ? 'selected' : ''; ?>>Administrador</option>
                <option value="2" <?php echo $funcionario->getPerfilId() == 2 ? 'selected' : ''; ?>>Funcionário</option>
            </select>
            <br><br>
            <button class="formButton" type="submit">Atualizar Funcionário</button>
        </form>
    </div>

    <script src="../../assets/js/mascarasFuncionario.js"></script> 
</body>
</html>