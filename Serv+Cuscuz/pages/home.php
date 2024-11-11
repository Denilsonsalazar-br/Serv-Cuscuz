<?php
// Iniciar a sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
    require_once __DIR__ . "../../controller/produto/readProdutoController.php";

    $readProdutoController = new ReadProdutoController();
    $produtos = $readProdutoController->getAllProdutos(); 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/home/home.css">
    <link rel="stylesheet" href="../assets/css/home/produtos.css">
    <title>Serv+Cuscuz</title>
</head>
<body>
    <div class="containerHome">
        <header>
            <?php include '../includes/header.php'; ?>
        </header>

        <section>
            <?php include '../includes/carrossel.php'; ?>
        </section>

        <main>
            <!--<h2>Produtos</h2>-->
            <?php if (empty($produtos)): ?>
                <p>Nenhum produto disponível no momento.</p>
            <?php else: ?>
                <div class="produto-container">
                    <?php foreach ($produtos as $produto): ?>
                        <div class="produto-card">
                            <img src="<?php echo '../assets/img/' . basename($produto->getImagem()); ?>" alt="<?php echo htmlspecialchars($produto->getNome()); ?>" class="produto-imagem">
                            <h4><?php echo htmlspecialchars($produto->getNome()); ?></h4>
                            <p class="descricao"><?php echo htmlspecialchars($produto->getDescricao()); ?></p>
                            <p class="preco">Preço: R$ <?php echo number_format($produto->getPreco(), 2, ',', '.'); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>

        <footer>
            <?php include '../includes/footer.php'; ?>
        </footer>
    </div>
</body>
</html>