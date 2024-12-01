<?php
// Iniciar a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "../../../model/DAO/PedidoDAO.php";
require_once __DIR__ . "../../../model/DTO/PedidoDTO.php";
require_once __DIR__ . "../../../model/DAO/src/conexaobd.php";
require_once __DIR__ . "../../../controller/pedido/traduzirStatus.php"; // Inclui a função de tradução

try {
    // Verifica se os dados foram enviados
    if (!isset($_POST['pedido_id'], $_POST['novo_status'])) {
        throw new Exception("Dados insuficientes para atualizar o pedido.");
    }

    $pedidoId = intval($_POST['pedido_id']);
    $novoStatus = $_POST['novo_status'];

    // Defina os status válidos conforme o ENUM na tabela
    $statusValidos = ['PENDENTE', 'PREPARANDO', 'A_CAMINHO', 'ENTREGUE', 'CANCELADO'];

    // Verifique se o novo status é válido
    if (!in_array($novoStatus, $statusValidos)) {
        throw new Exception("Status inválido. Escolha um dos status válidos.");
    }

    // Conecta ao banco
    $pdo = Conexao::getInstance();

    // Atualiza o status do pedido
    $pedidoDAO = new PedidoDAO($pdo);
    $pedido = $pedidoDAO->getById($pedidoId);

    if (!$pedido) {
        throw new Exception("Pedido não encontrado.");
    }

    // Cria o DTO e atualiza o status
    $pedidoDTO = new PedidoDTO();
    $pedidoDTO->setId($pedidoId);
    $pedidoDTO->setStatus($novoStatus);
    $pedidoDTO->setPrecoTotal($pedido['preco_total']);  // Mantém o preço atual do pedido

    // Atualiza no banco
    $atualizado = $pedidoDAO->update($pedidoDTO);

    if ($atualizado) {
        // Verifica o tipo de usuário para usar a função de tradução adequada
        if (isset($_SESSION['perfil']) && $_SESSION['perfil'] === 'FUNCIONARIO') {
            // Para o funcionário
            $statusLegivel = traduzirStatusFuncionario($novoStatus);
        } else {
            // Para o cliente
            $statusLegivel = traduzirStatusCliente($novoStatus);
        }

        $_SESSION['msg'] = ['tipo' => 'sucesso', 'mensagem' => "Status atualizado para: {$statusLegivel}."];

    } else {
        throw new Exception("Falha ao atualizar o status do pedido.");
    }
} catch (Exception $e) {
    $_SESSION['msg'] = ['tipo' => 'erro', 'mensagem' => $e->getMessage()];
}

// Redireciona de volta para a página de gerenciamento de pedidos
header("Location: ../../view/funcionario/pedidos.php");
exit();
