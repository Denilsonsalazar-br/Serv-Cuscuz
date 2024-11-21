<?php
session_start();

//var_dump($_SESSION['cart']);


// Verifica se a sessão está funcionando

/*if (!session_id()) {
    die("Sessão não iniciada. Verifique o 'session_start()'.");
}

// Loga detalhes da sessão
echo "Sessão ativa: " . session_id() . PHP_EOL;
echo "Conteúdo da sessão:" . PHP_EOL;
var_dump($_SESSION);

// Verifica se o carrinho está inicializado
if (!isset($_SESSION['cart'])) {
    echo "Carrinho não inicializado.";
} else {
    echo "Conteúdo do carrinho:";
    var_dump($_SESSION['cart']);
}

exit;*/



// Verifica se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_SESSION['cart']);
    $data = json_decode(file_get_contents('php://input'), true);

    // Verifica se o ID do produto foi enviado
    if (isset($data['id']) && isset($data['quantity'])) {
        $produto = [
            'id' => $data['id'],
            'name' => $data['name'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'total' => $data['total'],
        ];

        // Inicializa o carrinho na sessão, se não existir
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Verifica se o produto já está no carrinho
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] === $produto['id']) {
                // Produto encontrado, atualiza a quantidade e o total
                $item['quantity'] += $produto['quantity'];
                $item['total'] = $item['price'] * $item['quantity'];
                $found = true;
                break;
            }
        }

        // Se o produto não foi encontrado, adiciona-o ao carrinho
        if (!$found) {
            $_SESSION['cart'][] = $produto;
        }

        // Calcula o total do carrinho e o número total de itens
        $totalAmount = array_sum(array_map(function($item) {
            return $item['total'];
        }, $_SESSION['cart']));
        $totalItems = array_sum(array_map(function($item) {
            return $item['quantity'];
        }, $_SESSION['cart']));

        // Retorna uma resposta de sucesso
        echo json_encode([
            'success' => true,
            'message' => 'Carrinho atualizado com sucesso',
            'totalItems' => $totalItems,
            'totalAmount' => $totalAmount
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Dados do produto inválidos']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método de requisição inválido']);
}