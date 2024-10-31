<?php
// Iniciar a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir o controlador que carrega os funcionários
require_once __DIR__ . "../../../controller/funcionario/readFuncionarioController.php";
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
                <a href="../../pages/home.php">
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
    <div class="painelAdm">
        <nav >
            <a href="../../controller/admin/adminPainelController.php">Home</a>
            <a href="../../view/admin/listaFuncionarios.php">Funcionários</a>
            <a href="../../view/admin/listaCliente.php">Clientes</a>
            <a href="#">Produtos</a>
            <a href="#">Pedidos</a>
            <a href="#">Relatórios</a>
        </nav>
    </div>
    <!--<section class="BemVindoAdm">
        <?php 
        // Verifica se o usuário é um administrador
       /* if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 'ADMINISTRADOR') {
            header("Location: ../../controller/admin/adminPainelController.php");
            exit;
        }

        echo "<h1>Bem-vindo, " . $_SESSION['nome'] . "!</h1>";*/
        
        ?>
    </section>-->
     
    <div class="homeAdm">
        <main>
            <h1>Funcionários</h1>
            <section class="section__btnFuncionario">
            <div class="alertaSucessoError">
                    <?php if (isset($_SESSION['msgFuncionario'])): ?>
                        <div class="alerta success">
                            <?php echo htmlspecialchars($_SESSION['msgFuncionario']); ?>
                        </div>
                        <?php unset($_SESSION['msgFuncionario']); // Remove a mensagem da sessão ?>
                    <?php elseif (isset($_SESSION['errorFuncionario'])): ?>
                        <div class="alerta error">
                            <?php echo htmlspecialchars($_SESSION['errorFuncionario']); ?>
                        </div>
                        <?php unset($_SESSION['errorFuncionario']); // Remove a mensagem da sessão ?>
                    <?php endif; ?>
                </div>
                <a class="btnAdm" href="../../view/admin/cadastroFuncionarios.php">Novo</a>
                <a class="btnAdm" href="#" target="_blank">Imprimir</a>
            </section>
            <section>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Cpf</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Tipo Perfil</th>
                        <th class="gerenciarAdm">Gerenciar</th>
                    </tr>
                    <?php if (isset($funcionarios) && is_array($funcionarios)): ?>
                        <?php foreach ($funcionarios as $funcionario): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($funcionario['id']); ?></td>
                            <td><?php echo htmlspecialchars($funcionario['nome']); ?></td>
                            <td><?php echo htmlspecialchars($funcionario['cpf']); ?></td>
                            <td><?php echo htmlspecialchars($funcionario['email']); ?></td>
                            <td><?php echo htmlspecialchars($funcionario['telefone']); ?></td>
                            <td><?php echo htmlspecialchars($funcionario['t_perfil_id']); ?></td> 
                            <td class="tdOperacao">
                                <div class="alterarExcluir">
                                <a class="btnalterar" href="../../controller/funcionario/editFuncionarioController.php?id=<?= $funcionario['id']; ?>">Alterar</a>
                                <a class="btnexcluir" href="../../controller/funcionario/deleteFuncionarioController.php?id=<?= $funcionario['id']; ?>" onclick="return confirm('Deseja confirmar a operação?');">Excluir</a>
                                </div>
                            </td>         
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Nenhum funcionário encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </table>
            </section>
        </main>
    </div>
</body>
</html>