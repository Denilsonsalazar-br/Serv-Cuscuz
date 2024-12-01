<?php
session_set_cookie_params([
    'path' => '/',
    'httponly' => true,
    'secure' => false,
    'samesite' => 'Lax',
]);

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


//error_log('Sessão atual: ' . print_r($_SESSION, true));


// Verifica se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decodifica os dados JSON enviados pelo cliente
    $inputData = json_decode(file_get_contents('php://input'), true);

    if (isset($inputData['cartItems']) && isset($inputData['cartTotalAmount'])) {
        // Processa os dados recebidos
        $_SESSION['cart'] = $inputData['cartItems'];
        $_SESSION['cartTotalAmount'] = $inputData['cartTotalAmount'];

        // Depuração no servidor
        error_log("Total do Carrinho: R$ " . $_SESSION['cartTotalAmount']);

        echo json_encode(["success" => true, "message" => "Pedido processado com sucesso!"]);
        exit;
    } else {
        echo json_encode(["success" => false, "message" => "Dados do carrinho inválidos!"]);
        exit;
    }
}

// Verifica se há itens no carrinho da sessão
$carrinho = $_SESSION['cart'] ?? [];
$cartTotalAmount = $_SESSION['cartTotalAmount'] ?? 0;

if (empty($carrinho)) {
    echo "<p>O carrinho está vazio!</p>";
    exit;
}

$exibirModal = false;

// Verifica se o cliente está logado
if (!isset($_SESSION['id']) || !is_numeric($_SESSION['id'])) {
    $exibirModal = true; // Define que o modal deve ser exibido
}

// Verifica se o carrinho existe na sessão, caso contrário, inicializa-o
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Inicializa as variáveis para o total do carrinho e a contagem de itens
$cartTotal = 0;
$cartItemCount = 0;

// Calcula os totais do carrinho
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartTotal += $item['total'];
        $cartItemCount += $item['quantity'];
    }
}

