<?php
session_start();
require_once __DIR__ . "../../../controller/carrossel/carrosselHomeController.php";

$carrosselController = new CarrosselController();
$itens = $carrosselController->listarItens();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/headerCadastro.css">
    <link rel="stylesheet" href="../../assets/css/painelControleAdmin.css">
    <link rel="stylesheet" href="../../assets/css/carrossel/carrosselEdit.css"> 
    <link rel="stylesheet" href="../../assets/css/mensagens/mensagens.css">
    <title>Administração</title>
</head>
<body>
    <header>
        <nav class="nav-bar">    
            <div class="logo">
                <a href="../../pages/home.php">
                    <img src="../../assets/img/logo-png-reduzida.png" alt="Serv+Cuscuz">
                </a>
            </div>
            <div class="botao">
                <button>
                    <?php include '../../pages/verificarLoginAdm.php'; ?>
                </button>
            </div>
        </nav>
    </header>

    <div class="painelAdm">
        <nav class="navbar">
            <a href="../../view/admin/adminPainelController.php">Home</a>
            <a href="../../view/admin/categoria.php">Categoria</a>
            <a href="../../view/admin/produtos.php">Produtos</a>
            <a href="../../view/admin/pedidos.php">Pedidos</a>
            <a href="../../view/admin/listaFuncionarios.php">Funcionários</a>
            <a href="../../view/admin/listaCliente.php">Clientes</a>
            <a href="../../view/admin/carrosselHome.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'carrosselHome.php') ? 'ativo' : ''; ?>">Carrossel Home</a>
            <a href="../../view/admin/relatorios.php">Relatórios</a>
        </nav>
    </div>
<!-- Seção Principal -->
<main>
        <?php 
            if (isset($_SESSION['msg'])) {
                $msgTipo = $_SESSION['msg']['tipo'] === 'sucesso' ? 'msgsucesso' : 'msgerro';
                echo '<div class="msg ' . $msgTipo . '" id="mensagemFlash">
                        <h4>' . ucfirst($_SESSION['msg']['tipo']) . '</h4>
                        <p>' . $_SESSION['msg']['mensagem'] . '</p>
                    </div>';
                unset($_SESSION['msg']); // Limpa a mensagem após exibi-la
            }  
        ?>
        <h1>Carrossel de Imagens</h1>

        <!-- Abas -->
        <div class="tabs">
            <button class="tab-button" onclick="openTab(event, 'formCadastro')">Cadastro de Imagem</button>
            <button class="tab-button" onclick="openTab(event, 'imagensCadastradas')">Imagens Cadastradas</button>
        </div>

        <!-- Conteúdo das Abas -->
        <div id="formCadastro" class="tab-content">
            <h2>Adicionar Nova Imagem</h2>
            <form action="../../controller/carrossel/adicionarImagem.php" method="POST" enctype="multipart/form-data">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" >

                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" ></textarea>

                <label for="imagem">Imagem:</label>
                <input type="file" id="imagem" name="imagem" accept="image/*" required onchange="previewImage(event)">

                <div id="imagePreviewContainer" style="margin-top: 10px;">
                    <img id="imagePreview" src="" alt="Pré-visualização da imagem" style="max-width: 300px; display: none;">
                </div>

                <button type="submit">Adicionar</button>
            </form>
        </div>

        <script>
            // Função para exibir a pré-visualização da imagem
            function previewImage(event) {
                var reader = new FileReader();
                reader.onload = function() {
                    var imagePreview = document.getElementById('imagePreview');
                    imagePreview.src = reader.result;
                    imagePreview.style.display = 'block'; // Exibe a imagem
                };
                reader.readAsDataURL(event.target.files[0]);
            }
        </script>


        <div id="imagensCadastradas" class="tab-content">
            <h2>Imagens Cadastradas</h2>
            <div class="carrossel-edit-container">
                <?php if (empty($itens)): ?>
                    <p>Nenhum item encontrado para editar.</p>
                <?php else: ?>
                    <?php foreach ($itens as $index => $item): ?>
                        <div class="ImagemCarrossel">
                            <form action="../../controller/carrossel/atualizarCarrosselHome.php" method="POST" enctype="multipart/form-data" class="carrossel-edit-form">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($item->getId()); ?>">

                                <h3>Imagem <?php echo $index + 1; ?></h3>

                                <div class="imgAtualCarrossel">
                                    <img src="<?php echo htmlspecialchars('../../assets/img/' . basename($item->getImagemUrl())); ?>" alt="Imagem atual">
                                </div>

                                <label for="titulo-<?php echo $item->getId(); ?>">Nome do Produto:</label>
                                <input type="text" id="titulo-<?php echo $item->getId(); ?>" name="titulo" value="<?php echo htmlspecialchars($item->getTitulo()); ?>">

                                <label for="descricao-<?php echo $item->getId(); ?>">Descrição:</label>
                                <textarea id="descricao-<?php echo $item->getId(); ?>" name="descricao"><?php echo htmlspecialchars($item->getDescricao()); ?></textarea>

                                <label for="imagem-<?php echo $item->getId(); ?>">Imagem:</label>
                                <input type="file" id="imagem-<?php echo $item->getId(); ?>" name="imagem" accept="image/*">

                                <div class="btn-atualizar">
                                    <button type="submit">Atualizar</button>
                                </div>
                            </form>
                            <form action="../../controller/carrossel/deletarImagem.php" method="POST" class="carrossel-delete-form">
                                <input type="hidden" name="deletar_id" value="<?php echo htmlspecialchars($item->getId()); ?>">
                                <button type="submit" class="btn-excluir">Excluir</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Script para alternar entre as abas -->
    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tabbuttons;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tabbuttons = document.getElementsByClassName("tab-button");
            for (i = 0; i < tabbuttons.length; i++) {
                tabbuttons[i].className = tabbuttons[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Mostrar a aba de cadastro por padrão
        document.getElementsByClassName("tab-button")[0].click();
    </script>

    <script src="../../assets/js/mensagens/tempoMensagem.js"></script>
</body>
</html>