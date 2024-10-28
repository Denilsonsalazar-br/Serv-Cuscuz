<?php
session_start(); 

require_once __DIR__ . "../../../model/DAO/clienteDAO.php";

# cria a variavel $id com valor igual a 1. 
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?? 0;

$dao = new ClienteDAO();
$result = $dao->deleteCliente($id);



if ($result > 0) {
    $_SESSION['msg'] = "Perfil excluído com sucesso!";
} else {
    $_SESSION['error'] = "Não foi possível excluir o perfil!";
}

header('Location: ../../view/cliente/listaCliente.php');