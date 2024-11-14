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
    <link rel="stylesheet" href="../../assets/css/produto/abaDashboardProduto.css">
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
            <a href="../../view/admin/categoria.php">Categoria</a>
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
    <h2>Categorias Cadastrados</h2>

    <!-- Incorporar dados PHP como um objeto JSON -->
    <script>
        const dadosCategorias = <?php echo json_encode($_SESSION['dadosCategorias']); ?>;
    </script>


        <div class="tabs">
            <?php foreach ($_SESSION['dadosCategorias'] as $categoriaNome => $tamanhos): ?>
                <button class="tablink" onclick="openTab(event, '<?php echo $categoriaNome; ?>')"><?php echo htmlspecialchars($categoriaNome); ?></button>
            <?php endforeach; ?>
        </div>
        


    <?php foreach ($_SESSION['dadosCategorias'] as $categoriaNome => $tamanhos): ?>
        <div id="<?php echo $categoriaNome; ?>" class="tabcontent">
            <h3><?php echo htmlspecialchars($categoriaNome); ?></h3>
            <p>Pequeno (P): <?php echo $tamanhos['P']; ?> produtos</p>
            <p>Médio (M): <?php echo $tamanhos['M']; ?> produtos</p>
            <p>Grande (G): <?php echo $tamanhos['G']; ?> produtos</p>

            <div class="graficoProduto">
                <canvas id="grafico_<?php echo $categoriaNome; ?>"></canvas>
            </div>
        </div>
    <?php endforeach; ?>
</main>

<script src="../../assets/js/produto/dashboard.js"></script>
<!--<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>-->
<script src="../../assets/js/CDNs/chart.js"></script>
<script src="../../assets/js/produto/graficoProdutos.js"></script>


</body>
</html>