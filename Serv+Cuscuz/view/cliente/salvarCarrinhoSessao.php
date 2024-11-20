<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



// Verifica se a requisição é POST e contém os dados do carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtém os dados enviados via JSON
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Verifica se os dados do carrinho são válidos
    if (isset($data['cart']) && is_array($data['cart'])) {
        // Salva os itens do carrinho na sessão
        $_SESSION['cart'] = $data['cart'];

        // Retorna uma resposta JSON indicando que o carrinho foi salvo com sucesso
        echo json_encode(['success' => true]);
    } else {
        // Se os dados do carrinho não forem válidos
        echo json_encode(['success' => false, 'message' => 'Dados inválidos do carrinho']);
    }
} else {
    // Se a requisição não for do tipo POST
    echo json_encode(['success' => false, 'message' => 'Método de requisição inválido']);
}