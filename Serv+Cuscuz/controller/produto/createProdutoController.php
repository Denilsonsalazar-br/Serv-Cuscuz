<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "../../../model/DTO/produtoDTO.php";
require_once __DIR__ . "../../../model/DAO/produtoDAO.php";

class CreateProdutoController {
    private $produtoDAO;

    public function __construct() {
        $this->produtoDAO = new ProdutoDAO();
    }

    public function createProduto() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $dadosProduto = $_POST;

                // Lógica para lidar com a imagem
                if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
                    $imagemPath = 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/' . basename($_FILES['imagem']['name']);
                    move_uploaded_file($_FILES['imagem']['tmp_name'], $imagemPath);
                    $dadosProduto['imagem'] = $imagemPath;
                } else {
                    throw new Exception("Erro ao fazer upload da imagem.");
                }

                // Criação do produto
                $produtoDTO = new ProdutoDTO();
                $produtoDTO->setNome($dadosProduto['nome']);
                $produtoDTO->setDescricao($dadosProduto['descricao']);
                $produtoDTO->setImagem($dadosProduto['imagem']);
                $produtoDTO->setPreco($dadosProduto['preco']);
                $produtoDTO->setTamanho($dadosProduto['tamanho']);
                $produtoDTO->setFuncionarioId($dadosProduto['t_funcionario_id']);
                $produtoDTO->setCategoriaId($dadosProduto['t_categoria_id']);  // Setando categoria

                $this->produtoDAO->cadastrarProduto($produtoDTO);

                // Mensagem de sucesso
                $_SESSION['msg'] = [
                    'tipo' => 'sucesso',
                    'mensagem' => 'Produto cadastrado com sucesso!'
                ];
            } catch (Exception $e) {
                // Mensagem de erro
                $_SESSION['msg'] = [
                    'tipo' => 'erro',
                    'mensagem' => $e->getMessage()
                ];
            }

            // Verifica o perfil do usuário na sessão para redirecionar corretamente
            if (isset($_SESSION['perfil']) && $_SESSION['perfil'] == 'ADMINISTRADOR') {
                header('Location: ../../view/admin/cadastrarProduto.php');
            } else {
                header('Location: ../../view/funcionario/cadastrarProduto.php');
            }
            exit();
        }
    }
}


// Verifica se o arquivo foi acessado diretamente
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    $controller = new CreateProdutoController();
    $controller->createProduto();
}