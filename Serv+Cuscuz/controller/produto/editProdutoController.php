<?php
require_once __DIR__ . "../../../model/DTO/ProdutoDTO.php";
require_once __DIR__ . "../../../model/DAO/ProdutoDAO.php";

class EditProdutoController {
    private $produtoDAO;

    public function __construct() {
        $this->produtoDAO = new ProdutoDAO();
    }

    public function editarProduto($dadosProduto) {
        $produtoDTO = new ProdutoDTO();
        $produtoDTO->setId($dadosProduto['id']);
        $produtoDTO->setNome($dadosProduto['nome']);
        $produtoDTO->setDescricao($dadosProduto['descricao']);
        
        // Verifica se uma nova imagem foi enviada
        if (!empty($dadosProduto['imagem']['name'])) {
            $novoCaminhoImagem = 'caminho/para/imagens/' . $dadosProduto['imagem']['name'];
            move_uploaded_file($dadosProduto['imagem']['tmp_name'], $novoCaminhoImagem);
            $produtoDTO->setImagem($novoCaminhoImagem);
        } else {
            $produtoDTO->setImagem($this->produtoDAO->getProdutoById($dadosProduto['id'])->getImagem());
        }

        $produtoDTO->setPreco($dadosProduto['preco']);
        
        // Validando o campo tamanho
        $tamanho = $dadosProduto['tamanho'];
        if (!in_array($tamanho, ['P', 'M', 'G'])) {
            die("Tamanho inválido. Insira apenas P, M ou G.");
        }
        $produtoDTO->setTamanho($tamanho);

        return $this->produtoDAO->editarProduto($produtoDTO);
    }
}

// Processamento do formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new EditProdutoController();
    $controller->editarProduto($_POST);

    // Redireciona de volta para a lista de produtos
    header("Location: ../../view/funcionario/produtos.php");
    exit;
}