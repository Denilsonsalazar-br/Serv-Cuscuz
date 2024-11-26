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
    <link rel="stylesheet" href="../../assets/css/mensagens/mensagens.css">
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
        <nav class="navbar" >
        <a href="../../view/admin/adminPainelController.php">Home</a>
            <a href="../../view/admin/categoria.php">Categoria</a>
            <a href="../../view/admin/produtos.php">Produtos</a>
            <a href="../../view/admin/pedidos.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'pedidos.php') ? 'ativo' : ''; ?>">Pedidos</a>
            <a href="../../view/admin/listaFuncionarios.php">Funcionários</a>
            <a href="../../view/admin/listaCliente.php">Clientes</a>
            <a href="../../view/admin/carrosselHome.php">Carrossel Home</a>
            <a href="../../view/admin/relatorios.php">Relatórios</a>
        </nav>
    </div>

</body>
</html>