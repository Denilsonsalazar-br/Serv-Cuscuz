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

// Incluir o controlador que fará a listagem das categorias
require_once __DIR__ ."../../../controller/categoria/listagemCategoriaController.php";

// Instanciar o controlador e obter as categorias
$categoriaController = new CategoriaListController();
$categorias = $categoriaController->execute();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/headerCadastro.css">
    <link rel="stylesheet" href="../../assets/css/painelControleAdmin.css">
    <link rel="stylesheet" href="../../assets/css/produto/dashboardProduto.css">
    <link rel="stylesheet" href="../../assets/css/mensagens/mensagens.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
    <script src="../../assets/js/CDNs/jquery-3.7.1.min.js"></script>
    <script src="../../assets/js/CDNs/dataTables.js"></script>

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
        <nav class="navbar">
        <a href="../../view/admin/adminPainelController.php">Home</a>
            <a href="../../view/admin/categoria.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'categoria.php') ? 'ativo' : ''; ?>">Categoria</a>
            <a href="../../view/admin/produtos.php">Produtos</a>
            <a href="../../view/admin/pedidos.php">Pedidos</a>
            <a href="../../view/admin/listaFuncionarios.php">Funcionários</a>
            <a href="../../view/admin/listaCliente.php">Clientes</a>
            <a href="../../view/admin/carrosselHome.php">Carrossel Home</a>
            <a href="../../view/admin/relatorios.php">Relatórios</a>
        </nav>
    </div>

    <div class="homeAdm">
    <main>
        <h1>Categorias</h1>

        <section class="section__btnFuncionario">

        <div class="alertaSucessoError">

            <!-- mensagem de sucessou ou erro da edição-->
            <?php if (isset($_SESSION['successeditCategoria'])): ?>
                <div class="msg msgsucesso" id="msgSucesso">
                    <h4>Sucesso!</h4>
                    <p><?php echo htmlspecialchars($_SESSION['successeditCategoria']); ?></p>
                </div>
                <?php unset($_SESSION['successeditCategoria']); // Clear the message from the session ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['erroreditCategoria'])): ?>
                <div class="msg msgerro" id="msgErro">
                    <h4>Erro!</h4>
                    <p><?php echo htmlspecialchars($_SESSION['erroreditCategoria']); ?></p>
                </div>
                <?php unset($_SESSION['erroreditCategoria']); // Clear the message from the session ?>
            <?php endif; ?>

        <!-- Mensagens de sucesso ou erro do cadastro-->
        <?php if (isset($_SESSION['successCategoria'])): ?>
            <div class="msg msgsucesso">
                <h4>Sucesso!</h4>
                <p><?php echo $_SESSION['successCategoria']; ?></p>
            </div>
            <?php unset($_SESSION['successCategoria']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['errorCategoria'])): ?>
            <div class="msg msgerro">
                <h4>Erro!</h4>
                <p><?php echo $_SESSION['errorCategoria']; ?></p>
            </div>
            <?php unset($_SESSION['errorCategoria']); ?>
        <?php endif; ?>

        <!-- Mensagens de sucesso ou erro ao excluir -->
        <?php if (isset($_SESSION['successDeleteCategoria'])): ?>
            <div class="msg msgsucesso">
                <h4>Sucesso!</h4>
                <p><?php echo $_SESSION['successDeleteCategoria']; ?></p>
            </div>
            <?php unset($_SESSION['successDeleteCategoria']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['errorDeleteCategoria'])): ?>
            <div class="msg msgerro">
                <h4>Erro!</h4>
                <p><?php echo $_SESSION['errorDeleteCategoria']; ?></p>
            </div>
            <?php unset($_SESSION['errorDeleteCategoria']); ?>
        <?php endif; ?>


        </div>
        
        <a class="btnAdm" href="../../view/admin/cadastroCategoria.php">Nova Categoria</a>

    </section>
    
        <section>
            <table id="myTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th class="gerenciarAdm">Gerenciar</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (isset($categorias) && is_array($categorias)): ?>
                    <?php foreach ($categorias as $categoria): ?>   
                    <tr>
                        <td>
                            <?php echo htmlspecialchars($categoria['id']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($categoria['nome']); ?>
                        </td>
                        <td class="tdOperacao">
                            <div class="alterarExcluir">

                                <!-- token usado para codificar o id na URL -->
                                <a class="btnalterar" href="../../view/admin/editarCategoria.php?token=<?= base64_encode($categoria['id']); ?>">Alterar</a>

                                <a class="btnexcluir" href="../../controller/categoria/deleteCategoriaController.php?id=<?= $categoria['id']; ?>" onclick="return confirm('Deseja confirmar a operação?');">Excluir</a>
                            </div>
                        </td>         
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    </tbody>
                    <tr>
                        <td colspan="3">Nenhuma categoria encontrada.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </section>
    </main>
</div>

<script>
    $(document).ready( function () {
        $('#myTable').DataTable( {
            language: {
                url: '../../assets/js/CDNs/dataTable-pt-BR.json',
            }
        } );
        
    } );
</script>

<script src="../../assets/js/mensagens/tempoMensagem.js"></script>
</body>
</html>