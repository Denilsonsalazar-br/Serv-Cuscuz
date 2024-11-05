<?php
// Iniciar a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once __DIR__ . "../../../controller/produto/readProdutoController.php";
require_once __DIR__ . "../../../controller/produto/obterProdutoEdicao.php";

$readProdutoController = new ReadProdutoController();
$produtos = $readProdutoController->getAllProdutos(); // Obtém todos os produtos cadastrados
//print_r($produtos); 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/headerCadastro.css">
    <link rel="stylesheet" href="../../assets/css/painelControleAdmin.css">
    <link rel="stylesheet" href="../../assets/css/produto/cadastrarProduto.css">
    <title>Editar Produto</title>
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
            <a href="../../view/funcionario/paginaHomeFuncionario.php">Home</a>
            <a href="../../view/funcionario/produtos.php">Produtos</a>
            <a href="#">Pedidos</a>
            <a href="#">Estoque</a>
            <a href="#">Relatórios</a>
        </nav>
    </div> 

    <section class="BemVindoAdm">
        <h1>Bem-vindo, <?php echo $_SESSION['nome']; ?>!</h1>
    </section>

    <main>
        <h1>Editar Produto</h1>

            <form action="../../controller/produto/editProdutoController.php" method="POST" enctype="multipart/form-data" class="form-produto">
                <input type="hidden" name="id" value="<?php echo $produto->getId(); ?>">

                <label for="nome" class="label">Nome do Produto:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($produto->getNome()); ?>" required class="input-field">

                <label for="descricao" class="label">Descrição:</label>
                <textarea id="descricao" name="descricao" required class="input-field"><?php echo htmlspecialchars($produto->getDescricao()); ?></textarea>

                <label for="imagem" class="label">Atualizar Imagem:</label>
                <input type="file" id="imagem" name="imagem" accept="image/*" class="input-field">
                
                <div class="img-container">
                    <img src="<?php echo '../../assets/img/' . basename($produto->getImagem()); ?>" alt="Imagem Atual do Produto" class="img-atual">
                </div>

                <label for="preco" class="label">Preço:</label>
                <input type="text" id="preco" name="preco" value="<?php echo number_format($produto->getPreco(), 2, ',', '.'); ?>" required class="input-field">

                <label for="tamanho" class="label">Tamanho:</label>
                <input type="text" id="tamanho" name="tamanho" value="<?php echo htmlspecialchars($produto->getTamanho()); ?>" 
                    class="input-field" pattern="^[PMG]$" title="Por favor, insira apenas P, M ou G" required>


                <button type="submit" class="btn-submit">Salvar Alterações</button>
            </form>
        </main>
        
</body>
</html>