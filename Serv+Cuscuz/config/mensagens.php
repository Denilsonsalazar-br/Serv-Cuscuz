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
