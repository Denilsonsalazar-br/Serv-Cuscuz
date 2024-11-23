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
    <link rel="stylesheet" href="../../assets/css/produto/abaDashboardProduto.css">
    <title>Administração</title>
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

        </div>
    <?php endforeach; ?>
</main>

    <script src="../../assets/js/produto/dashboard.js"></script>
    <script src="../../assets/js/CDNs/chart.js"></script>
    <script src="../../assets/js/produto/graficoProdutos.js"></script>
</body>
</html>