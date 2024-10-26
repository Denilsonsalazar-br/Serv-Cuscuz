<?php
session_start();

// Verifica se o usuário é um administrador
if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 'ADMINISTRADOR') {
    header("Location: ../../controller/admin/adminPainelController.php");
    exit;
}

echo "<h1>Bem-vindo, " . $_SESSION['nome'] . "!</h1>";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/painelControleAdmin.css">
    <title>Administrador</title>
</head>
<body>
    
    <h1>Painel de Controle do Administrador</h1>
    <div class="container">
        <div class="funcionario">
            <fieldset>
                <legend>Funcionário</legend>
            <nav>
                <ul>
                    <li><a href="../../view/admin/listaFuncionarios.php">Lista de Funcionários</a></li><br>
                    <li><a href="../../view/admin/cadastroFuncionarios.php">Cadastrar Funcionários</a></li><br>
                    <li><a href="../../view/admin/editarFuncionario.php">Editar Funcionários</a></li><br>
                    <li><a href="../../view/admin/excluirFuncionario.php">Excluir Funcionários</a></li>
                </ul>
            </nav>    
            </fieldset>
        </div>
        <div class="cliente">
            <fieldset>
                <legend>Cliente</legend>
            <nav>
                <ul>
                    <li><a href="../../view/cliente/listaCliente.php">Lista de Clientes</a></li><br>
                    <li><a href="../../view/cliente/excluirCliente.php">Excluir Cliente</a></li>
                </ul>
            </nav>
            </fieldset>
        </div>   
    </div> 
    
    <a href="../../pages/logout.php"> Sair</a>
</body>
</html>
