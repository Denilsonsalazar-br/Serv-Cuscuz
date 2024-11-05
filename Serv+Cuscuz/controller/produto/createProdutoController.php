<?php 

require_once __DIR__ . "../../../model/DTO/produtoDTO.php";
require_once __DIR__ . "../../../model/DAO/produtoDAO.php";

class CreateProdutoController {
    private $produtoDAO;

    public function __construct() {
        $this->produtoDAO = new ProdutoDAO();
    }

    public function createProduto() {
        // Verifica se o formulário foi enviado
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $dadosProduto = $_POST;

            // Lógica para lidar com a imagem
            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
                $imagemPath = 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/' . basename($_FILES['imagem']['name']);
                move_uploaded_file($_FILES['imagem']['tmp_name'], $imagemPath);
                $dadosProduto['imagem'] = $imagemPath; // Atualiza o caminho da imagem no array
            } else {
                // Trate o erro de upload aqui, se necessário
                throw new Exception("Erro ao fazer upload da imagem.");
            }

            // Criando o objeto ProdutoDTO com os dados fornecidos
            $produtoDTO = new ProdutoDTO();
            $produtoDTO->setNome($dadosProduto['nome']);
            $produtoDTO->setDescricao($dadosProduto['descricao']);
            $produtoDTO->setImagem($dadosProduto['imagem']);
            $produtoDTO->setPreco($dadosProduto['preco']);
            $produtoDTO->setTamanho($dadosProduto['tamanho']);
            $produtoDTO->setFuncionarioId($dadosProduto['t_funcionario_id']);

            // Inserindo o produto no banco de dados
            $this->produtoDAO->cadastrarProduto($produtoDTO);

            // Redireciona para a página de listagem após o cadastro
            header('Location: ../../view/funcionario/produtos.php'); // Ajuste o caminho conforme necessário
            exit();
        }
    }
    
}
// Verifica se o arquivo foi acessado diretamente
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    $controller = new CreateProdutoController();
    $controller->createProduto();
}
