<?php
// Iniciar a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "../../../controller/produto/dashboardController.php";
$dashboardController = new DashboardController();
$dashboardController->mostrarDashboard();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/paginaHomeFuncionario.css">
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
    
    <div class="painelAdmFun">
        <nav>
            <a href="../../view/funcionario/paginaHomeFuncionario.php">Home</a>
            <a href="../../view/funcionario/produtos.php">Produtos</a>
            <a href="#">Pedidos</a>
            <a href="#">Estoque</a>
            <a href="#">Relatórios</a>
        </nav>
    </div> 
    <section>
        <div class="BemVindoAdmFun">
            <?php
                // Verifica se o usuário está logado e se é um funcionário
                if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 'FUNCIONARIO') {
                // Se não for funcionário, redireciona para a página home 
                header("Location: ../../pages/home.php");
                exit;
            }

            // Mensagem de boas-vindas
            echo "<h1>Bem-vindo, " . $_SESSION['nome'] . "!</h1>";
            ?>
        </div>
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