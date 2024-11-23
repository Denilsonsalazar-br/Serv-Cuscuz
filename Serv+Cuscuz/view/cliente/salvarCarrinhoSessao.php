<?php
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode(['success' => false, 'message' => 'A requisição está chegando como GET. Verifique o JavaScript.']);
    exit;
}

// Verifica o método HTTP
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método inválido: ' . $_SERVER['REQUEST_METHOD']]);
    exit;
}

// Recebe os dados da requisição
$data = json_decode(file_get_contents('php://input'), true);

// Valida o JSON recebido
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'message' => 'Erro ao decodificar JSON: ' . json_last_error_msg()]);
    exit;
}

if (!isset($data['cart']) || !is_array($data['cart'])) {
    echo json_encode(['success' => false, 'message' => 'Estrutura do JSON inválida ou campo "cart" ausente.']);
    exit;
}

// Salva o carrinho na sessão
$_SESSION['cart'] = $data['cart'];

// Calcula totais
$totalItems = array_sum(array_column($_SESSION['cart'], 'quantity'));
$totalAmount = array_sum(array_column($_SESSION['cart'], 'total'));

// Resposta de sucesso
echo json_encode([
    'success' => true,
    'totalItems' => $totalItems,
    'totalAmount' => $totalAmount
]);


// Se não for uma requisição POST, retorna erro
echo json_encode(['success' => false, 'message' => 'Método inválido.']);
exit;