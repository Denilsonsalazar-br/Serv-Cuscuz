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

                // Validação e sanitização
                $dadosProduto['nome'] = filter_var($dadosProduto['nome'], FILTER_SANITIZE_STRING);
                $dadosProduto['descricao'] = filter_var($dadosProduto['descricao'], FILTER_SANITIZE_STRING);
                $dadosProduto['preco'] = str_replace(',', '.', $dadosProduto['preco']); // Troca vírgula por ponto
                
                if (!is_numeric($dadosProduto['preco']) || $dadosProduto['preco'] <= 0) {
                    throw new Exception("Preço inválido.");
                }

                // Lógica para lidar com a imagem
                if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
                    $extensaoPermitida = ['jpg', 'jpeg', 'png', 'gif' ];
                    $extensao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
                    if (!in_array($extensao, $extensaoPermitida)) {
                        throw new Exception("Formato de imagem não permitido.");
                    }

                    $imagemPath = 'C:/xampp/htdocs/Serv-Cuscuz/Serv+Cuscuz/assets/img/' . basename($_FILES['imagem']['name']);
                    if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $imagemPath)) {
                        throw new Exception("Erro ao salvar a imagem.");
                    }
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
                $produtoDTO->setCategoriaId($dadosProduto['t_categoria_id']);

                if (!$this->produtoDAO->cadastrarProduto($produtoDTO)) {
                    throw new Exception("Erro ao cadastrar produto no banco.");
                }

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

            // Redirecionamento
            $redirect = isset($_SESSION['perfil']) && $_SESSION['perfil'] == 'ADMINISTRADOR' 
                ? '../../view/admin/cadastrarProduto.php' 
                : '../../view/funcionario/cadastrarProduto.php';
            header("Location: $redirect");
            exit();
        }
    }
}

// Verifica se o arquivo foi acessado diretamente
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    $controller = new CreateProdutoController();
    $controller->createProduto();
}