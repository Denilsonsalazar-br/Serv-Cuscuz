<?php
session_start();

require_once __DIR__ . "../../../model/DAO/enderecoDAO.php";
require_once __DIR__ . "../../../model/DTO/enderecoDTO.php";

try {
    // Verifica se o ID do cliente está na sessão
    if (!isset($_SESSION['id']) || !is_numeric($_SESSION['id'])) {
        throw new Exception("ID do cliente não encontrado.");
    }

    // Sanitização e Validação dos dados recebidos
    $dados = [
        'estado' => isset($_POST['estado']) ? htmlspecialchars($_POST['estado'], ENT_QUOTES, 'UTF-8') : '',
        'cidade' => isset($_POST['cidade']) ? htmlspecialchars($_POST['cidade'], ENT_QUOTES, 'UTF-8') : '',
        'cep' => isset($_POST['cep']) ? preg_replace('/\D/', '', $_POST['cep']) : '', // Remove qualquer caractere não numérico
        'bairro' => isset($_POST['bairro']) ? htmlspecialchars($_POST['bairro'], ENT_QUOTES, 'UTF-8') : '',
        'rua' => isset($_POST['rua']) ? htmlspecialchars($_POST['rua'], ENT_QUOTES, 'UTF-8') : '',
        'numero' => isset($_POST['numero']) ? htmlspecialchars($_POST['numero'], ENT_QUOTES, 'UTF-8') : '',
        'complemento' => isset($_POST['complemento']) ? htmlspecialchars($_POST['complemento'], ENT_QUOTES, 'UTF-8') : ''
    ];

    // Validação do CEP (deve ser numérico e ter 8 dígitos)
    if (strlen($dados['cep']) != 8 || !is_numeric($dados['cep'])) {
        throw new Exception("CEP inválido. Deve conter 8 dígitos.");
    }

    // Instancia o DTO e popula os dados
    $endereco = new EnderecoDTO();
    $endereco->setEstado($dados['estado']);
    $endereco->setCidade($dados['cidade']);
    $endereco->setCep($dados['cep']);
    $endereco->setBairro($dados['bairro']);
    $endereco->setRua($dados['rua']);
    $endereco->setNumero($dados['numero']);
    $endereco->setComplemento($dados['complemento']);

    // Define o ID do cliente no DTO
    $endereco->setClienteId($_SESSION['id']); // Passa o ID do cliente da sessão

    // Cria um endereço usando o DAO
    $enderecoDAO = new EnderecoDAO();
    $resultado = $enderecoDAO->create($endereco);

    if ($resultado) {
        // Mensagem de sucesso
        $_SESSION['msg'] = [
            'tipo' => 'sucessoEndereco',
            'mensagem' => 'Endereço salvo com sucesso!'
        ];
    } else {
        throw new Exception('Erro ao salvar o endereço.');
    }

    // Redireciona para a página desejada
    header('Location: ../../view/cliente/pagamento.php');
    exit();
} catch (Exception $e) {
    // Mensagem de erro
    $_SESSION['msg'] = [
        'tipo' => 'erroEndereco',
        'mensagem' => $e->getMessage()
    ];

    // Redireciona para a página de cadastro
    header('Location: ../../view/cliente/finalizarPedido.php');
    exit();
}