<?php
// Iniciar a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} 

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'FUNCIONARIO') {
    header("Location: ../../pages/login.php");
    exit();
}

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
    <link rel="stylesheet" href="../../assets/css/pedido/footer.css">
    <link rel="stylesheet" href="../../assets/css/funcionario/funcionario.css">
    <title>Produtos</title>
</head>
<body>
    <header>
        <nav class="nav-bar">    
            <div class="logo">
                <a href="#">
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
        <nav class="navbar">
            <a href="../../view/funcionario/paginaHomeFuncionario.php">Home</a>
            <a href="../../view/funcionario/produtos.php">Produtos</a>
            <a href="../../view/funcionario/pedidos.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'pedidos.php') ? 'ativo' : ''; ?>">Pedidos</a>
            <a href="../../view/funcionario/estoque.php" >Estoque</a>
            <a href="../../view/funcionario/relatorio.php"></a>
        </nav>
    </div>
<main class="perfil-container">
    <!-- Div para o aside -->
    <div class="perfil-aside">
        <nav>
            <ul>
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
                            <img src="../../assets/img/mensagem.png" alt="">
                        </div>
                        <div>
                            <a href="#" onclick="mostrarSecao('suporte')">Suporte</a>
                        </div> 
                    </div>   
                </li>
            </ul>
        </nav>
    </div>

    <!-- Div para o conteúdo -->
    <div class="perfil-conteudo">
        <!-- Seção Pedidos -->
        <div id="pedidos" class="secao" style="display: none;">
            <h1>Pedidos</h1>
            <p>Aqui estão seus pedidos recentes.</p>
        </div>

        <!-- Seção Suporte -->
        <div id="suporte" class="secao" style="display: none;">
            <h1>Suporte</h1>
            <p>Entre em contato com nosso suporte para obter ajuda.</p>
        </div>
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

    // Mostrar a seção "Perfil" por padrão
    document.addEventListener('DOMContentLoaded', () => {
        mostrarSecao('pedidos');
    });
</script>  

</body>
</html>