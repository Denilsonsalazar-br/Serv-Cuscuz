<?php

// Mensagens
$mensagemSucesso = isset($_SESSION['mensagemSucesso']) ? $_SESSION['mensagemSucesso'] : '';
$mensagemErro = '';
$mensagemErroCpf = '';
$mensagemErroEmail = '';
$mensagemErroSenha = '';
$mensagemErroEmailDiferente = '';

// Limpa a mensagem de sucesso após exibição
if ($mensagemSucesso) {
    unset($_SESSION['mensagemSucesso']);
}
?>
--------------------------- No Formulário ----------------------------------
<!-- Mensagem de cadastro realizado com sucesso -->
<?php if ($mensagemSucesso): ?>
    <span class="mensagemsucesso">
        <?= htmlspecialchars($mensagemSucesso) ?>
    </span>
<?php endif; ?>

----------------------------------------------------------------------------

<?php if ($mensagemErro): ?>
    <div style="color: red;"><?= htmlspecialchars($mensagemErro) ?></div>
<?php endif; ?>

----------------------------------------------------------------------------

<span id="mensagemErroSenha" style="color: red;">
    <?php if ($mensagemErroSenha): ?>
        <?= htmlspecialchars($mensagemErroSenha) ?>
    <?php endif; ?>
</span>

----------------------------------------------------------------------------

<input type="email" id="email" name="email" placeholder="Email" value="<?= htmlspecialchars($email) ?>" required>
    <span id="mensagemErroEmail" style="color: red;">
        <?php if ($mensagemErroEmail && strpos($mensagemErroEmail, 'e-mail') !== false): ?>
            <?= htmlspecialchars($mensagemErroEmail) ?>
        <?php endif; ?>
    </span>
<input type="email" id="confirmarEmail" name="confirmarEmail" placeholder="Confirmar email" value="<?= htmlspecialchars($confirmarEmail) ?>" required>
    <span id="mensagemErroEmailDiferente" style="color: red;">
        <?= htmlspecialchars($mensagemErroEmailDiferente)?>
    </span>

----------------------------------------------------------------------------

<input type="text" id="cpf" name="cpf" placeholder="CPF" value="<?= htmlspecialchars($cpf) ?>" required maxlength="14">
    <span id="mensagemErroCpf" style="color: red;">
        <?= htmlspecialchars($mensagemErroCpf) ?>
    </span>

----------------------------------------------------------------------------

<!--Mensagem de sucesso-->
<?php if (isset($_SESSION['sucesso'])): ?>
        <span style="color:green;">
            <?php echo $_SESSION['sucesso']; ?>
        </span>
        <?php unset($_SESSION['sucesso']); // Limpa a mensagem após exibi-la ?>
    <?php endif; ?>
    <!--Mensagem de erro-->

    <?php if (isset($_SESSION['error'])): ?>
        <span style="color:red;">
            <?php echo $_SESSION['error']; ?>
        </span>
        <?php unset($_SESSION['error']); // Limpa a mensagem após exibi-la ?>
    <?php endif; ?>

----------------------------------------------------------------------------
    <?php if (isset($_SESSION['cpf_error'])): ?>
        <span style="color:red;">
            <?php echo $_SESSION['cpf_error']; ?>
        </span>
    <?php unset($_SESSION['cpf_error']); // Limpa a mensagem após exibi-la ?>
    <?php endif; ?>
----------------------------------------------------------------------------
    <?php if (isset($_SESSION['success'])): ?>
        <span style="color:green;">
            <?php echo $_SESSION['success']; ?>
        </span>
    <?php unset($_SESSION['success']); // Limpa a mensagem após exibi-la ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <span style="color:red;">
            <?php echo $_SESSION['error']; ?>
        </span>
    <?php unset($_SESSION['error']); // Limpa a mensagem após exibi-la ?>
    <?php endif; ?>
----------------------------------------------------------------------------

----------------------------------------------------------------------------

----------------------------------------------------------------------------