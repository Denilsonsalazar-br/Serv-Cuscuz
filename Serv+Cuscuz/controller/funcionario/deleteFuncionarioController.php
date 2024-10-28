<?php
session_start(); 

require_once __DIR__ . "../../../model/DAO/funcionarioDAO.php";

# cria a variavel $id com valor igual a 1. 
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?? 0;

$dao = new funcionarioDAO();
$result = $dao->deleteFuncionario($id);



if ($result > 0) {
    $_SESSION['msgFuncionario'] = "Funcionário excluído com sucesso!";
} else {
    $_SESSION['errorFuncionario'] = "Não foi possível excluir o funcionário!";
}

header('Location: ../../view/admin/listaFuncionarios.php');