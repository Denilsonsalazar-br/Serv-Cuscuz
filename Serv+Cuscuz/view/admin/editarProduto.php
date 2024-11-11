<?php
// Iniciar a sessão, caso ainda não tenha sido iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir os arquivos necessários
require_once __DIR__ . "../../../controller/produto/readProdutoController.php";
require_once __DIR__ . "../../../model/DAO/funcionarioDAO.php";
require_once __DIR__ . "../../../model/DAO/categoriaDAO.php"; 

// Verificar se o ID do produto foi passado pela URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idProduto = $_GET['id'];
    
    // Carregar produto
    $readProdutoController = new ReadProdutoController();
    $produto = $readProdutoController->getProdutoById($idProduto);

    // Verifica se o produto foi encontrado
    if (!$produto) {
        echo "<p>Produto não encontrado.</p>";
        exit;
    }

    // Carregar a lista de funcionários
    $funcionarioDAO = new FuncionarioDAO();
    $funcionarios = $funcionarioDAO->listarFuncionarios();

    // Carregar a lista de categorias
    $categoriaDAO = new CategoriaDAO(); 
    $categorias = $categoriaDAO->list(); 
    //var_dump($categorias);

} else {
    echo "<p>ID do produto não foi especificado.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/headerCadastro.css">
    <link rel="stylesheet" href="../../assets/css/painelControleAdmin.css">
    <link rel="stylesheet" href="../../assets/css/mensagens/mensagens.css">
    <link rel="stylesheet" href="../../assets/css/produto/editarProduto.css">
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
                    <?php 
                        include '../../pages/verificarLoginAdm.php';
                    ?>
                </button>
            </div>
        </nav>
    </header>

    <!--abre navegação-->
    <div class="painelAdm">
        <nav >
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
        <h1>Editar Produto</h1>

        <form action="../../controller/produto/editProdutoController.php" method="POST" enctype="multipart/form-data" class="form-produto">
            <input type="hidden" name="id" value="<?php echo $produto->getId(); ?>">

            <label for="t_categoria_id">Categoria:</label>
            <select id="t_categoria_id" name="t_categoria_id" class="input-field" required>
                <option value="">Selecione uma categoria</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?php echo $categoria['id']; ?>" 
                        <?php echo ($produto->getCategoriaId() == $categoria['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($categoria['nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>


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
                <select id="tamanho" name="tamanho" class="input-field" required>
                    <option value="P" <?php echo ($produto->getTamanho() == 'P') ? 'selected' : ''; ?>>P</option>
                    <option value="M" <?php echo ($produto->getTamanho() == 'M') ? 'selected' : ''; ?>>M</option>
                    <option value="G" <?php echo ($produto->getTamanho() == 'G') ? 'selected' : ''; ?>>G</option>
                </select>


                <label for="funcionario" class="label">Funcionário Responsável:</label>
                <select id="funcionario" name="t_funcionario_id" class="input-field" required>
                    <option value="">Selecione um funcionário</option> <!-- Opção padrão -->
                    <?php foreach ($funcionarios as $funcionario): ?>
                        <option value="<?php echo $funcionario['id']; ?>" 
                            <?php echo $produto->getFuncionarioId() == $funcionario['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($funcionario['nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>


            <button type="submit" class="btn-submit">Salvar Alterações</button>
        </form>
    </main>
</body>
</html>