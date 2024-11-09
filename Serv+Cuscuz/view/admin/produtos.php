<?php
// Iniciar a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once __DIR__ . "../../../controller/produto/readProdutoController.php";

$readProdutoController = new ReadProdutoController();
$produtos = $readProdutoController->getAllProdutos(); 
// Obtém todos os produtos cadastrados
//print_r($produtos); 
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

    <!--abre navegação-->
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
<!--Fecha navegação-->

<section class="section__btnFuncionario novoCuscuz">
        <h2>Produtos Cadastrados</h2>
        <a class="btnAdm" href="../../view/admin/cadastrarProduto.php">Novo</a>
    </section>
    
    <main>
    <?php if (empty($produtos)): ?>
        <p>Nenhum produto cadastrado.</p>
    <?php else: ?>
        <!-- Abas de Tamanho -->
        <div class="tabs">
            <button class="tablink active" onclick="openTab(event, 'P')">P</button>
            <button class="tablink" onclick="openTab(event, 'M')">M</button>
            <button class="tablink" onclick="openTab(event, 'G')">G</button>
        </div>

        <!--mensagens após a edição -->
        <?php
            if (isset($_SESSION['msg'])) {
                $msgTipo = $_SESSION['msg']['tipo'] === 'sucesso' ? 'msgsucesso' : 'msgerro';
                echo '<div class="msg ' . $msgTipo . '">
                        <h4>' . ucfirst($_SESSION['msg']['tipo']) . '</h4>
                        <p>' . $_SESSION['msg']['mensagem'] . '</p>
                    </div>';
                unset($_SESSION['msg']); 
            }
        ?>

        <!-- Conteúdo das Abas -->
        <div id="P" class="tabcontent">
                <h3>P</h3>
                <div class="produto-container">
                    <?php foreach ($produtos as $produto): ?>
                        <?php if ($produto->getTamanho() === 'P'): ?>
                            <div class="produto-card">
                                <img src="<?php echo '../../assets/img/' . basename($produto->getImagem()); ?>" alt="<?php echo htmlspecialchars($produto->getNome()); ?>" class="produto-imagem">
                                <h4><?php echo htmlspecialchars($produto->getNome()); ?></h4>
                                <p class="descricao"><?php echo htmlspecialchars($produto->getDescricao()); ?></p>
                                <p class="preco">Preço: R$ <?php echo number_format($produto->getPreco(), 2, ',', '.'); ?></p>
                                
                                <div class="actions">
                                    <form action="../../view/admin/editarProduto.php" method="GET" class="form-edit">
                                        <input type="hidden" name="id" value="<?php echo $produto->getId(); ?>">
                                        <button type="submit" class="btn-edit">Editar</button>
                                    </form>
                                    <form action="../../controller/produto/deleteProdutoController.php" method="POST" class="form-delete">
                                        <input type="hidden" name="id" value="<?php echo $produto->getId(); ?>">
                                        <button type="submit" class="btn-delete">Excluir</button>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <div id="M" class="tabcontent">
                <h3>M</h3>
                <div class="produto-container">
                    <?php foreach ($produtos as $produto): ?>
                        <?php if ($produto->getTamanho() === 'M'): ?>
                            <div class="produto-card">
                                <img src="<?php echo '../../assets/img/' . basename($produto->getImagem()); ?>" alt="<?php echo htmlspecialchars($produto->getNome()); ?>" class="produto-imagem">
                                <h4><?php echo htmlspecialchars($produto->getNome()); ?></h4>
                                <p class="descricao"><?php echo htmlspecialchars($produto->getDescricao()); ?></p>
                                <p class="preco">Preço: R$ <?php echo number_format($produto->getPreco(), 2, ',', '.'); ?></p>
                                
                                <div class="actions">
                                    <form action="../../view/admin/editarProduto.php" method="GET" class="form-edit">
                                        <input type="hidden" name="id" value="<?php echo $produto->getId(); ?>">
                                        <button type="submit" class="btn-edit">Editar</button>
                                    </form>
                                    <form action="../../controller/produto/deleteProdutoController.php" method="POST" class="form-delete">
                                        <input type="hidden" name="id" value="<?php echo $produto->getId(); ?>">
                                        <button type="submit" class="btn-delete">Excluir</button>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <div id="G" class="tabcontent">
                <h3>G</h3>
                <div class="produto-container">
                    <?php foreach ($produtos as $produto): ?>
                        <?php if ($produto->getTamanho() === 'G'): ?>
                            <div class="produto-card">
                                <img src="<?php echo '../../assets/img/' . basename($produto->getImagem()); ?>" alt="<?php echo htmlspecialchars($produto->getNome()); ?>" class="produto-imagem">
                                <h4><?php echo htmlspecialchars($produto->getNome()); ?></h4>
                                <p class="descricao"><?php echo htmlspecialchars($produto->getDescricao()); ?></p>
                                <p class="preco">Preço: R$ <?php echo number_format($produto->getPreco(), 2, ',', '.'); ?></p>
                                
                                <div class="actions">
                                    <form action="../../view/admin/editarProduto.php" method="GET" class="form-edit">
                                        <input type="hidden" name="id" value="<?php echo $produto->getId(); ?>">
                                        <button type="submit" class="btn-edit">Editar</button>
                                    </form>
                                    <form action="../../controller/produto/deleteProdutoController.php" method="POST" class="form-delete">
                                        <input type="hidden" name="id" value="<?php echo $produto->getId(); ?>">
                                        <button type="submit" class="btn-delete">Excluir</button>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

        <?php endif; ?>
    </main>

<script src="../../assets/js/produto/produto.js"></script>
</body>
</html>