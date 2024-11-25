<?php
// Iniciar a sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/headerCadastro.css">
    <link rel="stylesheet" href="../../assets/css/cadastroCliente.css">
    <link rel="stylesheet" href="../../assets/css/mensagens.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link rel="stylesheet" href="../../assets/css/cliente/termos.css">
    <title>Páginan de Cadastro</title>
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
                <button><a href="../../pages/login.php">Login</a></button>
            </div>
        </nav>
    </header>
    <!--<div class="tituloCadastroCliente">
        <h1>Serv+Cuscuz</h1> 
        <h3>"Mais sabor, mais praticidade!"</h3>
    </div>-->
<main>    
        <div class="containerCadastroCliente">
                <div class="msg">
                <span>
                <!-- Mensagem de sucesso -->
                <?php if (isset($_SESSION['sucesso'])): ?>
                    <div class="msgsucesso" id="msgsucesso">
                        <?php echo $_SESSION['sucesso']; ?>
                    </div>
                    <?php unset($_SESSION['sucesso']); // Limpa a mensagem após exibi-la ?>
                <?php endif; ?>

                <!-- Mensagem de erro -->
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="msgerro" id="msgerro">
                        <?php echo $_SESSION['error']; ?>
                    </div>
                    <?php unset($_SESSION['error']); // Limpa a mensagem após exibi-la ?>
                <?php endif; ?>
                </span>
            </div>

            <form method="POST" action="../../controller/cliente/createClienteController.php" onsubmit="return validarFormulario()">

                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" placeholder="Digite seu nome." required>
                <span id="mensagemErroNome" class="erro"></span>
                <br>
                <label for="sobrenome">Sobrenome:</label>
                <input type="text" id="sobrenome" name="sobrenome" placeholder="Digite seu sobrenome completo." required>
                <span id="mensagemErroSobrenome" class="erro"></span>
                <br>
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF" maxlength="14" required>
                <span id="mensagemErroCpf" class="erro"></span>
                    <?php if (isset($_SESSION['cpf_error'])): ?>
                        <span style="color:#000000;"><?php echo $_SESSION['cpf_error']; ?></span>
                        <?php unset($_SESSION['cpf_error']); // Limpa a mensagem após exibi-la ?>
                    <?php endif; ?>
                <br>
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" placeholder="Digite seu telefone" maxlength="15" required>
                <span id="mensagemErroTelefone" class="erro"></span>
                <br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Digite seu email." required>
                <span id="mensagemErroEmail" class="erro"></span>

                <?php if (isset($_SESSION['email_error'])): ?>
                        <span style="color:#000000;">
                            <?php echo $_SESSION['email_error']; ?>
                        </span>
                        <?php unset($_SESSION['email_error']); 
                        // Limpa a mensagem após exibi-la ?>
                    <?php endif; ?>
                <br>
                <label for="confirmarEmail">Confirme o Email:</label>
                <input type="email" id="confirmarEmail" name="confirmarEmail" placeholder="Por favor, confirme seu email" required>
                <span id="mensagemErroEmailDiferente" class="erro"></span>
                <br>
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" placeholder="Insira sua senha" required>
                <span id="mensagemErroSenha" class="erro"></span>

                    <?php if (isset($_SESSION['senha_error'])): ?>
                        <span style="width: 100%; color: #000000;">
                            <?php echo $_SESSION['senha_error']; ?>
                        </span>
                        <?php unset($_SESSION['senha_error']); // Limpa a mensagem após exibi-la ?>
                    <?php endif; ?>
                <br>
                <br>
                <label for="confirmarSenha">Confirme a Senha:</label>
                <input type="password" id="confirmarSenha" name="confirmarSenha" placeholder="Confirme sua senha" required>
                <span id="mensagemErroSenhaDiferente" class="erro"></span>
                <br><br>

                <div class="termos">
                    <div>
                        <input type="checkbox" id="termos" required>
                    </div>
                    <div>
                        <label for="termos">
                            Aceito os <a href="#" id="abrirModalTermos">termos e condições</a>
                        </label>
                    </div>
                </div>

                <!-- Modal de Termos e Condições -->
                <div id="modalTermos" class="modal-termos">
                    <div class="modal-termos-content">
                        <span class="modal-termos-close">&times;</span>
                        <h2>Serv+Cuscuz</h2>
                        <h3>Termos e Condições.</h3>
                        <div class="conteudo-termos">
                        <p>
                            Bem-vindo(a) ao Serv+Cuscuz! Somos uma plataforma especializada em oferecer o melhor do cuscuz diretamente na sua mesa, com praticidade e rapidez. 
                            Ao utilizar nossos serviços, você concorda com os termos e condições descritos abaixo.
                        </p>

                        <ol>
                            <li><span class="numero">1.</span> Aceitação dos Termos</li>
                            <p>
                            Ao acessar e utilizar a plataforma Serv+Cuscuz, você declara ter lido, entendido e aceitado integralmente estes <strong>Termos e Condições</strong>. Caso não concorde com algum ponto, solicitamos que não utilize nossos serviços.
                            </p>

                            <li><span class="numero">2.</span> Funcionamento da Plataforma</li>
                            <ul>
                            <li><span class="numero">2.1.</span> O Serv+Cuscuz é uma plataforma de delivery onde você pode realizar pedidos de cuscuz e acompanhar seu status.</li>
                            <li><span class="numero">2.2.</span> Para efetuar um pedido, você deve fornecer informações pessoais verdadeiras, incluindo:
                                <ul class="Informacao">
                                <li>Nome completo;</li>
                                <li>Sobrenome;</li>
                                <li>CPF;</li>
                                <li>Endereço de entrega;</li>
                                <li>E-mail;</li>
                                <li>Número de telefone.</li>
                                </ul>
                            </li>
                            <li><span class="numero">2.3.</span> A entrega será realizada no endereço informado pelo usuário no momento do pedido. Certifique-se de que os dados estejam corretos e atualizados.</li>
                            </ul>

                            <li><span class="numero">3.</span> Cadastro do Usuário</li>
                            <ul>
                            <li><span class="numero">3.1.</span> Para utilizar nossos serviços, é necessário que você realize um cadastro fornecendo as informações solicitadas.</li>
                            <li><span class="numero">3.2.</span> Você é responsável por manter os dados atualizados e por qualquer atividade realizada por meio de sua conta.</li>
                            <li><span class="numero">3.3.</span> Dados fornecidos incorretamente ou incompletos podem impossibilitar a entrega do pedido.</li>
                            </ul>

                            <li><span class="numero">4.</span> Pagamentos</li>
                            <ul>
                            <li><span class="numero">4.1.</span> O Serv+Cuscuz aceita exclusivamente pagamentos via Pix, por meio de um QR Code gerado automaticamente após a confirmação do pedido.</li>
                            <li><span class="numero">4.2.</span> O processamento do pagamento é realizado por uma API externa, de forma segura e protegida. Não armazenamos seus dados financeiros.</li>
                            <li><span class="numero">4.3.</span> O pedido será considerado confirmado somente após a validação do pagamento.</li>
                            </ul>

                            <li><span class="numero">5.</span> Responsabilidade do Usuário</li>
                            <ul>
                            <li><span class="numero">5.1.</span> O usuário é responsável por:
                                <ul>
                                <li>Garantir que as informações fornecidas na plataforma são verdadeiras e completas.</li>
                                <li>Conferir o pedido antes de confirmá-lo.</li>
                                <li>Estar disponível para receber o pedido no endereço informado.</li>
                                </ul>
                            </li>
                            <li><span class="numero">5.2.</span> Qualquer erro decorrente de informações incorretas ou ausência do usuário no momento da entrega será de responsabilidade exclusiva do usuário.</li>
                            </ul>

                            <li><span class="numero">6.</span> Política de Entrega</li>
                            <ul>
                            <li><span class="numero">6.1.</span> As entregas serão realizadas no endereço fornecido pelo usuário, dentro do horário de funcionamento da plataforma.</li>
                            <li><span class="numero">6.2.</span> Caso o endereço seja inacessível ou o cliente esteja ausente, tentaremos contato via telefone. Não sendo possível a entrega, o pedido será cancelado sem reembolso do valor pago.</li>
                            </ul>

                            <li><span class="numero">7.</span> Política de Cancelamento</li>
                            <ul>
                            <li><span class="numero">7.1.</span> Pedidos podem ser cancelados antes da confirmação do pagamento via Pix.</li>
                            <li><span class="numero">7.2.</span> Após a confirmação do pagamento, não será possível realizar o cancelamento ou reembolso.</li>
                            </ul>

                            <li><span class="numero">8.</span> Privacidade e Proteção de Dados (LGPD)</li>
                            <li>Lei Geral de Proteção de Dados <strong>(Lei nº 13.709/2018).</strong></li>
                            <ul>
                            <li><span class="numero">8.1.</span> O Serv+Cuscuz respeita a sua privacidade e garante a proteção de seus dados pessoais, conforme previsto na Lei Geral de Proteção de Dados (LGPD).</li>
                            <li><span class="numero">8.2.</span> Os dados fornecidos serão utilizados apenas para:
                                <ul>
                                <li>Processamento e entrega de pedidos;</li>
                                <li>Emissão de notas fiscais;</li>
                                <li>Contato, se necessário, para questões relacionadas ao pedido.</li>
                                </ul>
                            </li>
                            <li><span class="numero">8.3.</span> Período de retenção dos dados: os dados serão armazenados apenas enquanto forem necessários para os fins especificados, respeitando o Art. 6º da LGPD.</li>
                            <li><span class="numero">8.4.</span> Seus dados não serão vendidos, compartilhados ou utilizados para fins não relacionados ao serviço.</li>
                            <li><span class="numero">8.5.</span> O usuário pode exercer os direitos garantidos pelo Art. 18 da LGPD, como:
                                <ul>
                                <li>Acesso aos dados armazenados;</li>
                                <li>Correção ou atualização de informações;</li>
                                <li>Exclusão de dados, exceto aqueles necessários para cumprimento de obrigações legais.</li>
                                </ul>
                            </li>
                            </ul>

                            <li><span class="numero">9.</span> Uso de API Externa</li>
                            <p>O processamento do pagamento via Pix é realizado por uma API externa. Apesar de garantirmos o uso de parceiros confiáveis, não nos responsabilizamos por problemas técnicos ou erros ocorridos na plataforma de pagamento.</p>

                            <li><span class="numero">10.</span> Alterações nos Termos</li>
                            <ul>
                            <li><span class="numero">10.1.</span> O Serv+Cuscuz reserva-se o direito de alterar os Termos e Condições a qualquer momento, com aviso prévio aos usuários.</li>
                            <li><span class="numero">10.2.</span> É responsabilidade do usuário revisar regularmente os termos atualizados.</li>
                            </ul>

                            <li><span class="numero">11.</span> Contato</li>
                            <p>Em caso de dúvidas, reclamações ou solicitações, entre em contato pelo e-mail: <a style="color: #ff5733;" href="mailto:servmaiscuscuz@gmail.com">servmaiscuscuz@gmail.com</a> ou pelo telefone: <a style="color: #ff5733;" href="tel:+5561992689834">+55 (61) 99268-9834</a>.</p>
                            <br>
                            <p>Obrigado por escolher o Serv+Cuscuz! Nosso objetivo é garantir praticidade e sabor na sua mesa.</p>
                        </ol>
                        </div>

                        <div class="modal-termos-footer">
                            <button id="aceitarTermos" class="modal-termos-btn">Aceitar</button>
                        </div>
                    </div>
                </div>

                
                <div class="botaoCadastrarCliente">
                    <button type="submit">Cadastrar</button>
                </div> 
            </form>
        </div>
