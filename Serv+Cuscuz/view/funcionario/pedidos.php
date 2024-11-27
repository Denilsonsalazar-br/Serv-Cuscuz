<?php
// Iniciar a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} 

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'FUNCIONARIO') {
    header("Location: ../../pages/login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/headerCadastro.css">
    <link rel="stylesheet" href="../../assets/css/painelControleAdmin.css">
    <link rel="stylesheet" href="../../assets/css/produto/produto.css">
    <link rel="stylesheet" href="../../assets/css/mensagens/mensagens.css">
    <title>Produtos</title>
</head>
<body>
    <header>
        <nav class="nav-bar">    
            <div class="logo">
                <a href="#">
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
    <!--abre navegação-->
    <div class="painelAdm">
        <nav class="navbar">
            <a href="../../view/funcionario/paginaHomeFuncionario.php">Home</a>
            <a href="../../view/funcionario/produtos.php">Produtos</a>
            <a href="../../view/funcionario/pedidos.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'pedidos.php') ? 'ativo' : ''; ?>">Pedidos</a>
            <a href="../../view/funcionario/estoque.php" >Estoque</a>
            <a href="../../view/funcionario/relatorio.php">Relatórios</a>
        </nav>
    </div> 

</body>
</html>