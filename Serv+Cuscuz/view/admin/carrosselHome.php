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
        <nav>
            <a href="../../view/admin/adminPainelController.php">Home</a>
            <a href="../../view/admin/categoria.php">Categoria</a>
            <a href="../../view/admin/produtos.php">Produtos</a>
            <a href="#">Pedidos</a>
            <a href="../../view/admin/listaFuncionarios.php">Funcionários</a>
            <a href="../../view/admin/listaCliente.php">Clientes</a>
            <a href="../../view/admin/carrosselHome.php">Carrossel Home</a>
            <a href="#">Relatórios</a>
        </nav>
    </div>
    <main>
        <h1>Alterar imagens do carrossel</h1>

        <?php 
        if (isset($_SESSION['msg'])) {
            $msgTipo = $_SESSION['msg']['tipo'] === 'sucesso' ? 'msgsucesso' : 'msgerro';
            echo '<div class="msg ' . $msgTipo . '">
                    <h4>' . ucfirst($_SESSION['msg']['tipo']) . '</h4>
                    <p>' . $_SESSION['msg']['mensagem'] . '</p>
                  </div>';
            unset($_SESSION['msg']); // Limpa a mensagem após exibi-la
        }  
        ?>

        <?php if (empty($itens)): ?>
            <p>Nenhum item encontrado para editar.</p>
        <?php else: ?>
            <div class="carrossel-edit-container">
                <?php foreach ($itens as $index => $item): ?>
                    <form action="../../controller/carrossel/atualizarCarrosselHome.php" method="POST" enctype="multipart/form-data" class="carrossel-edit-form">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($item->getId()); ?>">

                        <h3>Imagem <?php echo $index + 1; ?></h3>

                        <div class="imgAtualCarrossel">
                            <!--imagem atual-->
                            <img src="<?php echo htmlspecialchars('../../assets/img/' . basename($item->getImagemUrl())); ?>" alt="Imagem atual">
                        </div>

                        <label for="titulo-<?php echo $item->getId(); ?>">Nome do Produto:</label>
                        <input type="text" id="titulo-<?php echo $item->getId(); ?>" name="titulo" value="<?php echo htmlspecialchars($item->getTitulo()); ?>" required>

                        <label for="descricao-<?php echo $item->getId(); ?>">Descrição:</label>
                        <textarea id="descricao-<?php echo $item->getId(); ?>" name="descricao" required><?php echo htmlspecialchars($item->getDescricao()); ?></textarea>

                        <label for="imagem-<?php echo $item->getId(); ?>">Imagem:</label>
                        <input type="file" id="imagem-<?php echo $item->getId(); ?>" name="imagem" accept="image/*">
                        

                        <div class="btn-atualizar">
                            <button type="submit" >Atualizar</button>
                        </div>
                    </form>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>