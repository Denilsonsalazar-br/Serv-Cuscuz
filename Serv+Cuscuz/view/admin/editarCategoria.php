<?php
// Iniciar a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "../../../model/DAO/categoriaDAO.php";
require_once __DIR__ . "../../../controller/categoria/editCategoriaController.php";

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/headerCadastro.css">
    <link rel="stylesheet" href="../../assets/css/painelControleAdmin.css">
    <link rel="stylesheet" href="../../assets/css/categoria/editarCategoria.css">
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
            <a href="../../view/admin/pedidos.php">Pedidos</a>
            <a href="../../view/admin/listaFuncionarios.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'listaFuncionarios.php   ') ? 'ativo' : ''; ?>">Funcionários</a>
            <a href="../../view/admin/listaCliente.php">Clientes</a>
            <a href="../../view/admin/carrosselHome.php">Carrossel Home</a>
            <a href="../../view/admin/relatorios.php">Relatórios</a>
        </nav>
    </div>

    <!-- Mensagens de sucesso ou erro de edição -->
    <?php if (isset($_SESSION['successeditCategoria'])): ?>
        <div class="msg msgsucesso">
            <h4>Sucesso!</h4>
            <p><?php echo $_SESSION['successeditCategoria']; ?></p>
        </div>
        <?php unset($_SESSION['successeditCategoria']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['erroreditCategoria'])): ?>
        <div class="msg msgerro">
            <h4>Erro!</h4>
            <p><?php echo $_SESSION['erroreditCategoria']; ?></p>
        </div>
        <?php unset($_SESSION['erroreditCategoria']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['errorCategoria'])): ?>
        <div class="msg msgerro">
            <h4>Erro!</h4>
            <p><?php echo $_SESSION['errorCategoria']; ?></p>
        </div>
        <?php unset($_SESSION['errorCategoria']); ?>
    <?php endif; ?>

    <main>
        <h1 class="editarCategoria">Editar Categoria</h1>
        <section class="section__formCategoria">
            <form action="../../controller/categoria/editCategoriaController.php" method="post">
                <?php if (isset($_SESSION['categoriaEditar'])): ?>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($_SESSION['categoriaEditar']['id']); ?>">
                    <label for="nome">Nome da Categoria:</label>
                    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($_SESSION['categoriaEditar']['nome']); ?>" required>
                <?php else: ?>
                    <p>Categoria não encontrada. Por favor, tente novamente.</p>
                <?php endif; ?>
                <button type="submit" class="btnSalvar">Salvar Alterações</button>
                <a href="../../view/admin/categoria.php" class="btnCancelar">Cancelar</a>
            </form>
        </section>
    </main>
</body>
</html>