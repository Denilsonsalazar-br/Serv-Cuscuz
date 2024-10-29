<?php
// Iniciar a sessão
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
    <link rel="stylesheet" href="../../assets/css/painelControleAdmin.css">
    <title>Administração</title>
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
        <nav>
            <a href="../../view/funcionario/paginaHomeFuncionario.php">Home</a>
            <a href="#">Produtos</a>
            <a href="#">Pedidos</a>
            <a href="#">Estoque</a>
            <a href="#">Relatórios</a>
        </nav>
    </div> 
    <section class="BemVindoAdm">
        <?php
            // Verifica se o usuário está logado e se é um funcionário
            if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 'FUNCIONARIO') {
            // Se não for funcionário, redireciona para a página de login ou outra página
            header("Location: ../../pages/home.php");
    exit;
}

// Mensagem de boas-vindas
echo "<h1>Bem-vindo, " . $_SESSION['nome'] . "!</h1>";
// Aqui você pode adicionar mais conteúdo para a página do funcionário
?>
    </section>
