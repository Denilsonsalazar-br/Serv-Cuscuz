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
    <link rel="stylesheet" href="../assets/css/home/main.css">
    <title>Serv+Cuscuz</title>
</head>
<body>

    <header>
        <?php include '../includes/header.php'; ?>
    </header>

    <div class="containerHome">
            <section>
                <?php include '../includes/carrossel.php'; ?>
            </section>

            <main>
                <?php if (empty($produtos)): ?>
                    <p>Nenhum produto disponível no momento.</p>
                <?php else: ?>
                    <div class="produto-container">
                        <?php foreach ($produtos as $produto): ?>
                            <div class="produto-card">
                                <img src="<?php echo '../assets/img/' . basename($produto->getImagem()); ?>" alt="<?php echo htmlspecialchars($produto->getNome()); ?>" class="produto-imagem">
                                
                                <h2><?php echo htmlspecialchars($produto->getNome()); ?></h2>

                                <p class="descricao"><?php echo htmlspecialchars($produto->getDescricao()); ?></p>

                                <p class="preco">Preço: R$ <?php echo number_format($produto->getPreco(), 2, ',', '.'); ?></p>

                                <div>
                                    <button class="add-carrinho-btn" onclick="openModal('<?php echo htmlspecialchars($produto->getNome()); ?>', '<?php echo htmlspecialchars($produto->getDescricao()); ?>', '<?php echo number_format($produto->getPreco(), 2, ',', '.'); ?>', '../assets/img/<?php echo basename($produto->getImagem()); ?>')">+</button>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </main>

            <!-- Modal -->
            <div id="produtoModal" class="modal" onclick="closeModalOnOutsideClick(event)">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <div class="modal-body">
                        <img id="modalImagem" src="" alt="Imagem do Produto" class="modal-imagem">
                        <div class="modal-info">
                            <h4 id="modalNome"></h4>
                            <p id="modalDescricao"></p>

                            <div class="productInfo--label">Preço</div>
                            <div class="productInfo--price">
                                <div id="modalPreco" class="productInfo--actualPrice">R$ --</div>
                                <div class="productInfo--quantityArea">
                                    <button class="productInfo--decreaseQuantity" onclick="updateQuantity(-1)">-</button>
                                    <div id="modalQuantidade" class="productInfo--quantity">1</div>
                                    <button class="productInfo--increaseQuantity" onclick="updateQuantity(1)">+</button>
                                </div>
                            </div>

                            <div class="modal-buttons">
                                <button class="btn-adicionar">Adicionar ao carrinho</button>
                                <button class="btn-cancelar" onclick="closeModal()">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script src="../assets/js/home/modal.js"></script>
         
    </div>

    <footer>
            <?php include '../includes/footer.php'; ?>
    </footer>
</body>
</html>