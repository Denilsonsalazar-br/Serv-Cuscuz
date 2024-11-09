<?php

// Iniciar a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "../../../controller/produto/dashboardController.php";
$dashboardController = new DashboardController();
$dashboardController->mostrarDashboardAdmin();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/headerCadastro.css">
    <link rel="stylesheet" href="../../assets/css/painelControleAdmin.css">
    <link rel="stylesheet" href="../../assets/css/produto/dashboardProduto.css">
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
        <nav >
            <a href="../../view/admin/adminPainelController.php">Home</a>
            <a href="../../view/admin/produtos.php">Produtos</a>
            <a href="#">Pedidos</a>
            <a href="../../view/admin/listaFuncionarios.php">Funcionários</a>
            <a href="../../view/admin/listaCliente.php">Clientes</a>
            <a href="../../view/admin/carrosselHome.php">Carrossel Home</a>
            <a href="#">Relatórios</a>
        </nav>
    </div>
    <section class="BemVindoAdm">
        <?php 
        // Verifica se o usuário é um administrador
        if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 'ADMINISTRADOR') {
            header("Location: ../../controller/admin/adminPainelController.php");
            exit;
        }
        
        echo "<h1>Bem-vindo, " . $_SESSION['nome'] . "!</h1>";
        
        ?>
    </section>

    <!-- dashboard-->
    <main>
        <h2>Dashboard dos produtos cadastrados!</h2>
        <div class="dashboard-container">
            <div class="dashboard-item">
                <h3>Total de Produtos Pequenos (P)</h3>
                <p><?php echo $_SESSION['totalP']; ?> produtos</p>
            </div>
            <div class="dashboard-item">
                <h3>Total de Produtos Médios (M)</h3>
                <p><?php echo $_SESSION['totalM']; ?> produtos</p>
            </div>
            <div class="dashboard-item">
                <h3>Total de Produtos Grandes (G)</h3>
                <p><?php echo $_SESSION['totalG']; ?> produtos</p>
            </div>
        </div>
        <div class="graficoProduto">
            <input type="hidden" id="totalP" value="<?php echo $_SESSION['totalP']; ?>">
            <input type="hidden" id="totalM" value="<?php echo $_SESSION['totalM']; ?>">
            <input type="hidden" id="totalG" value="<?php echo $_SESSION['totalG']; ?>">
            <canvas id="graficoProdutos"></canvas>

            <script src="../../assets/js/produto/graficoProdutos.js"></script>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 
</body>
</html>