//var_dump($_SESSION['cart']);
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/pedido/header.css">
    <link rel="stylesheet" href="../../assets/css/pedido/footer.css">
    <link rel="stylesheet" href="../../assets/css/pedido/finalizarPedido.css">


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
                        <a href="http://localhost/Serv-Cuscuz/Serv+Cuscuz/view/cliente/perfil.php">
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
                        <a href="http://localhost/Serv-Cuscuz/Serv+Cuscuz/view/cliente/perfil.php">
                            <img src="../../assets/img/usuarioBranco.png" alt="Icone Usuario">
                        </a>
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

    <div class="butonVoltarHome">
        <button type="button" onclick="window.location.href='../../pages/home.php'" class="back-button"> ← Voltar</button>
    </div>
    <main>
    <!-- Modal de login -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <div class="modal-content-img">
                <img src="../../assets/img/logo-png-reduzida.png" alt="Serv+Cuscuz">
            </div>
            <a href="../../pages/home.php" id="closeModal" class="btn-close">X</a>
            <br>
            <p>Você precisa estar logado ou se cadastrar para adicionar produtos ao carrinho, e continuar a compra.</p>
            <div class="modal-buttons">
                <a href="../../pages/login.php" class="btn-login">Login</a>
                <a href="../../view/cliente/cadastroCliente.php" class="btn">Cadastrar-se</a>
            </div>
        </div>
    </div>

    <script>
        const exibirModal = <?php echo json_encode($exibirModal); ?>;

        if (exibirModal) {
            document.getElementById('loginModal').style.display = 'block';
        }

        document.getElementById('closeModal').onclick = function() {
            document.getElementById('loginModal').style.display = 'none';
        };
    </script>

    <!-- Carrinho de Compras-->
    <div class="containerProdutos">
        <div class="containerProdutosHeader">
            <img src="../../assets/img/carrinhoBranco.png" alt="">
            <h2>Meu Carrinho</h2>
        </div>
        <table class="carrinho-table">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($_SESSION['cart'])): ?>
                    <?php foreach ($_SESSION['cart'] as $produto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($produto['name']); ?></td>
                            <td>R$ <?php echo number_format($produto['price'], 2, ',', '.'); ?></td>
                            <td><?php echo $produto['quantity']; ?></td>
                            <td>R$ <?php echo number_format($produto['total'], 2, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Carrinho vazio</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="total-carrinho">
            <span>Total: </span>
            <span>
                R$ <?php 
                    $totalCarrinho = 0;
                    foreach ($_SESSION['cart'] as $produto) {
                        $totalCarrinho += $produto['total'];
                    }
                    echo number_format($totalCarrinho, 2, ',', '.');
                ?>
            </span>
        </div>
    </div> 

    <!-- Formulário de Endereço -->
    <section class="formulario-endereco">
    <h2>Informe o Endereço de Entrega</h2>
    <form action="../../controller/endereco/createEnderecoController.php" method="POST" onsubmit="return validarFormulario()">
        <div class="form-row">
            <div class="form-group">
                <label for="rua">Rua:</label>
                <input type="text" id="rua" name="rua" placeholder="Digite o nome da rua" required>
            </div>
            <div class="form-group">
                <label for="numero">Número:</label>
                <input type="text" id="numero" name="numero" placeholder="Número" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="bairro">Bairro:</label>
                <input type="text" id="bairro" name="bairro" placeholder="Digite o bairro" required>
            </div>
            <div class="form-group">
                <label for="cidade">Cidade:</label>
                <input type="text" id="cidade" name="cidade" placeholder="Digite a cidade" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="estado">Estado:</label>
                <input type="text" id="estado" name="estado" placeholder="Ex.: SP, RJ, MG" required>
            </div>
            <div class="form-group">
                <label for="cep">CEP:</label>
                <input type="text" id="cep" name="cep" placeholder="Digite o CEP" required>
            </div>
        </div>
        <div class="form-group">
            <label for="complemento">Complemento:</label>
            <input type="text" id="complemento" name="complemento" placeholder="Ex.: Apto, Bloco, Casa" required>
        </div>
        <!-- Campo Hidden para o ID do Cliente -->
        <!-- <input type="hidden" name="cliente_id" value="<?php //echo $_SESSION['id']; ?>"> -->
        <div class="form-buttons">
            <button type="submit" class="submit-btn">Avançar para o Pagamento</button>
        </div>
    </form>
</section>

    <!--script para mascara e valicação do endereco-->
    <script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.7/dist/inputmask.min.js"></script>

    <script>
        // Máscaras de entrada
    Inputmask({"mask": "99999-999"}).mask("#cep");  // Máscara para o CEP
    Inputmask({"mask": "a{1,10}9{0,3}"}).mask("#numero");  // Máscara para o número
    Inputmask({"mask": "a{1,50}"}).mask("#rua, #bairro, #cidade, #complemento");  // Máscaras para os outros campos de texto
    
    // Lista de estados brasileiros
    const estadosBrasileiros = [
        "AC", "AL", "AP", "AM", "BA", "CE", "DF", "ES", "GO", "MA", "MT", "MS", "MG", "PA", 
        "PB", "PR", "PE", "PI", "RJ", "RN", "RS", "RO", "RR", "SC", "SP", "SE", "TO"
    ];

    // Validação do Formulário
    function validarFormulario() {
        // Validação de CEP (precisa ser um formato válido)
        const cep = document.getElementById('cep').value;
        const regexCep = /^[0-9]{5}-[0-9]{3}$/; // Regex para validar o formato 99999-999
        if (!regexCep.test(cep)) {
            alert("Por favor, insira um CEP válido no formato 99999-999.");
            return false;
        }

        // Validação de Estado (precisa ser um estado brasileiro válido)
        const estado = document.getElementById('estado').value.toUpperCase(); // Transforma para maiúsculas
        if (!estadosBrasileiros.includes(estado)) {
            alert("Por favor, insira um estado válido (ex.: SP, RJ, MG).");
            return false;
        }

        // Validação de Número (pode ter números e letras)
        const numero = document.getElementById('numero').value;
        const regexNumero = /^[0-9a-zA-Z]{1,10}$/; // Regex para permitir números e letras
        if (!regexNumero.test(numero)) {
            alert("Por favor, insira um número válido (pode incluir letras e números).");
            return false;
        }

        // Validação de outros campos (se necessário)
        const rua = document.getElementById('rua').value;
        const regexRua = /^[0-9a-zA-Z]{1,10}$/; 
        if (!regexRua.test(rua)) {
            alert("O campo 'Rua' é obrigatório.");
        return false;
        }
        

        return true;
    }
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

    <!-- Atlternando desktop e mobile -->
    <script>
        function menuShow() {
            let menuMobile = document.querySelector('.mobile-menu');
            if (menuMobile.classList.contains('open')) {
                menuMobile.classList.remove('open');
                document.querySelector('.icon').src = "../../assets/img/abrirMenu.png";
            } else {
                menuMobile.classList.add('open');
                document.querySelector('.icon').src = "../../assets/img/fecharMenu.png";
            }
        }
    </script>


        
</body>
</html>