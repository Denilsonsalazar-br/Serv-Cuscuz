<?php
// Iniciar a sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Verificar se o cliente está logado
if (!isset($_SESSION['id']) || !is_numeric($_SESSION['id'])) {
    // Exibe o modal ou redireciona para a página de login
    echo "<script>document.getElementById('loginModal').style.display = 'block';</script>";
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
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/home/home.css">
    <link rel="stylesheet" href="../assets/css/home/produtos.css">
    <link rel="stylesheet" href="../assets/css/home/main.css">
    <link rel="stylesheet" href="../assets/css/home/aside.css">
    <title>Serv+Cuscuz</title>
</head>
<body>


    <header>
    <nav class="nav-bar">
            <div class="logo" href="../pages/home.php">
                <a href="../pages/home.php">
                    <img src="../assets/img/logo-png-reduzida.png" alt="Serv+Cuscuz">
                </a>
            </div>
            <div class="nav-list">
                <ul>
                <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Quem somos</a></li>
                <!--<li class="nav-item"><a href="#" class="nav-link">Promoções</a></li>-->
                <li class="nav-item"><a href="#" class="nav-link">Promoções</a></li>
                </ul>
            </div>

            <div class="containerPerfilNome">
                    <div class="carrinhoCompra open-cart-bt">                      
                            <img onclick="toggleCartVisibility()" src="../assets/img/carrinhoBranco.png" alt="Icone Carrinho">  
                            <span id="cartItemCountBadge" class="badge" style="display: none;">0</span>
                    </div>
                    <div class="iconeUsuario">
                        <a href="#">
                            <img src="../assets/img/usuarioBranco.png" alt="Icone Usuario">
                        </a>
                    </div>
                <div class="nomeperfil">
                    <div>
                        <?php include '../pages/verificarLogin.php'; ?>
                    </div>
                </div>
                <div class="login-button">
                    <?php if (isset($_SESSION['id'])): ?>
                        <button><a href="../pages/logout.php">Sair</a></button>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mobile-menu-icon">
                <button onclick="menuShow()"><img class="icon" src="../assets/img/abrirMenu.png" alt=""></button>
            </div>
            
        </nav>
        
        <div class="mobile-menu">
            <ul>
                <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Quem somos?</a></li>
                <!--<li class="nav-item"><a href="#" class="nav-link">Promoções</a></li>-->
                <li class="nav-item"><a href="#" class="nav-link">Promoções</a></li>
            </ul>
            <div class="containerPerfilNome">
                <div class="nomeperfil" href="#">
                    
                    <div class="iconeUsuario">
                        <img src="../assets/img/usuarioBranco.png" alt="Icone Usuario">
                    </div>
                
                    <div>
                        <?php include '../pages/verificarLogin.php'; ?>
                    </div>
                </div>
                <div class="carrinhoCompra open-cart-bt">                      
                            <img onclick="toggleCartVisibility()" src="../assets/img/carrinhoBranco.png" alt="Icone Carrinho">  
                            <span id="cartItemCountBadge" class="badge">0</span>
                    </div>
                <div class="login-button">
                    <?php if (isset($_SESSION['id'])): ?>
                        <button><a href="../pages/logout.php">Sair</a></button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
    </header>

    <div class="containerHome">
            <section>
                <?php include '../includes/carrossel.php'; ?>
            </section>

            <main>
                <?php if (empty($produtos)): ?>
                    <p>Nenhum produto disponível no momento.</p>
                <?php else: ?>
                    <div class="main-container">

                        <!-- Carrinho de compras -->
                    <aside id="cartAside" class="cart-aside" style="display: none;">
                        <div class="botaoFecharCarrinho">
                            <button class="close-cart-btn" onclick="toggleCartVisibility()">X</button>
                        </div>
                        <div class="cart-header ">     
                            <div class="iconeAsideCarrinho">
                                <img src="../assets/img/carrinhoBranco.png" alt="">
                            </div>
                            <div class="cart-item-count">
                                <span class="cart-item-count-number" id="cartItemCount">0</span> itens
                            </div>
                        </div>
                        <ul id="cartItemsList" class="cart-items-list">
                            <!-- Itens do carrinho aparecerão aqui -->
                            <!-- a lista está no aside.js/ linha 20-->
                        </ul>
                        <div class="cart-total">
                            <span>Total:</span>
                            <span id="cartTotalAmount">R$ 0,00</span>
                        </div>
                        <form id="checkoutForm" action="../view/cliente/finalizarPedido.php" method="POST">
                            <button type="submit" class="checkout-btn">Finalizar Compra</button>
                        </form>
                    </aside>
                    </div>
                <?php endif; ?>

                <!-- Modal de login -->
                <div id="loginModal" class="modal">
                    <div class="modal-content">
                        <span class="close-button" onclick="closeLoginModal()">×</span>
                        <div class="modal-header">
                            <img src="logo.png" alt="Logo" class="modal-logo">
                            <h2>Precisa Fazer Login</h2>
                        </div>
                        <div class="modal-body">
                            <p>Você precisa estar logado para finalizar a compra. Caso não tenha uma conta, faça seu cadastro abaixo!</p>
                            <div class="modal-buttons">
                                <button onclick="redirectToLogin()">Fazer Login</button>
                                <a href="../view/cliente/cadastroCliente.php" class="register-link">Não tem uma conta? Cadastre-se aqui!</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produtos -->
                <div class="produto-container">
                <?php foreach ($produtos as $produto): ?>
                    <div class="produto-card">
                        <img src="<?php echo '../assets/img/' . basename($produto->getImagem()); ?>" alt="<?php echo htmlspecialchars($produto->getNome()); ?>" class="produto-imagem">
                        <h2><?php echo htmlspecialchars($produto->getNome()); ?></h2>
                        <p class="descricao"><?php echo htmlspecialchars($produto->getDescricao()); ?></p>
                        <p class="preco">Preço: R$ <?php echo number_format($produto->getPreco(), 2, ',', '.'); ?></p>
                        <div>
                            <button 
                                class="add-carrinho-btn" 
                                data-id="<?php echo $produto->getId(); ?>" 
                                onclick="openModal(
                                    '<?php echo htmlspecialchars($produto->getNome()); ?>',
                                    '<?php echo htmlspecialchars($produto->getDescricao()); ?>',
                                    '<?php echo number_format($produto->getPreco(), 2, ',', '.'); ?>',
                                    '../assets/img/<?php echo basename($produto->getImagem()); ?>',
                                    '<?php echo $produto->getId(); ?>'
                                )">
                                +
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>

                </div>
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

                            <!-- Campo oculto para armazenar o ID do produto -->
                            <input type="hidden" id="modalId">

                            <div class="modal-buttons">
                                <button class="btn-adicionar" onclick="addToCartFromModal()">Adicionar ao carrinho</button>
                                <button class="btn-cancelar" onclick="closeModal()">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


