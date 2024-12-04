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
            // Sanitização e validação
            $dadosProduto['nome'] = filter_var($dadosProduto['nome'], FILTER_SANITIZE_STRING);
            $dadosProduto['descricao'] = filter_var($dadosProduto['descricao'], FILTER_SANITIZE_STRING);
            $dadosProduto['preco'] = str_replace(',', '.', $dadosProduto['preco']);
    
            if (!is_numeric($dadosProduto['preco']) || $dadosProduto['preco'] <= 0) {
                throw new Exception("Preço inválido.");
            }
    
            $produtoDTO = new ProdutoDTO();
            $produtoDTO->setId($dadosProduto['id']);
            $produtoDTO->setNome($dadosProduto['nome']);
            $produtoDTO->setDescricao($dadosProduto['descricao']);
    
            // Lógica para lidar com a imagem
            if (!empty($arquivoImagem['name'])) {
                $extensaoPermitida = ['jpg', 'jpeg', 'png', 'gif'];
                $extensao = strtolower(pathinfo($arquivoImagem['name'], PATHINFO_EXTENSION));
    
                if (!in_array($extensao, $extensaoPermitida)) {
                    throw new Exception("Formato de imagem não permitido.");
                }
    
                // Verifique o tamanho da imagem se necessário
                if ($arquivoImagem['size'] > 5000000) { // 5MB
                    throw new Exception("Imagem muito grande. O tamanho máximo permitido é 5MB.");
                }
    
                $caminhoImagem = __DIR__ . "/../../assets/img/" . basename($arquivoImagem['name']);
                if (move_uploaded_file($arquivoImagem['tmp_name'], $caminhoImagem)) {
                    $produtoDTO->setImagem(basename($arquivoImagem['name']));
                } else {
                    throw new Exception("Erro ao mover o arquivo da imagem.");
                }
            } else {
                $imagemAtual = $this->produtoDAO->getProdutoById($dadosProduto['id'])->getImagem();
                $produtoDTO->setImagem($imagemAtual);
            }
    
            $produtoDTO->setPreco($dadosProduto['preco']);
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