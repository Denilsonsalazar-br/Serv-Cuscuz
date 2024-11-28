<?php

// Iniciar a sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['id'])) {
    header("Location: ../../pages/login.php");
    exit();
}

// Exemplo de atribuição do valor total do pedido na sessão
$_SESSION['pedido']['valor_total']; 
$_SESSION['pedido']['chave_pix'] = 'Serv+Cuscuz@gmail.com'; 
$_SESSION['pedido']['nome_cliente']; 



?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/pagamento/header.css">
    <link rel="stylesheet" href="../../assets/css/pagamento/footer.css">
    <link rel="stylesheet" href="../../assets/css/pagamento/body.css">
    <link rel="stylesheet" href="../../assets/css/mensagens/mensagens.css">

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
    <main>
        <!--<pre>
            <?php //var_dump($_SESSION['pedido']); ?>
        </pre>-->
    <h1>Finalizando seu pedido!</h1>
    <div class="logo-pagamento">
        <img src="../../assets/img/logo-png-reduzida.png" alt="">
    </div>
    <span class="msg">
        <?php if (isset($_SESSION['msg']) && $_SESSION['msg']['tipo'] == 'sucessoPedido'): ?>
            <div class="msgsucesso" id="msgSucesso">
                <?php echo $_SESSION['msg']['mensagem']; ?>
            </div>
            <?php unset($_SESSION['msg']); ?>
        <?php endif; ?>
    </span>

    <section class="container-pedido">
        <!-- Divisão das colunas para detalhes e forma de pagamento -->
        <div>
            <div class="detalhes-pedido">
                <!--<h2 class="titulo-detalhes">Informações</h2>-->
                <div class="informacoes-pedido">
                    <p><strong>Nome do Cliente:</strong> <?php echo $_SESSION['pedido']['nome_cliente']; ?></p>
                    <p><strong>Valor Total:</strong> R$ <?php echo number_format($_SESSION['pedido']['valor_total'], 2, ',', '.'); ?></p>
                </div>
        </div>
    </section>
       
     <section class="formas-pagamento">
        <h2>Forma de Pagamento</h2>
        <div class="tabs">
            <button class="tab-button active" data-target="pix">PIX</button>
            <button class="tab-button " data-target="cartao">Cartão de Crédito</button>    
        </div>

        <div id="cartao" class="tab-content">
            <p>Preencha os dados do seu cartão de crédito.</p>
            <form id="form-cartao">
                <div class="input-group">
                    <label for="numero-cartao">Número do Cartão</label>
                    <input type="text" id="numero-cartao" placeholder="Número do Cartão" required>
                </div>
                <div class="input-group">
                    <label for="nome-cartao">Nome no Cartão</label>
                    <input type="text" id="nome-cartao" placeholder="Nome no Cartão" required>
                </div>
                <div class="input-group">
                    <label for="validade-cartao">Data de Validade</label>
                    <input type="text" id="validade-cartao" placeholder="MM/AAAA" required>
                </div>
                <div class="input-group">
                    <label for="cvv-cartao">CVV</label>
                    <input type="text" id="cvv-cartao" placeholder="CVV" required>
                </div>
                <button type="submit" class="submit-btn">Confirmar Pagamento</button>
            </form>
        </div>

        <div id="pix" class="tab-content">
            <form id="pagamentoForm">
                <div class="btn-pagar">
                    <button type="button"  onclick="gerarQRCode()">Gerar QR Code</button>
                </div>        
            </form>
            <!-- Div para exibir o QR Code -->
            <div id="qrCodeContainer" class="qr-code-container" style="display:none;">
            <h3>QRCode para pagamento via PIX</h3>
            <canvas id="qrcode"></canvas>
        </div>
    </section>
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
        function gerarQRCode() {
    console.log("Gerando QR Code...");

    var chave_pix = '<?php echo $_SESSION['pedido']['chave_pix']; ?>'; // Chave PIX
    var valor = '<?php echo number_format($_SESSION['pedido']['valor_total'], 2, '.', ''); ?>'; // Valor do pedido
    var nome_cliente = '<?php echo $_SESSION['pedido']['nome_cliente']; ?>'; // Nome do cliente

    // Nome da empresa fixo (Serv+Cuscuz)
    var nome_empresa = "Serv+Cuscuz";

    // Garantir que o nome do recebedor não exceda 25 caracteres
    var nome_recebedor = nome_empresa.substring(0, 25);

    // Formatação correta do payload
    var pixData =
        "000201" + // Identificação do formato
        "010211" + // Tipo de transação (11 = PIX)
        "26" + ("0014br.gov.bcb.pix" + "01" + chave_pix.length + chave_pix).length +
        "0014br.gov.bcb.pix" + "01" + chave_pix.length + chave_pix +
        "52040000" + // Código de categoria (bens e serviços)
        "5303986" + // Código da moeda (986 = Real brasileiro)
        "54" + valor.length.toString().padStart(2, '0') + valor + // Valor total
        "5802BR" + // Código do país
        "59" + nome_recebedor.length.toString().padStart(2, '0') + nome_recebedor + // Nome do recebedor (empresa fixa)
        "6009SAO PAULO" + // Cidade do recebedor
        "62070503***"; // Campo adicional opcional

    console.log("Dados do QR Code: ", pixData);

    // Exibe o QR Code na tela
    document.getElementById('qrCodeContainer').style.display = 'block';

    // Geração do QR Code usando Qrious
    var qr = new QRious({
        element: document.getElementById('qrcode'),
        value: pixData,
        size: 256, // Tamanho do QR Code
        level: 'H' // Nível de correção de erros
    });
}
</script>
<script src="https://cdn.jsdelivr.net/npm/qrious/dist/qrious.min.js"></script>

    <script src="../../assets/js/mensagens/tempoMensagem.js"></script>

</body>
</html>