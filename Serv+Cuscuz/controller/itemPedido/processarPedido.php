<?php
session_start(); // Inicia a sessão

require_once __DIR__ . "../../../model/DAO/ItemPedidoDAO.php";
require_once __DIR__ . "../../../model/DTO/ItemPedidoDTO.php";

$pdo = Conexao::getInstance(); // Conexão com o banco de dados

// Verificar se o carrinho não está vazio
if (!empty($_SESSION['cart'])) {
    try {
        // Iniciar transação
        $pdo->beginTransaction();
    
        // Obter dados do cliente
        $clienteId = $_SESSION['id'];
        $dataPedido = date('Y-m-d H:i:s'); // Data do pedido
        $status = 'PENDENTE'; // Status inicial do pedido

        // Obter o nome do cliente para exibir na confirmação
        $stmt = $pdo->prepare("SELECT nome FROM t_cliente WHERE id = :id");
        $stmt->bindParam(':id', $clienteId);
        $stmt->execute();
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        $nomeCliente = $cliente['nome']; // Nome do cliente
    
        // Calcular o valor total da compra
        $valorTotal = 0;
        foreach ($_SESSION['cart'] as $produto) {
            $valorTotal += $produto['total']; // Somando o total de cada produto no carrinho
        }
    
        // Inserir dados do pedido na tabela 't_pedido'
        $stmt = $pdo->prepare("INSERT INTO t_pedido (t_cliente_id, data, status, preco_total) 
                               VALUES (:t_cliente_id, :data_pedido, :status, :preco_total)");
        $stmt->bindParam(':t_cliente_id', $clienteId);
        $stmt->bindParam(':data_pedido', $dataPedido);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':preco_total', $valorTotal);
        $stmt->execute();
    
        // Obter o ID do pedido recém-criado
        $pedidoId = $pdo->lastInsertId();
    
        // Inserir itens do pedido na tabela 't_itempedido'
        foreach ($_SESSION['cart'] as $produto) {
            $produtoId = $produto['id'];
            $quantidade = $produto['quantity'];
    
            // Inserir item na tabela 't_itempedido'
            $stmt = $pdo->prepare("INSERT INTO t_itempedido (t_pedido_id, t_produto_id, quantidade) 
            VALUES (:t_pedido_id, :t_produto_id, :quantidade)");
    
            $stmt->bindParam(':t_pedido_id', $pedidoId); // Relacionando o pedido com os itens
            $stmt->bindParam(':t_produto_id', $produtoId); // Produto que foi adicionado
            $stmt->bindParam(':quantidade', $quantidade); // Quantidade do produto no pedido
    
            $stmt->execute();
        }
    
        // Confirmar transação
        $pdo->commit();
    
        // Limpar o carrinho após a confirmação do pedido
        unset($_SESSION['cart']);
    
        // Armazenar as informações do pedido na sessão para exibição na confirmação
        $_SESSION['pedido'] = [
            'nome_cliente' => $nomeCliente,
            'valor_total' => $valorTotal,
            'pedido_id' => $pedidoId
        ];
    
        // Redirecionar o cliente para a página de confirmação
        $_SESSION['msg'] = ['tipo' => 'sucessoPedido', 'mensagem' => 'Pedido confirmado com sucesso!'];
        header('Location: ../../view/cliente/finalizarPagamento.php');
        exit();
    } catch (Exception $e) {
        // Se ocorrer algum erro, reverter a transação
        $pdo->rollBack();
        $_SESSION['msg'] = ['tipo' => 'erroPedido', 'mensagem' => 'Erro ao confirmar o pedido: ' . $e->getMessage()];
        header('Location: ../../view/cliente/pagamento.php');
        exit();
    }
}