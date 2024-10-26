<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/headerCadastro.css">
    <link rel="stylesheet" href="../../assets/css/painelControleAdmin.css">
    <title>Administração</title>
</head>
<body>
    <header>
        <nav class="nav-bar">    
            <div class="logo">
                <a href="#">
                    <img src="../../assets/img/logo-png-reduzida.png" alt="Serv+Cuscuz">
                </a>
            </div>
            <div class="botao">
                <button>
                    <?php 
                        include '../../pages/verificarLoginAdm.php';
                    ?>
                </button>
            </div>
        </nav>
    </header>
    <section class="BemVindoAdm">
        <?php 
        // Verifica se o usuário é um administrador
        if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 'ADMINISTRADOR') {
            header("Location: ../../controller/admin/adminPainelController.php");
            exit;
        }

        echo "<h1>Bem-vindo, " . $_SESSION['nome'] . "!</h1>";
        
        ?>
    </section>
    
    <div class="painelAdm">
        <nav >
            <a href="#">Home</a>
            <a href="../../view/admin/listaFuncionarios.php">Funcionários</a>
            <a href="../../view/cliente/listaCliente.php">Clientes</a>
            <a href="#">Produtos</a>
            <a href="#">Pedidos</a>
            <a href="#">Relatórios</a>
        </nav>
    </div> 
    <main>



    </main>

































  
    <!--<h1>Painel de Controle do Administrador</h1>
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
    </div>-->
    
</body>
</html>
