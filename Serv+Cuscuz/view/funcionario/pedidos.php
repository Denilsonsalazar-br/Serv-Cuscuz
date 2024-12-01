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


require_once __DIR__ . "../../../controller/pedido/readPedidoController.php";
require_once __DIR__ . "../../../controller/pedido/traduzirStatus.php";

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

    <!--emoji-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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
                
                <li>
                <div class="imagemSuporte">
                        <div>
                            <img src="../../assets/img/historico.png" alt="">
                        </div>
                        <div>
                            <a href="#" onclick="mostrarSecao('historicoPedidoFuncionario')">Histórico de Pedidos</a>
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

        <!-- Mensagens após a edição -->
        <?php
            if (isset($_SESSION['msg'])) {
                $msgTipo = $_SESSION['msg']['tipo'] === 'sucesso' ? 'msgsucesso' : 'msgerro';
                echo '<div class="msg ' . $msgTipo . '" id="mensagemFlash">
                        <h4>' . ucfirst($_SESSION['msg']['tipo']) . '</h4>
                        <p>' . $_SESSION['msg']['mensagem'] . '</p>
                    </div>';
                unset($_SESSION['msg']); 
            }
        ?>

        <!-- Seção Gerenciar Pedidos -->
        <h1>Gerenciar Pedidos</h1>
        <p>Abaixo estão os pedidos disponíveis. Você pode alterar o status de cada pedido.</p>

    <!-- Tabela de Pedidos não confirmados -->
    <p>Pedidos pendentes ou em andamento:</p>
        <table class="table-pedidos">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Status</th>
                    <!--<th>Entrega Domicílio</th>--> <!-- Coluna comentada -->
                    <th>Preço Total</th>
                    <th>Alterar Status</th> <!-- Nova coluna para alteração -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Verifica se a sessão de pedidos existe e não está vazia
                if (isset($_SESSION['pedidos']) && !empty($_SESSION['pedidos'])) {
                    $temPedidosPendentes = false;
                    foreach ($_SESSION['pedidos'] as $pedido) {
                        // Verifica se o pedido está em algum dos status desejados
                        if (in_array($pedido['status'], ['PENDENTE', 'PREPARANDO', 'A_CAMINHO'])) {
                            $temPedidosPendentes = true;
                            echo "<tr>";
                            echo "<td>" . date('d/m/Y H:i', strtotime($pedido['data'])) . "</td>";
                            echo "<td>" . ucfirst(strtolower($pedido['status'])) . "</td>";
                            // echo "<td>" . ($pedido['entrega_domicilio'] == 1 ? 'Sim' : 'Não') . "</td>"; <!-- Coluna comentada -->
                            echo "<td>R$ " . number_format($pedido['preco_total'], 2, ',', '.') . "</td>";
                            echo "<td>
                                    <!-- Formulário de alteração de status -->
                                    <form action='../../controller/funcionario/updateStatusPedidoController.php' method='POST'>
                                        <input type='hidden' name='pedido_id' value='" . $pedido['id'] . "'>
                                        <div class='input-group'>
                                            <div class='select-container'>
                                                <select name='novo_status'>
                                                    <option value='PENDENTE' " . ($pedido['status'] == 'PENDENTE' ? 'selected' : '') . ">Pendente</option>
                                                    <option value='PREPARANDO' " . ($pedido['status'] == 'PREPARANDO' ? 'selected' : '') . ">Em Preparação</option>
                                                    <option value='A_CAMINHO' " . ($pedido['status'] == 'A_CAMINHO' ? 'selected' : '') . ">A Caminho</option>
                                                    <option value='ENTREGUE' " . ($pedido['status'] == 'ENTREGUE' ? 'selected' : '') . ">Entregue</option>
                                                    <option value='CANCELADO' " . ($pedido['status'] == 'CANCELADO' ? 'selected' : '') . ">Cancelado</option>
                                                </select>
                                            </div>
                                            <button type='submit' class='btn-alterar-status'>
                                                Alterar Status
                                            </button>
                                        </div>
                                    </form>
                                </td>";
                            echo "</tr>";
                        }
                    }

                    // Se não houver pedidos pendentes ou em andamento
                    if (!$temPedidosPendentes) {
                        echo "<tr><td colspan='4'>Atualize a pagina para ver se tem pedidos pendentes.</td></tr>";
                    }
                } else {
                    // Se não houver nenhum pedido na sessão
                    echo "<tr><td colspan='4'>Nenhum pedido foi encontrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>


    </div>

    <!-- Histórico de Pedidos Confirmados -->
    <div id="historicoPedidoFuncionario" class="secao" style="display: none;">
        <h1>Entregas realizadas:</h1>
        <table class="table-pedidos">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Status</th>
                    <!--<th>Entrega Domicílio</th>--> <!-- Coluna comentada -->
                    <th>Preço Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Exibe os pedidos confirmados
                if (isset($_SESSION['pedidos']) && !empty($_SESSION['pedidos'])) {
                    foreach ($_SESSION['pedidos'] as $pedido) {
                        if (in_array($pedido['status'], ['ENTREGUE', 'CANCELADO'])) {
                            echo "<tr>";
                            echo "<td>" . date('d/m/Y H:i', strtotime($pedido['data'])) . "</td>";
                            echo "<td>" . ucfirst(strtolower($pedido['status'])) . "</td>";
                            // echo "<td>" . ($pedido['entrega_domicilio'] == 1 ? 'Sim' : 'Não') . "</td>"; <!-- Coluna comentada -->
                            echo "<td>R$ " . number_format($pedido['preco_total'], 2, ',', '.') . "</td>";
                            echo "</tr>";
                        }
                    }
                } else {
                    echo "<tr><td colspan='3'>Nenhum pedido confirmado.</td></tr>"; 
                }
                ?>
            </tbody>
        </table>
    </div>


            <!--<h1>Detalhes do Pedido</h1>
            <div class="detalhes-pedido">
                <?//php if (!empty($pedido)) : ?>
                    <p><strong>Data:</strong> <?//php echo date('d/m/Y H:i', strtotime($pedido['data'])); ?></p>
                    <p><strong>Status:</strong> <?//php echo ucfirst(strtolower($pedido['status'])); ?></p>
                    <p><strong>Entrega Domicílio:</strong> <?//php echo ($pedido['entrega_domicilio'] == 1 ? 'Sim' : 'Não'); ?></p>
                    <p><strong>Preço Total:</strong> R$ <?//php echo number_format($pedido['preco_total'], 2, ',', '.'); ?></p>
                <?//php else : ?>
                    <p>Nenhum detalhe disponível para o pedido.</p>
                <?//php endif; ?>
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

    // Mostrar a seção "Perfil" por padrão
    document.addEventListener('DOMContentLoaded', () => {
        mostrarSecao('pedidos');
    });
</script>

<!-- Script para esconder a mensagem flash depois de 5 segundos -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
    const mensagemFlash = document.getElementById('mensagemFlash');
    if (mensagemFlash) {
        setTimeout(() => {
            mensagemFlash.style.display = 'none';
        }, 5000); // Esconde após 5 segundos
    }
});
</script>

</body>
</html>