<?php

// Iniciar a sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function traduzirStatusCliente($status) {
    $mapaStatusCliente = [
        'PENDENTE' => '<span><i class="fas fa-clock"></i> Pedido feito, aguardando preparo</span>',
        'PREPARANDO' => '<span><i class="fas fa-utensils"></i> Estamos preparando seu pedido</span>',
        'A_CAMINHO' => '<span><i class="fas fa-motorcycle"></i> Entregador a caminho</span>',
        'ENTREGUE' => '<span><i class="fas fa-check-circle"></i> Pedido entregue</span>',
        'CANCELADO' => '<span><i class="fas fa-times-circle"></i> Pedido cancelado</span>',
    ];

    // Retorna o status traduzido ou um status desconhecido caso não haja correspondência
    return $mapaStatusCliente[$status] ?? '<span><i class="fas fa-question-circle"></i> Status desconhecido</span>';
}

function traduzirStatusFuncionario($status) {
    $mapaStatusFuncionario = [
        'PENDENTE' => '<span><i class="fas fa-clock"></i> Pedido recebido, aguardando preparo. <strong>Preparar pedido.</strong></span>',
        'PREPARANDO' => '<span><i class="fas fa-utensils"></i> Estamos preparando seu pedido. <strong>Acompanhar preparo.</strong></span>',
        'A_CAMINHO' => '<span><i class="fas fa-motorcycle"></i> Entregador a caminho. <strong>Aguardar entrega.</strong></span>',
        'ENTREGUE' => '<span><i class="fas fa-check-circle"></i> Pedido entregue. <strong>Finalizar processo.</strong></span>',
        'CANCELADO' => '<span><i class="fas fa-times-circle"></i> Pedido cancelado. <strong>Rever cancelamento.</strong></span>',
    ];

    // Retorna o status traduzido ou um status desconhecido caso não haja correspondência
    return $mapaStatusFuncionario[$status] ?? '<span><i class="fas fa-question-circle"></i> Status desconhecido</span>';
}
