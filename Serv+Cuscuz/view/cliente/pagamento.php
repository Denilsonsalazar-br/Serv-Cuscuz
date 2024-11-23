<?php
session_start();

require_once __DIR__ . "../../../model/DAO/enderecoDAO.php";

// Verifica se o cliente está logado
if (!isset($_SESSION['id']) || !is_numeric($_SESSION['id'])) {
    header('Location: ../../pages/login.php');
    exit();
}

// Instancia o DAO para buscar o endereço do cliente
$clienteId = $_SESSION['id'];
$enderecoDAO = new EnderecoDAO();

try {
    // Busca o endereço do cliente
    $endereco = $enderecoDAO->readByClienteId($clienteId);
} catch (Exception $e) {
    $endereco = null; // Caso ocorra algum erro
}
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/pedido/header.css">
    <link rel="stylesheet" href="../../assets/css/pedido/footer.css">
    <link rel="stylesheet" href="../../assets/css/pedido/finalizarPedido.css">
    <link rel="stylesheet" href="../../assets/css/mensagens/mensagens.css">
    <link rel="stylesheet" href="../../assets/css/pedido/pagamento.css">
    <title>Finalizando Pedido</title>
</head>
<body>
    
    <header>
    <nav class="nav-bar">
            <div class="logo" href="../../pages/home.php">
                <a href="../../pages/home.php">
                    <img src="../../assets/img/logo-png-reduzida.png" alt="Serv+Cuscuz">
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
                            <img onclick="toggleCartVisibility()" src="../../assets/img/carrinhoBranco.png" alt="Icone Carrinho">  
                            <span id="cartItemCountBadge" class="badge" style="display: none;">0</span>
                    </div>
                    <div class="iconeUsuario">
                        <a href="#">
                            <img src="../../assets/img/usuarioBranco.png" alt="Icone Usuario">
                        </a>
                    </div>
                <div class="nomeperfil">
                    <div>
                        <?php include '../../pages/verificarLogin.php'; ?>
                    </div>
                </div>
                <div class="login-button">
                    <?php if (isset($_SESSION['id'])): ?>
                        <button><a href="../../pages/logout.php">Sair</a></button>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mobile-menu-icon">
                <button >
                    <img onclick="menuShow()" class="icon" src="../../assets/img/abrirMenu.png" alt="">
                </button>
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
                        <img src="../../assets/img/usuarioBranco.png" alt="Icone Usuario">
                    </div>
                
                    <div>
                        <?php include '../../pages/verificarLogin.php'; ?>
                    </div>
                </div>
                <div class="carrinhoCompra open-cart-bt">                      
                            <img onclick="toggleCartVisibility()" src="../../assets/img/carrinhoBranco.png" alt="Icone Carrinho">  
                            <span id="cartItemCountBadge" class="badge">0</span>
                    </div>
                <div class="login-button">
                    <?php if (isset($_SESSION['id'])): ?>
                        <button><a href="../../pages/logout.php">Sair</a></button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
    </header>

    <main>
    <!-- Seção de Endereço -->
    <section class="formulario-endereco">
        <div class="msg">
                <span>
                <!-- Mensagem de sucesso -->
                <?php if (isset($_SESSION['msg']) && $_SESSION['msg']['tipo'] == 'sucessoEndereco'): ?>
                    <div class="msgsucesso" id="msgSucesso">
                        <?php echo $_SESSION['msg']['mensagem']; ?>
                    </div>
                    <?php unset($_SESSION['msg']); // Limpa a mensagem após exibi-la ?>
                <?php endif; ?>

                <!-- Mensagem de erro -->
                <?php if (isset($_SESSION['msg']) && $_SESSION['msg']['tipo'] == 'erroEndereco'): ?>
                    <div class="msgerro" id="msgErro">
                        <?php echo $_SESSION['msg']['mensagem']; ?>
                    </div>
                    <?php unset($_SESSION['msg']); // Limpa a mensagem após exibi-la ?>
                <?php endif; ?>
                </span>
            </div>

        <h2>Endereço de Entrega</h2>
        <div class="info">
            <?php if ($endereco): ?>
                <p><span>Rua:</span> <?php echo htmlspecialchars($endereco['rua']); ?></p>
                <p><span>Número:</span> <?php echo htmlspecialchars($endereco['numero']); ?></p>
                <p><span>Bairro:</span> <?php echo htmlspecialchars($endereco['bairro']); ?></p>
                <p><span>Cidade:</span> <?php echo htmlspecialchars($endereco['cidade']); ?></p>
                <p><span>Estado:</span> <?php echo htmlspecialchars($endereco['estado']); ?></p>
                <p><span>CEP:</span> <?php echo htmlspecialchars($endereco['cep']); ?></p>
                <p><span>Complemento:</span> <?php echo htmlspecialchars($endereco['complemento']); ?></p>
            <?php else: ?>
                <p class="no-address">Endereço não encontrado.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Seção do Pedido -->
    <section class="containerProdutos">
        <h2>Meu Pedido</h2>
        <div class="info">
            <?php if (!empty($carrinho)): ?>
                <?php foreach ($carrinho as $produto): ?>
                    <div>
                        <span><?php echo htmlspecialchars($produto['name']); ?>:</span> R$ <?php echo number_format($produto['total'], 2, ',', '.'); ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div>Carrinho vazio</div>
            <?php endif; ?>
        </div>

        <div class="total-carrinho">
            <span>Total: </span>
            <span>R$ <?php echo number_format($totalCarrinho, 2, ',', '.'); ?></span>
        </div>
    </section>

    <!-- Seção de Formas de Pagamento -->
    <section class="formas-pagamento">
        <h2>Escolha a Forma de Pagamento</h2>
        <div class="tabs">
            <button class="tab-button active" data-target="cartao">Cartão de Crédito</button>
            <button class="tab-button" data-target="pix">PIX</button>
        </div>

        <div id="cartao" class="tab-content active">
            <p>Preencha os dados do seu cartão de crédito.</p>
            <!-- Formulário de Cartão de Crédito -->
            <input type="text" placeholder="Número do Cartão" required><br>
            <input type="text" placeholder="Nome no Cartão" required><br>
            <input type="text" placeholder="Data de Validade" required><br>
            <input type="text" placeholder="CVV" required><br>
        </div>

        <div id="pix" class="tab-content">
            <p>Escolha a opção de PIX para realizar o pagamento.</p>
        </div>

        <form action="processarPagamento.php" method="POST">
            <div class="form-buttons">
                <button type="submit" class="submit-btn">Confirmar Pagamento</button>
            </div>
        </form>
    </section>
</main>

<script>
    // Gerenciamento das abas de forma de pagamento
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', function () {
            // Remove a classe 'active' de todas as abas
            document.querySelectorAll('.tab-button').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

            // Adiciona a classe 'active' à aba clicada
            this.classList.add('active');
            document.getElementById(this.getAttribute('data-target')).classList.add('active');
        });
    });
</script>

<script src="../../assets/js/mensagens/tempoMensagem.js"></script>
</body>
</html>