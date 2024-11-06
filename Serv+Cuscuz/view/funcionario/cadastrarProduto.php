<?php
// Iniciar a sessão, caso ainda não tenha sido iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir os arquivos necessários
require_once __DIR__ . "../../../controller/produto/readProdutoController.php";
require_once __DIR__ . "../../../model/DAO/funcionarioDAO.php";

// Carregar a lista de funcionários
$funcionarioDAO = new FuncionarioDAO();
$funcionarios = $funcionarioDAO->listarFuncionarios();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/headerCadastro.css">
    <link rel="stylesheet" href="../../assets/css/painelControleAdmin.css">
    <link rel="stylesheet" href="../../assets/css/produto/cadastrarProduto.css">
    <title>Produtos</title>
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
        <?php
            // Verifica se o usuário está logado e se é um funcionário
            if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 'FUNCIONARIO') {
            // Se não for funcionário, redireciona para a página home 
            header("Location: ../../pages/home.php");
            exit;
        }

        // Mensagem de boas-vindas
        echo "<h1>Bem-vindo, " . $_SESSION['nome'] . "!</h1>";
        ?>
    </section>
    <main>
    <h1>Cadastrar Produto</h1>

        <form action="../../controller/produto/createProdutoController.php" method="POST" enctype="multipart/form-data" class="form-produto">

            <label for="nome">Nome do Produto:</label>
            <input type="text" id="nome" name="nome" required class="input-field">

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required class="input-field"></textarea>

            <label for="imagem">Selecionar Nova Imagem:</label>
            <input type="file" id="imagem" name="imagem" accept="image/*" class="input-field" required onchange="previewImage(event)">

            <!-- Aqui a imagem será exibida após ser escolhida -->
            <div id="imagePreviewContainer">
                <img id="imagePreview" src="" alt="Pré-visualização da imagem" style="max-width: 300px; display: none;">
            </div>

            <label for="preco">Preço:</label>
            <input type="text" id="preco" name="preco" required class="input-field">

            <label for="tamanho">Tamanho:</label>
            <select id="tamanho" name="tamanho" class="input-field" required>
                <option value="P">P</option>
                <option value="M">M</option>
                <option value="G">G</option>
            </select>

            <label for="t_funcionario_id">Funcionário Responsável:</label>
            <select id="t_funcionario_id" name="t_funcionario_id" class="input-field" required>
                <option value="">Selecione um funcionário</option>
                <?php foreach ($funcionarios as $funcionario): ?>
                    <option value="<?php echo $funcionario['id']; ?>">
                        <?php echo htmlspecialchars($funcionario['nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="btn-submit">Cadastrar Produto</button>
        </form>

</main>

<script src="../../assets/js/produto/cadastroProduto.js"></script>
</body>
</html>