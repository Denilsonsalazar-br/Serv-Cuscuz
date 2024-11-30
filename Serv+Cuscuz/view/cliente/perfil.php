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


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/pedido/header.css">
    <link rel="stylesheet" href="../../assets/css/pedido/footer.css">
    <link rel="stylesheet" href="../../assets/css/cliente/perfil.css">


    <script type="text/javascript" src="https://cdn.emailjs.com/dist/email.min.js"></script>

    <title>Perfil</title>
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
                        <!--<a href="#">
                            <img src="../../assets/img/usuarioBranco.png" alt="Icone Usuario">
                        </a>-->
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
                    
                    <!--<div class="iconeUsuario">
                        <img src="../../assets/img/usuarioBranco.png" alt="Icone Usuario">
                    </div>-->
                
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
<body>

<main class="perfil-container">
    <!-- Div para o aside -->
    <div class="perfil-aside">
        <nav>
            <ul>
                <li>
                    <div class="imagemUsuario">
                        <div>
                            <img src="../../assets/img/usuarioBranco.png" alt="">
                        </div>
                        <div>
                            <a href="#" onclick="mostrarSecao('perfil')">Perfil</a>
                        </div>         
                    </div>         
                </li>
                <li>
                    <div class="imagemPedido">
                        <div>
                            <img src="../../assets/img/carrinhoBranco.png" alt="">
                        </div>
                        <div>
                            <a href="#" onclick="mostrarSecao('pedidos')">Pedidos</a>
                        </div> 
                    </div>   
                </li>
                <li>
                    <div class="imagemSuporte">
                        <div>
                            <img src="../../assets/img/suporteBranco.png" alt="">
                        </div>
                        <div>
                            <a href="#" onclick="mostrarSecao('suporte')">Suporte</a>
                        </div> 
                    </div>   
                </li>
                <!--<li>
                    <div class="imagemSuporte">
                        <div>
                            <img src="../../assets/img/mensagem.png" alt="">
                        </div>
                        <div>
                            <a href="#" onclick="mostrarSecao('mensagens')">Mensagem</a>
                        </div> 
                    </div>   
                </li>-->
            </ul>
        </nav>
    </div>

    <!-- Div para o conteúdo -->
<div class="perfil-conteudo">
        <!-- Seção Perfil -->
        <div id="perfil" class="secao">
            <h1>Perfil</h1>
            <p>Aqui estão suas informações de perfil.</p>
        </div>

        <!-- Seção Pedidos -->
        <div id="pedidos" class="secao" style="display: none;">
            <h1>Pedidos</h1>
            <p>Aqui estão seus pedidos recentes.</p>
        </div>

<!-- Seção Suporte -->
 <!--https://dashboard.emailjs.com/admin/templates-->
 <div id="suporte" class="secao" style="display: none;">
    <h1>Suporte Serv+Cuscuz</h1>
    <p>Preencha o formulário abaixo para entrar em contato conosco:</p>
    <form id="form-suporte" action="javascript:void(0);" method="POST">
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" placeholder="Seu nome completo" required>
        </div>
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" placeholder="Seu e-mail" required>
        </div>
        <div class="form-group">
            <label for="mensagem">Mensagem:</label>
            <textarea id="mensagem" name="mensagem" placeholder="Digite sua mensagem" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn-enviar">Enviar</button>
    </form>
</div>

<div id="suporte" class="secao" style="display: none;">
    <h1>Suporte Serv+Cuscuz</h1>
    <p>Preencha o formulário abaixo para entrar em contato conosco:</p>
    <form id="form-suporte" action="javascript:void(0);" method="POST">
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" placeholder="Seu nome completo" required>
        </div>
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" placeholder="Seu e-mail" required>
        </div>
        <div class="form-group">
            <label for="mensagem">Mensagem:</label>
            <textarea id="mensagem" name="mensagem" placeholder="Digite sua mensagem" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn-enviar">Enviar</button>
    </form>
</div>

<div id="suporte" class="secao" style="display: none;">
    <h1>Suporte Serv+Cuscuz</h1>
    <p>Preencha o formulário abaixo para entrar em contato conosco:</p>
    <form id="form-suporte" action="#" method="POST">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" placeholder="Seu nome completo" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" placeholder="Seu e-mail" required>
            </div>
            <div class="form-group">
                <label for="mensagem">Mensagem:</label>
                <textarea id="mensagem" name="mensagem" placeholder="Digite sua mensagem" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn-enviar">Enviar</button>
        </form>
</div>

    <!-- Seção Mensagens -->
    <!--<div id="mensagens" class="secao" style="display: none;">
 
    </div>-->


</div>
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
    function mostrarSecao(secaoId) {
        // Esconder todas as seções
        const secoes = document.querySelectorAll('.secao');
        secoes.forEach(secao => secao.style.display = 'none');

        // Mostrar a seção correspondente
        const secaoAtiva = document.getElementById(secaoId);
        if (secaoAtiva) {
            secaoAtiva.style.display = 'block';
        }
    }

    // Mostrar a seção "Perfil" por padrão ao carregar a página
    document.addEventListener('DOMContentLoaded', () => {
        mostrarSecao('perfil');
    });
</script>

</body>
</html>