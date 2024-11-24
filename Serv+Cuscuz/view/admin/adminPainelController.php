<?php

// Iniciar a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*if (isset($_SESSION['dadosClientes'])) {
    // Exibir os dados
    var_dump($_SESSION['dadosClientes']);
} else {
    echo "Dados de clientes não encontrados.";
}*/

require_once __DIR__ . "../../../controller/produto/dashboardController.php";
$dashboardController = new DashboardController();
$dashboardController->mostrarDashboardAdmin();

require_once __DIR__ . "../../../controller/cliente/dashboardController.php";
$clienteDashboardController = new ClienteDashboardController();
$clienteDashboardController->mostrarDashboardCliente();


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
    <link rel="stylesheet" href="../../assets/css/cliente/dashboardCliente.css">
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
    <section>
        <h2>Categorias Cadastradas</h2>

        <!-- Incorporar dados PHP como um objeto JSON -->
        <script>
            const dadosCategorias = <?php echo json_encode($_SESSION['dadosCategorias']); ?>;
        </script>


            <div class="tabs">
                <?php foreach ($_SESSION['dadosCategorias'] as $categoriaNome => $tamanhos): ?>
                    <button class="tablink" onclick="openTab(event, '<?php echo $categoriaNome; ?>')"><?php echo htmlspecialchars($categoriaNome); ?></button>
                <?php endforeach; ?>
            </div>
            

        <!-- Conteúdo dentro de cada aba da categoria -->
        <?php foreach ($_SESSION['dadosCategorias'] as $categoriaNome => $tamanhos): ?>
            <div id="<?php echo $categoriaNome; ?>" class="tabcontent">
            <h3><?php echo htmlspecialchars($categoriaNome); ?></h3>
                    <p>Pequeno (P):<span class="tabcontent-p"> <?php echo $tamanhos['P']; ?> </span>produtos</p>
                    <p>Médio (M):<span class="tabcontent-p"><?php echo $tamanhos['M']; ?> </span> produtos</p>
                    <p>Grande (G): <span class="tabcontent-p"><?php echo $tamanhos['G']; ?> </span>produtos</p>

                <div class="graficoProduto">
                    <canvas id="grafico_<?php echo $categoriaNome; ?>"></canvas>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
    <section>
    <h2>Clientes Cadastrados</h2>

    <?php if (isset($_SESSION['dadosClientes']) && !empty($_SESSION['dadosClientes'])): ?>
        <script>
            const dadosClientes = <?php echo json_encode($_SESSION['dadosClientes']); ?>;
        </script>

        <div class="tabs">
            <?php foreach (['mes' => 'Mês', 'trimestre' => 'Trimestre', 'semestre' => 'Semestre', 'ano' => 'Ano'] as $periodo => $nomePeriodo): ?>
                <button class="tablink" onclick="openTab(event, '<?php echo $periodo; ?>')"><?php echo $nomePeriodo; ?></button>
            <?php endforeach; ?>
        </div>

            <?php foreach (['mes' => 'Mês', 'trimestre' => 'Trimestre', 'semestre' => 'Semestre', 'ano' => 'Ano'] as $periodo => $nomePeriodo): ?>
            <div id="<?php echo $periodo; ?>" class="tabcontent">
                <h3>Clientes cadastrados no <?php echo $nomePeriodo; ?></h3>
                
                <?php if (isset($_SESSION['dadosClientes'][$periodo]['atual'])): ?>
                    <p>Total de Clientes: <span class="tabcontent-p"><?php echo $_SESSION['dadosClientes'][$periodo]['atual']; ?></span></p>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['dadosClientes'][$periodo]['diferenca'])): ?>
                    <p>Crescimento de clientes em relação ao mês anterior:</p>
                <?php endif; ?>
                <div class="graficoClienteGeral">
                        
                    <div class="graficoCliente1">
                        <span class="tabcontentCliente">
                            <?php echo $_SESSION['dadosClientes'][$periodo]['diferenca']; ?>%
                        </span>
                        <canvas id="grafico_<?php echo $periodo; ?>"></canvas>
                    </div>
                    <div class="graficoCliente2">
                        <canvas id="grafico_geral"></canvas>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>

    <?php else: ?>
        <p>Dados de clientes não encontrados.</p>
    <?php endif; ?>
</section>

</main>

<script src="../../assets/js/CDNs/chart.js"></script>
<script src="../../assets/js/graficos/graficoProdutos.js"></script>
<script src="../../assets/js/graficos/graficoCliente.js"></script>


</body>
</html>