<?php
require_once __DIR__ . "../../../model/DTO/produtoDTO.php";
require_once __DIR__ . "../../../model/DAO/produtoDAO.php";

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
            $nomeImagem = basename($dadosProduto['imagem']['name']);
            $caminhoImagem = __DIR__ . "/../../assets/img/" . $nomeImagem;
            
            // Move a imagem para o diretório de destino
            if (move_uploaded_file($dadosProduto['imagem']['tmp_name'], $caminhoImagem)) {
                $produtoDTO->setImagem($nomeImagem); // Salve apenas o nome da imagem
            } else {
                die("Erro ao mover o arquivo da imagem.");
            }
        } else {
            // Caso não haja imagem nova, mantém a imagem existente
            $produtoDTO->setImagem($this->produtoDAO->getProdutoById($dadosProduto['id'])->getImagem());
        }
    
        $produtoDTO->setPreco($dadosProduto['preco']);
        
        // Validando o campo tamanho
        $tamanho = $dadosProduto['tamanho'];
        if (!in_array($tamanho, ['P', 'M', 'G'])) {
            die("Tamanho inválido. Insira apenas P, M ou G.");
        }
        $produtoDTO->setTamanho($tamanho);
        
        // Garantir que o funcionário foi selecionado
        $funcionarioId = isset($dadosProduto['t_funcionario_id']) ? $dadosProduto['t_funcionario_id'] : null;
        $produtoDTO->setFuncionarioId($funcionarioId);
    
        // Chama o DAO para atualizar o produto no banco
        return $this->produtoDAO->editarProduto($produtoDTO);
    }
}

// Processamento do formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Adicionando $_FILES para capturar os arquivos
    $dadosProduto = $_POST;  // Dados do formulário
    $dadosProduto['imagem'] = $_FILES['imagem'];  // Dados do arquivo de imagem
    
    $controller = new EditProdutoController();
    $controller->editarProduto($dadosProduto);

    // Redireciona de volta para a lista de produtos
    header("Location: ../../view/funcionario/produtos.php");
    exit;
}