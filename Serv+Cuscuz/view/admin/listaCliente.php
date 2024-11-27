<?php
// Iniciar a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'ADMINISTRADOR') {
    header("Location: ../../pages/login.php");
    exit();
}

// Incluir o controlador que carrega os clientes
require_once  "../../controller/cliente/readClienteController.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/headerCadastro.css">
    <link rel="stylesheet" href="../../assets/css/painelControleAdmin.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
    <script src="../../assets/js/CDNs/jquery-3.7.1.min.js"></script>
    <script src="../../assets/js/CDNs/dataTables.js"></script>
    
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
        <nav class="navbar">
        <a href="../../view/admin/adminPainelController.php">Home</a>
            <a href="../../view/admin/categoria.php">Categoria</a>
            <a href="../../view/admin/produtos.php">Produtos</a>
            <a href="../../view/admin/pedidos.php">Pedidos</a>
            <a href="../../view/admin/listaFuncionarios.php">Funcionários</a>
            <a href="../../view/admin/listaCliente.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'listaCliente.php') ? 'ativo' : ''; ?>">Clientes</a>
            <a href="../../view/admin/carrosselHome.php">Carrossel Home</a>
            <a href="../../view/admin/relatorios.php">Relatórios</a>
        </nav>
    </div> 

    <!--<section class="BemVindoAdm">
        <?php 
        // Verifica se o usuário é um administrador
        /*if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 'ADMINISTRADOR') {
            header("Location: ../../controller/admin/adminPainelController.php");
            exit;
        }

        echo "<h1>Bem-vindo, " . $_SESSION['nome'] . "!</h1>";*/
        
        ?>
    </section>-->

    <div class="homeAdm">
    <main>
        <h1>Clientes</h1>
            <section class="section__btn">
                <div class="alertaSucessoError">
                    <?php if (isset($_SESSION['msg'])): ?>
                        <div class="alerta success" id="msgSucesso">
                            <?php echo htmlspecialchars($_SESSION['msg']); ?>
                        </div>
                        <?php unset($_SESSION['msg']); // Remove a mensagem da sessão ?>
                    <?php elseif (isset($_SESSION['error'])): ?>
                        <div class="alerta error" id="msgErro">
                            <?php echo htmlspecialchars($_SESSION['error']); ?>
                        </div>
                        <?php unset($_SESSION['error']); // Remove a mensagem da sessão ?>
                    <?php endif; ?>
                </div>
                    <a class="btnAdm" href="#" target="_blank">Imprimir</a>

            </section>
        <section>
            <table id="myTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Sobrenome</th>
                        <th>Cpf</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th class="gerenciarAdm">Gerenciar</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (isset($clientes) && is_array($clientes)): ?>
                    <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td>
                            <?php echo htmlspecialchars($cliente['id']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($cliente['nome']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($cliente['sobrenome']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($cliente['cpf']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($cliente['email']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($cliente['telefone']); ?>
                        </td>
                        <td class="tdOperacao">
                                <div class="alterarExcluir">
                                    <a class="btnexcluir" href="../../controller/cliente/deleteClienteController.php?id=<?= $cliente['id']; ?>" onclick="return confirm('Deseja confirmar a operação?');">Excluir</a>
                                </div>
                        </td>       
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    </tbody>
                    <tr>
                        <td colspan="6">Nenhum funcionário encontrado.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </section>
    </main>     
    </div>
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable( {
                language: {
                    url: '../../assets/js/CDNs/dataTable-pt-BR.json',
                }
            } );
            
        } );
    </script>
    
    <script src="../../assets/js/mensagens/tempoMensagem.js"></script>
</body>
</html>