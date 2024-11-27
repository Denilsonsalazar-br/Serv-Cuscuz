<?php
// Iniciar a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'ADMINISTRADOR') {
    header("Location: ../../pages/login.php");
    exit();
}

require_once __DIR__ ."../../../controller/categoria/createCategoriaController.php";

// Verificar se o controlador foi instanciado corretamente
$controller = new CategoriaCreateController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->execute();  // Executa o controlador para criar a categoria
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/headerCadastro.css">
    <link rel="stylesheet" href="../../assets/css/painelControleAdmin.css">
    <link rel="stylesheet" href="../../assets/css/produto/dashboardProduto.css">
    <link rel="stylesheet" href="../../assets/css/categoria/cadastroCategoria.css">
    <title>Nova Categoria</title>
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
        <nav class="navbar">
            <a href="../../view/admin/adminPainelController.php">Home</a>
            <a href="../../view/admin/categoria.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'cadastroCategoria.php') ? 'ativo' : ''; ?>">Categoria</a>
            <a href="../../view/admin/produtos.php">Produtos</a>
            <a href="../../view/admin/pedidos.php">Pedidos</a>
            <a href="../../view/admin/listaFuncionarios.php">Funcionários</a>
            <a href="../../view/admin/listaCliente.php">Clientes</a>
            <a href="../../view/admin/carrosselHome.php">Carrossel Home</a>
            <a href="../../view/admin/relatorios.php">Relatórios</a>
        </nav>
    </div>

    <!-- Formulário de Cadastro de Categoria -->
    <main>
        <h1>Cadastro de Nova Categoria</h1>
        <form class="form-categoria" method="POST" action="">
            <label class="label" for="nome">Nome da Categoria</label>
            <input type="text" class="input-field" id="nome" name="nome" required>

            <div>
                <button type="submit" class="btn-submit">Cadastrar Categoria</button>
                <a href="../../view/admin/categoria.php" class="btnCancelar">Cancelar</a>
            </div>
        </form>
    </main>
</body>
</html>