</main>

<footer>
        <div class="containerFooter">
            <ul>
                <h2>Serv+Cuscuz</h2>
                <p>"Mais sabor, mais praticidade!"</p>
                <div class="redes-sociais">
                    <a href="#"><img src="../../assets/rede-social/facebook.png" alt="Facebook"></a>
                    <a href="#"><img src="../../assets/rede-social/whatsapp.png" alt="Whatsapp"></a>
                    <a href="#"><img src="../../assets/rede-social/instagram.png" alt="Instagram"></a>
                </div>
            </ul>
            <ul>
                <h2>Link</h2>
                <li><a href="#">Home</a></li>
                <li><a href="#">Cardápio</a></li>
                <li><a href="#">Sobre</a></li>
            </ul>
            <ul>
                <h2>Suporte</h2>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">Como funciona</a></li>
                <li><a href="#">Comunicando</a></li>
            </ul>
            <ul>
                <h2>Nossos contatos</h2>
                <li><a href="#">+55(61)99268-9834</a></li>
                <li><a href="#">servmaiscuscuz@gmail.com</a></li>
                <li><a href="#">Brasil</a></li>
            </ul>
        </div>

    </footer>
<script src="../../assets/js/mascaras.js"></script>

<script src="../../assets/js/mensagens/tempoMensagem.js"></script>
<script src="../../assets/js/cliente/cadastroCliente.js" ></script>
</body>
</html>