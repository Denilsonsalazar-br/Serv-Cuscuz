document.addEventListener("DOMContentLoaded", function () {
    const cpfInput = document.getElementById('cpf');
    const telefoneInput = document.getElementById('telefone');
    const nomeInput = document.getElementById('nome');
    const sobrenomeInput = document.getElementById('sobrenome');
    const emailInput = document.getElementById('email');
    const confirmarEmailInput = document.getElementById('confirmarEmail');
    const senhaInput = document.getElementById('senha');
    const confirmarSenhaInput = document.getElementById('confirmarSenha');

    const mensagemErroSobrenome = document.getElementById('mensagemErroSobrenome');
    const mensagemErroNome = document.getElementById('mensagemErroNome');
    const mensagemErroEmailDiferente = document.getElementById('mensagemErroEmailDiferente');
    const mensagemErroSenhaDiferente = document.getElementById('mensagemErroSenhaDiferente');

    function maskCPF(value) {
        value = value.replace(/\D/g, '');
        if (value.length > 11) value = value.slice(0, 11);
        return value.replace(/(\d{3})(\d)/, '$1.$2')
                    .replace(/(\d{3})(\d)/, '$1.$2')
                    .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    }

    function maskTelefone(value) {
        return value.replace(/\D/g, '')
                    .replace(/^(\d{2})(\d)/, '($1) $2')
                    .replace(/(\d{5})(\d)/, '$1-$2');
    }

    cpfInput.addEventListener('input', function () {
        this.value = maskCPF(this.value);
    });

    telefoneInput.addEventListener('input', function () {
        this.value = maskTelefone(this.value);
    });

    function capitalizeWords(text) {
        return text.replace(/\b\w/g, char => char.toUpperCase());
    }

    function validarNome(nome) {
        const regex = /^[a-zA-Zà-úÀ-Ú]+$/;
        return regex.test(nome);
    }

    nomeInput.addEventListener('input', function() {
        const nome = nomeInput.value.trim();
        if (!validarNome(nome)) {
            mensagemErroNome.textContent = 'Seu nome deve conter apenas letras.';
            nomeInput.setCustomValidity('Seu nome deve conter apenas letras.');
        } else {
            mensagemErroNome.textContent = '';
            nomeInput.setCustomValidity('');
        }
        nomeInput.value = capitalizeWords(nome);
    });

    function validarSobrenome(sobrenome) {
        const regex = /^[a-zA-Zà-úÀ-Ú]{2,}(?: [a-zA-Zà-úÀ-Ú]{2,})*$/;
        return regex.test(sobrenome);
    }

    sobrenomeInput.addEventListener('input', function() {
        const sobrenome = sobrenomeInput.value.trim();
        if (sobrenome.endsWith(" ")) {
            mensagemErroSobrenome.textContent = '';
            sobrenomeInput.setCustomValidity('');
            return;
        }
        if (!validarSobrenome(sobrenome)) {
            mensagemErroSobrenome.textContent = 'Sobrenome deve estar completo.';
            sobrenomeInput.setCustomValidity('Escreva seu sobrenome completo.');
        } else {
            mensagemErroSobrenome.textContent = '';
            sobrenomeInput.setCustomValidity('');
        }
        sobrenomeInput.value = capitalizeWords(sobrenome);
    });

    function validarEmailsIguais() {
        if (emailInput.value !== confirmarEmailInput.value) {
            mensagemErroEmailDiferente.textContent = 'Os emails não coincidem.';
            confirmarEmailInput.setCustomValidity('Os emails não coincidem.');
        } else {
            mensagemErroEmailDiferente.textContent = '';
            confirmarEmailInput.setCustomValidity('');
        }
    }

    emailInput.addEventListener('input', validarEmailsIguais);
    confirmarEmailInput.addEventListener('input', validarEmailsIguais);

    function validarSenhasIguais() {
        if (senhaInput.value !== confirmarSenhaInput.value) {
            mensagemErroSenhaDiferente.textContent = 'As senhas não coincidem.';
            confirmarSenhaInput.setCustomValidity('As senhas não coincidem.');
        } else {
            mensagemErroSenhaDiferente.textContent = '';
            confirmarSenhaInput.setCustomValidity('');
        }
    }

    senhaInput.addEventListener('input', validarSenhasIguais);
    confirmarSenhaInput.addEventListener('input', validarSenhasIguais);

    function validarFormulario() {
        if (!validarNome(nomeInput.value)) {
            alert('Nome inválido.');
            return false;
        }

        if (!validarSobrenome(sobrenomeInput.value)) {
            alert('Sobrenome inválido.');
            return false;
        }

        if (emailInput.value !== confirmarEmailInput.value) {
            alert('Os emails não coincidem.');
            return false;
        }

        if (senhaInput.value !== confirmarSenhaInput.value) {
            alert('As senhas não coincidem.');
            return false;
        }

        return true;
    }
});