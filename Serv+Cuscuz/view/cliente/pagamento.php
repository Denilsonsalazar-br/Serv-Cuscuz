<?php
session_start();

require_once __DIR__ . "../../../model/DAO/enderecoDAO.php";

// Verifica se o cliente está logado
if (!isset($_SESSION['id']) || !is_numeric($_SESSION['id'])) {
    header('Location: ../../pages/login.php');
    exit();
}

// Gerar um token CSRF se ainda não existir
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
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

// Verifica se o carrinho existe na sessão
if (isset($_SESSION['cart'])) {
    $carrinho = $_SESSION['cart'];
    $totalCarrinho = 0;

    // Calcula o total do carrinho
    foreach ($carrinho as $produto) {
        $totalCarrinho += $produto['total'];
    }
} else {
    $carrinho = [];
    $totalCarrinho = 0;
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
                <li class="nav-item"><a href="#" class="nav-link">Cardápio</a></li>
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

    <div class="form-buttons">
        <a href="../../view/cliente/finalizarPedido.php" class="back-button">← Voltar</a>
    </div>

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

                <span>
                <?php if (isset($_SESSION['msg'])): ?>
                    <div class="<?php echo $_SESSION['msg']['tipo'] === 'sucesso' ? 'msgsucesso' : 'msgerro'; ?>" id="msg">
                        <?php echo $_SESSION['msg']['mensagem']; ?>
                    </div>
                    <?php unset($_SESSION['msg']);  ?>
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
            <div class="info-botao-endereco">
                <button id="editarEnderecoBtn" class="back-button">Editar Endereço</button>
            </div>
        </div>      
    </section>

     <!-- Modal de Edição de Endereço -->
     <div id="modalEditarEndereco" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Editar Endereço</h2>
            <form id="formEditarEndereco" action="../../controller/endereco/editEnderecoController.php" method="POST">

            <input type="hidden" name="endereco_id" value="<?php echo htmlspecialchars($endereco['id'], ENT_QUOTES, 'UTF-8'); ?>">

                <div class="form-group">
                    <label for="rua">Rua:</label>
                    <input type="text" id="rua" name="rua" placeholder="Digite o nome da rua" value="<?php echo htmlspecialchars($endereco['rua'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="form-group">
                    <label for="numero">Número:</label>
                    <input type="text" id="numero" name="numero" placeholder="Número" value="<?php echo htmlspecialchars($endereco['numero'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="form-group">
                    <label for="bairro">Bairro:</label>
                    <input type="text" id="bairro" name="bairro" placeholder="Digite o bairro" value="<?php echo htmlspecialchars($endereco['bairro'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="form-group">
                    <label for="cidade">Cidade:</label>
                    <input type="text" id="cidade" name="cidade" placeholder="Digite a cidade" value="<?php echo htmlspecialchars($endereco['cidade'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="form-group">
                    <label for="estado">Estado:</label>
                    <input type="text" id="estado" name="estado" placeholder="Ex.: SP, RJ, MG" value="<?php echo htmlspecialchars($endereco['estado'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="form-group">
                    <label for="cep">CEP:</label>
                    <input type="text" id="cep" name="cep" placeholder="Digite o CEP" value="<?php echo htmlspecialchars($endereco['cep'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="form-group">
                    <label for="complemento">Complemento:</label>
                    <input type="text" id="complemento" name="complemento" placeholder="Ex.: Apto, Bloco, Casa" value="<?php echo htmlspecialchars($endereco['complemento'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <!-- Campo Hidden para o ID do Cliente -->
                <input type="hidden" name="cliente_id" value="<?php echo $_SESSION['id']; ?>">
                <div class="form-buttons-formulario">
                    <button type="submit" class="submit-btn-formulario">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
            <!--script do modal de editar endereço-->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById("modalEditarEndereco");
        const openModalButton = document.getElementById("editarEnderecoBtn");
        const closeModalButton = document.querySelector(".close-modal");

        // Abrir modal
        openModalButton.addEventListener("click", () => {
            modal.classList.add("show");
        });

        // Fechar modal ao clicar no botão "x"
        closeModalButton.addEventListener("click", () => {
            modal.classList.remove("show");
        });

        // Fechar modal ao clicar fora do conteúdo
        modal.addEventListener("click", (e) => {
            if (e.target === modal) {
                modal.classList.remove("show");
            }
        });
    });

    </script>

    <!-- Seção do Pedido -->
    <section class="containerProdutos">
    <h2>Meu Pedido</h2>
    <div class="info">
        <?php if (!empty($carrinho)): ?>
            <?php foreach ($carrinho as $produto): ?>
                <div class="produto">
                    <span class="produto-nome"><?php echo htmlspecialchars($produto['name']); ?></span>
                    <span class="produto-quantidade">Quantidade: <?php echo htmlspecialchars($produto['quantity']); ?></span>
                    <span class="produto-valor">Valor: R$ <?php echo number_format($produto['total'], 2, ',', '.'); ?></span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="carrinho-vazio">Carrinho vazio</div>
        <?php endif; ?>
    </div>

    <div class="total-carrinho">
        <span class="total-titulo">Total: </span>
        <span class="total-valor">
        <?php echo 'R$ ' . number_format($totalCarrinho, 2, ',', '.'); ?>
    </span>
    </div>
</section>


    <!-- Seção de Formas de Pagamento -->
    <section class="formas-pagamento">
        <h2>Forma de Pagamento</h2>
        <div class="tabs">
            <!--<button class="tab-button active" data-target="cartao">Cartão de Crédito</button>-->
            <button class="tab-button" data-target="pix">PIX</button>
        </div>

        <!--<div id="cartao" class="tab-content active">
            <p>Preencha os dados do seu cartão de crédito.</p>
            //Formulário de Cartão de Crédito
            <input type="text" placeholder="Número do Cartão" required><br>
            <input type="text" placeholder="Nome no Cartão" required><br>
            <input type="text" placeholder="Data de Validade" required><br>
            <input type="text" placeholder="CVV" required><br>
        </div>-->

        <div id="pix" class="tab-content">
            <p>Escolha a opção de PIX para realizar o pagamento.</p>
            <div class="form-buttons">
                <button type="submit" class="submit-btn">Gerar  QR Code</button>
            </div>
        </div>
        


        <!-- Token CSRF -->
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <form action="../../private/processarPagamento.php" method="POST">
            <div class="form-buttons">
                <button type="submit" class="submit-btn">Confirmar Pagamento</button>
            </div>
        </form>
    </section>
    </main>
<footer>
<div class="containerFooter">
            <ul>
                <h2>Serv+Cuscuz</h2>
                <p>"Mais sabor, mais praticidade!"</p>
                <div class="redes-sociais-pai">
                    <div class="redes-sociais">
                        <a href="#"><img src="../../assets/rede-social/facebook.png" alt="Facebook"></a>
                        <a href="#"><img src="../../assets/rede-social/whatsapp.png" alt="Whatsapp"></a>
                        <a href="#"><img src="../../assets/rede-social/instagram.png" alt="Instagram"></a>
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