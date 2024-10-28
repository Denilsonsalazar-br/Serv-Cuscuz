<?php

//var_dump($funcionarios);

// Iniciar a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir os arquivos necessários "DAO"
require_once __DIR__ . "../../../model/DAO/clienteDAO.php";

// Criar DAO e buscar Clientes
$clienteDAO = new ClienteDAO();
$clientes = $clienteDAO->listarCliente(); 

// Exibir a lista de Clientes
require_once __DIR__ . "../../../view/admin/listaCliente.php";