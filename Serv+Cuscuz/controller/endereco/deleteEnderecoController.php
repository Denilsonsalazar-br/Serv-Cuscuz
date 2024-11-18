<?php
session_start();

require_once __DIR__ . "../../../model/DAO/enderecoDAO.php";

try {
    $id = $_POST['id'];

    $enderecoDAO = new EnderecoDAO();
    $resultado = $enderecoDAO->delete($id);

    if ($resultado) {
        $_SESSION['msg'] = [
            'tipo' => 'sucesso',
            'mensagem' => 'Endereço excluído com sucesso!'
        ];
    } else {
        throw new Exception('Erro ao excluir o endereço.');
    }

    header('Location: ../../view/cliente/perfil.php');
    exit();
} catch (Exception $e) {
    $_SESSION['msg'] = [
        'tipo' => 'erro',
        'mensagem' => $e->getMessage()
    ];
    header('Location: ../../view/cliente/perfil.php');
    exit();
}
