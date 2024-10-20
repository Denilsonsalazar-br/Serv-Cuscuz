<?php

//var_dump($funcionarios);

// Iniciar a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir os arquivos necessários
require_once "../../model/DAO/funcionarioDAO.php";

// Criar DAO e buscar funcionários
$funcionarioDAO = new FuncionarioDAO();
$funcionarios = $funcionarioDAO->listarFuncionarios(); // Você deve implementar esse método no DAO

// Exibir a lista de funcionários
require_once '../../view/admin/listaFuncionarios.php';
