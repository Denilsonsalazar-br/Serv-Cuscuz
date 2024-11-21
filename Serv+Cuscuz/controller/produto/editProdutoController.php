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

    public function editarProduto($dadosProduto, $arquivoImagem) {
        try {
            $produtoDTO = new ProdutoDTO();
            $produtoDTO->setId($dadosProduto['id']);
            $produtoDTO->setNome($dadosProduto['nome']);
            $produtoDTO->setDescricao($dadosProduto['descricao']);

            // Lógica para lidar com a imagem
            if (!empty($arquivoImagem['name'])) {
                $nomeImagem = basename($arquivoImagem['name']);
                $caminhoImagem = __DIR__ . "/../../assets/img/" . $nomeImagem;

                if (move_uploaded_file($arquivoImagem['tmp_name'], $caminhoImagem)) {
                    $produtoDTO->setImagem($nomeImagem);
                } else {
                    throw new Exception("Erro ao mover o arquivo da imagem.");
                }
            } else {
                // Mantém a imagem atual
                $imagemAtual = $this->produtoDAO->getProdutoById($dadosProduto['id'])->getImagem();
                $produtoDTO->setImagem($imagemAtual);
            }

            $produtoDTO->setPreco(floatval(str_replace(',', '.', $dadosProduto['preco'])));
            $produtoDTO->setTamanho($dadosProduto['tamanho']);
            $produtoDTO->setFuncionarioId($dadosProduto['t_funcionario_id']);
            $produtoDTO->setCategoriaId($dadosProduto['t_categoria_id']);

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
            // Redirecionamento
            $redirect = isset($_SESSION['perfil']) && $_SESSION['perfil'] == 'ADMINISTRADOR' 
            ? '../../view/admin/produtos.php' 
            : '../../view/funcionario/produtos.php';
            header("Location: $redirect");
            exit();

    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dadosProduto = $_POST;
    $arquivoImagem = $_FILES['imagem'];

    $controller = new EditProdutoController();
    $controller->editarProduto($dadosProduto, $arquivoImagem);
}
