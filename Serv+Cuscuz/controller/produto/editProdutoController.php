<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "../../../model/DTO/produtoDTO.php";
require_once __DIR__ . "../../../model/DAO/produtoDAO.php";

class EditProdutoController {
    private $produtoDAO;

    public function __construct() {
        $this->produtoDAO = new ProdutoDAO();
    }

    public function editarProduto($dadosProduto) {
        try {
            $produtoDTO = new ProdutoDTO();
            $produtoDTO->setId($dadosProduto['id']);
            $produtoDTO->setNome($dadosProduto['nome']);
            $produtoDTO->setDescricao($dadosProduto['descricao']);

            // Lógica de imagem
            if (!empty($dadosProduto['imagem']['name'])) {
                $nomeImagem = basename($dadosProduto['imagem']['name']);
                $caminhoImagem = __DIR__ . "/../../assets/img/" . $nomeImagem;

                if (move_uploaded_file($dadosProduto['imagem']['tmp_name'], $caminhoImagem)) {
                    $produtoDTO->setImagem($nomeImagem);
                } else {
                    throw new Exception("Erro ao mover o arquivo da imagem.");
                }
            } else {
                $produtoDTO->setImagem($this->produtoDAO->getProdutoById($dadosProduto['id'])->getImagem());
            }

            // Configuração dos outros campos
            $produtoDTO->setPreco($dadosProduto['preco']);
            $produtoDTO->setTamanho($dadosProduto['tamanho']);
            $produtoDTO->setFuncionarioId($dadosProduto['t_funcionario_id']);

            $this->produtoDAO->editarProduto($produtoDTO);

            $_SESSION['msg'] = [
                'tipo' => 'sucesso',
                'mensagem' => 'Produto editado com sucesso!'
            ];
        } catch (Exception $e) {
            $_SESSION['msg'] = [
                'tipo' => 'erro',
                'mensagem' => $e->getMessage()
            ];
        }

        // Redirecionamento condicional com base no perfil
        if (isset($_SESSION['perfil'])) {
            if ($_SESSION['perfil'] === 'ADMINISTRADOR') {
                header("Location: ../../view/admin/produtos.php");
            } else {
                header("Location: ../../view/funcionario/produtos.php");
            }
        } else {
            // Se o perfil não estiver definido, redireciona para uma página de login ou erro
            header("Location: ../../view/login.php");
        }
        exit();
    }
}

// Processamento do formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Adicionando $_FILES para capturar os arquivos
    $dadosProduto = $_POST;  // Dados do formulário
    $dadosProduto['imagem'] = $_FILES['imagem'];  // Dados do arquivo de imagem
    
    $controller = new EditProdutoController();
    $controller->editarProduto($dadosProduto);
}