<footer>
<div class="containerFooter">
            <ul>
                <h2>Serv+Cuscuz</h2>
                <p>"Mais sabor, mais praticidade!"</p>
                <div class="redes-sociais-pai">
                    <div class="redes-sociais">
                        <a href="#"><img src="../assets/rede-social/facebook.png" alt="Facebook"></a>
                        <a href="#"><img src="../assets/rede-social/whatsapp.png" alt="Whatsapp"></a>
                        <a href="#"><img src="../assets/rede-social/instagram.png" alt="Instagram"></a>
                    </div>
                </div>
            </ul>
            <ul>
                <h2>Link</h2>
                <li><a href="#">Home</a></li>
                <li><a href="#">Cardápio</a></li>
                <li><a href="#">Sobre</a></li>
            </ul>
            <ul>
                <h2>Suporte</h2>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">Como funciona</a></li>
                <li><a href="#">Comunicando</a></li>
            </ul>
            <ul>
                <h2>Nossos contatos</h2>
                <li><a href="#">+55(61)99268-9834</a></li>
                <li><a href="#">servmaiscuscuz@gmail.com</a></li>
                <li><a href="#">Brasil</a></li>
            </ul>
        </div>
</footer>

    <!--JS do Aside-->
    <script src="../assets/js/home/aside.js"></script>

    <!--JS do Modal -->
    <script src="../assets/js/home/modal.js"></script>

    <!-- Atlternando desktop e mobile -->
    <script src="../assets/js/header.js"></script>


</body>
</html>