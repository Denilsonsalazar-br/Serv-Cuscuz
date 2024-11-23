/*
session_start();

require_once __DIR__ . "../../../model/DAO/pedidoDAO.php";
require_once __DIR__ . "../../../model/DTO/pedidoDTO.php";

// Verifica se o usuário está autenticado
if (!isset($_SESSION['id']) || !is_numeric($_SESSION['id'])) {
    $_SESSION['msg'] = [
        'tipo' => 'erro',
        'mensagem' => 'Você precisa estar logado para realizar o pagamento.'
    ];
    header('Location: ../../view/cliente/finalizarPedido.php');
    exit();
}

// Verifica se foi escolhido uma forma de pagamento
if (!isset($_POST['pagamento']) || empty($_POST['pagamento'])) {
    $_SESSION['msg'] = [
        'tipo' => 'erro',
        'mensagem' => 'Por favor, escolha uma forma de pagamento.'
    ];
    header('Location: ../../view/cliente/pagamento.php');
    exit();
}

// Recupera o tipo de pagamento
$formaPagamento = $_POST['pagamento'];

// Recupera os dados do pedido (do carrinho)
$carrinho = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$totalCarrinho = 0;
foreach ($carrinho as $produto) {
    $totalCarrinho += $produto['total'];
}

// Verifica se o carrinho não está vazio
if (empty($carrinho)) {
    $_SESSION['msg'] = [
        'tipo' => 'erro',
        'mensagem' => 'O carrinho está vazio. Não é possível processar o pagamento.'
    ];
    header('Location: ../../view/cliente/finalizarPedido.php');
    exit();
}

// Criação do pedido no banco de dados
try {
    $pedidoDAO = new PedidoDAO();
    $pedidoDTO = new PedidoDTO();
    
    // Preenche os dados do pedido
    $pedidoDTO->setClienteId($_SESSION['id']);
    $pedidoDTO->setTotal($totalCarrinho);
    $pedidoDTO->setFormaPagamento($formaPagamento);
    $pedidoDTO->setProdutos($carrinho); // Pode ser necessário serializar o carrinho ou armazenar os dados dos produtos de outra forma
    
    // Registra o pedido no banco de dados
    $resultado = $pedidoDAO->create($pedidoDTO);
    
    if ($resultado) {
        // Limpar o carrinho após o pagamento
        unset($_SESSION['cart']);

        // Registra a mensagem de sucesso
        $_SESSION['msg'] = [
            'tipo' => 'sucesso',
            'mensagem' => 'Pagamento realizado com sucesso! Agradecemos sua compra.'
        ];

        // Redireciona para a página de confirmação
        header('Location: ../../view/cliente/confirmacao.php');
        exit();
    } else {
        throw new Exception('Erro ao processar o pagamento. Tente novamente mais tarde.');
    }
} catch (Exception $e) {
    // Mensagem de erro no processamento do pagamento
    $_SESSION['msg'] = [
        'tipo' => 'erro',
        'mensagem' => 'Erro ao processar o pagamento: ' . $e->getMessage()
    ];

    // Redireciona para a página de pagamento com mensagem de erro
    header('Location: ../../view/cliente/pagamento.php');
    exit();
}

