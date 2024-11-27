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
    <link rel="stylesheet" href="../../assets/css/mensagens/mensagens.css">
    <link rel="stylesheet" href="../../assets/css/funcionario/dataTable.css">
    <script src="../../assets/js/CDNs/jquery-3.7.1.min.js"></script>
    <script src="../../assets/js/CDNs/dataTables.js"></script>

    <!-- Incluir jsPDF -->
    <script src="../../assets/js/CDNs/geradorPDF.js"></script>


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
            <a href="../../view/admin/listaFuncionarios.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'listaFuncionarios.php') ? 'ativo' : ''; ?>">Funcionários</a>
            <a href="../../view/admin/listaCliente.php">Clientes</a>
            <a href="../../view/admin/carrosselHome.php">Carrossel Home</a>
            <a href="../../view/admin/relatorios.php">Relatórios</a>
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
                        <div class="alerta success" id="msgSucesso">
                            <?php echo htmlspecialchars($_SESSION['msgFuncionario']); ?>
                        </div>
                        <?php unset($_SESSION['msgFuncionario']); // Remove a mensagem da sessão ?>
                    <?php elseif (isset($_SESSION['errorFuncionario'])): ?>
                        <div class="alerta error" id="msgErro">
                            <?php echo htmlspecialchars($_SESSION['errorFuncionario']); ?>
                        </div>
                        <?php unset($_SESSION['errorFuncionario']); // Remove a mensagem da sessão ?>
                    <?php endif; ?>

                    <!--mensagens para o retono da edição do funcionario-->
                    <?php if (isset($_SESSION['successeditFun'])): ?>
                        <div class="msg msgsucesso" id="msgSucesso">
                            <h4>Sucesso!</h4>
                            <p><?php echo $_SESSION['successeditFun']; ?></p>
                        </div>
                        <?php unset($_SESSION['successeditFun']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['erroreditFun'])): ?>
                        <div class="msg msgerro" id="msgErro">
                            <h4>Erro!</h4>
                            <p><?php echo $_SESSION['erroreditFun']; ?></p>
                        </div>
                        <?php unset($_SESSION['erroreditFun']); ?>
                    <?php endif; ?>


                </div>
                <a class="btnAdm" href="../../view/admin/cadastroFuncionarios.php">Novo</a>
                <a class="btnAdm" href="#" id="printBtn" target="_blank">Imprimir</a>
            </section>

            <script>
                document.getElementById('printBtn').addEventListener('click', function(e) {
                    e.preventDefault();  // Previne o comportamento padrão do link

                    const { jsPDF } = window.jspdf;
                    const doc = new jsPDF();

                    // Título do PDF
                    doc.setFont("helvetica", "bold");
                    doc.setFontSize(16);
                    doc.text("Lista de Funcionários", 14, 10);

                    // Configuração para adicionar a tabela
                    const table = document.getElementById('myTable');
                    const rows = table.rows;
                    let y = 20;  // Posição inicial Y para os dados da tabela
                    const rowHeight = 12;  // Altura de cada linha da tabela (aumentada para espaçamento entre linhas)
                    const padding = 2; // Espaço entre o texto e as bordas

                    // Definindo as larguras das colunas (excluindo a última coluna)
                    const columnWidths = [8, 40, 25, 60, 30, 25]; // Ajustando para 6 colunas

                    // Cabeçalho da tabela
                    doc.setFont("helvetica", "normal");
                    doc.setFontSize(12);
                    const header = rows[0].cells;
                    let x = 14;  // Posição X inicial para as células
                    for (let i = 0; i < header.length - 1; i++) { // Exclui a última coluna
                        doc.text(header[i].innerText, x + padding, y + rowHeight - 2); // Ajusta o texto para subir
                        x += columnWidths[i];  // Ajusta a largura das colunas
                    }

                    // Adicionando as bordas para as células do cabeçalho
                    x = 14;
                    for (let i = 0; i < header.length - 1; i++) { // Exclui a última coluna
                        doc.rect(x, y, columnWidths[i], rowHeight);  // Borda do cabeçalho
                        x += columnWidths[i];
                    }
                    y += rowHeight;  // Aumenta a posição Y para a próxima linha

                    // Corpo da tabela (dados dos funcionários)
                    doc.setFontSize(10);
                    for (let i = 1; i < rows.length; i++) {  // Começa da segunda linha, pois a primeira é o cabeçalho
                        const cells = rows[i].cells;
                        x = 14;  // Resetando o X para a próxima linha de dados
                        for (let j = 0; j < cells.length - 1; j++) { // Exclui a última coluna
                            doc.text(cells[j].innerText, x + padding, y + rowHeight - 2); // Ajusta o texto para subir
                            x += columnWidths[j];  // Ajusta a largura das colunas conforme necessário
                        }
                        // Adicionando as bordas para as células do corpo da tabela
                        x = 14;
                        for (let j = 0; j < cells.length - 1; j++) { // Exclui a última coluna
                            doc.rect(x, y, columnWidths[j], rowHeight);  // Borda de cada célula
                            x += columnWidths[j];
                        }
                        y += rowHeight;  // Aumenta a posição Y para a próxima linha
                    }

                    // Salva o PDF gerado
                    doc.save('lista_funcionarios.pdf');
                });
            </script>

            <section>
                <table id="myTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Cpf</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Tipo Perfil</th>
                            <th class="gerenciarAdm">Gerenciar</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($funcionarios) && is_array($funcionarios)): ?>
                        <?php foreach ($funcionarios as $funcionario): ?>
                        <tr>
                            <td>
                                <?php echo htmlspecialchars($funcionario['id']); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($funcionario['nome']); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($funcionario['cpf']); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($funcionario['email']); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($funcionario['telefone']); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($funcionario['t_perfil_id']); ?>
                            </td> 
                            <td class="tdOperacao">
                                <div class="alterarExcluir">
                                    
                                <!--token usado para codificar o id na url-->

                                <a class="btnalterar" href="../../controller/funcionario/editFuncionarioController.php?token=<?= base64_encode($funcionario['id']); ?>">Alterar</a>

                                <a class="btnexcluir" href="../../controller/funcionario/deleteFuncionarioController.php?id=<?= $funcionario['id']; ?>" onclick="return confirm('Deseja confirmar a operação?');">Excluir</a>
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
    $(document).ready(function() {
        if (!$.fn.dataTable.isDataTable('#myTable')) {
            $('#myTable').DataTable({
                language: {
                    url: '../../assets/js/CDNs/dataTable-pt-BR.json'
                }
            });
        }
    });
</script>

<script src="../../assets/js/mensagens/tempoMensagem.js"></script>
</body>
</html>