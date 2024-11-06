<?php

//var_dump($funcionarios);

// Iniciar a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir os arquivos necessários
require_once __DIR__ . "../../../model/DAO/funcionarioDAO.php";

// Criar DAO e buscar funcionários
$funcionarioDAO = new FuncionarioDAO();
$funcionarios = $funcionarioDAO->listarFuncionarios(); //método no DAO

// Exibir a lista de funcionários
require_once __DIR__ . "../../../view/admin/listaFuncionarios.php";
