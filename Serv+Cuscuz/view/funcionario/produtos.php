<?php
// Iniciar a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once __DIR__ . "../../../controller/produto/readProdutoController.php";

$readProdutoController = new ReadProdutoController();
$produtos = $readProdutoController->getAllProdutos(); // Obtém todos os produtos cadastrados
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
    <title>Produtos</title>
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
        <nav>
            <a href="../../view/funcionario/paginaHomeFuncionario.php">Home</a>
            <a href="../../view/funcionario/produtos.php">Produtos</a>
            <a href="#">Pedidos</a>
            <a href="#">Estoque</a>
            <a href="#">Relatórios</a>
        </nav>
    </div> 
    <section class="BemVindoAdm">
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
    </section>
    <section class="section__btnFuncionario novoCuscuz">
        <h2>Produtos Cadastrados</h2>
        <a class="btnAdm" href="../../view/funcionario/cadastrarProduto.php">Novo</a>
    </section>
    
    <main>
    
    <?php if (empty($produtos)): ?>
        <p>Nenhum produto cadastrado.</p>
    <?php else: ?>
        <div class="tamanho-secao">
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
                                <form action="../../view/funcionario/editarProduto.php" method="GET" class="form-edit">
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

        <div class="tamanho-secao">
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
                                <form action="../../view/funcionario/editarProduto.php" method="GET" class="form-edit">
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

        <div class="tamanho-secao">
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
                                <form action="../../view/funcionario/editarProduto.php" method="GET" class="form-edit">
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

</body>
</html>