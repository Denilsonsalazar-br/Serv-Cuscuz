<?php
// Iniciar a sessão, caso ainda não tenha sido iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'ADMINISTRADOR') {
    header("Location: ../../pages/login.php");
    exit();
}

// Incluir os arquivos necessários
require_once __DIR__ . "../../../controller/produto/readProdutoController.php";
require_once __DIR__ . "../../../model/DAO/funcionarioDAO.php";
require_once __DIR__ . "../../../model/DAO/categoriaDAO.php"; 

// Carregar a lista de funcionários
$funcionarioDAO = new FuncionarioDAO();
$funcionarios = $funcionarioDAO->listarFuncionarios();

// Carregar a lista de categorias
$categoriaDAO = new CategoriaDAO();  
$categorias = $categoriaDAO->list();  

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/headerCadastro.css">
    <link rel="stylesheet" href="../../assets/css/painelControleAdmin.css">
    <link rel="stylesheet" href="../../assets/css/produto/cadastrarProduto.css">
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
                    <?php 
                        include '../../pages/verificarLoginAdm.php';
                    ?>
                </button>
            </div>
        </nav>
    </header>

    <!--abre navegação-->
    <div class="painelAdm">
        <nav class="navbar" >
            <a href="../../view/admin/adminPainelController.php">Home</a>
            <a href="../../view/admin/categoria.php">Categoria</a>
            <a href="../../view/admin/produtos.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'produtos.php') ? 'ativo' : ''; ?>">Produtos</a>
            <a href="../../view/admin/pedidos.php">Pedidos</a>
            <a href="../../view/admin/listaFuncionarios.php">Funcionários</a>
            <a href="../../view/admin/listaCliente.php">Clientes</a>
            <a href="../../view/admin/carrosselHome.php">Carrossel Home</a>
            <a href="../../view/admin/relatorios.php">Relatórios</a>
        </nav>
    </div>

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

    <h1>Cadastrar Produto</h1>

    <form action="../../controller/produto/createProdutoController.php" method="POST" enctype="multipart/form-data" class="form-produto">
    <label for="t_categoria_id">Categoria:</label>
    <select id="t_categoria_id" name="t_categoria_id" class="input-field" required>
        <option value="">Selecione uma categoria</option>
        <?php foreach ($categorias as $categoria): ?>
            <option value="<?php echo $categoria['id']; ?>">
                <?php echo htmlspecialchars($categoria['nome']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="nome">Nome do Produto:</label>
    <input type="text" id="nome" name="nome" required class="input-field">

    <label for="descricao">Descrição:</label>
    <textarea id="descricao" name="descricao" required class="input-field" spellcheck="true"></textarea>

    <label for="imagem">Selecionar Imagem:</label>
    <input placeholder="estensão aceita: .jpg, .jpeg, .png, webp" type="file" id="imagem" name="imagem" accept="image/*" class="input-field" required onchange="previewImage(event)">

    <div id="imagePreviewContainer">
        <img id="imagePreview" src="" alt="Pré-visualização da imagem" style="max-width: 300px; display: none;">
    </div>

    <label for="preco">Preço:</label>
    <input type="number" id="preco" name="preco" step="0.01" min="0" required class="input-field">

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
<script src="../../assets/js/mensagens/tempoMensagem.js"></script>
</body>
</html>