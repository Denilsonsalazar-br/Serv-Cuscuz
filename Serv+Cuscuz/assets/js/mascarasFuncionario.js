document.addEventListener("DOMContentLoaded", function () {
    const nomeCompletoInput = document.getElementById('nomeCompleto');
    const cpfInput = document.getElementById('cpf');
    const telefoneInput = document.getElementById('telefone');
    const emailInput = document.getElementById('email');
    const confirmarEmailInput = document.getElementById('confirmarEmail');
    const senhaInput = document.getElementById('senha');
    const confirmarSenhaInput = document.getElementById('confirmarSenha');

    const mensagemErroNomeCompleto = document.getElementById('mensagemErroNomeCompleto');
    const mensagemErroEmailDiferente = document.getElementById('mensagemErroEmailDiferente');
    const mensagemErroSenhaDiferente = document.getElementById('mensagemErroSenhaDiferente');

    // Função de máscara para CPF
    function maskCPF(value) {
        return value.replace(/\D/g, '')
                    .replace(/(\d{3})(\d)/, '$1.$2')
                    .replace(/(\d{3})(\d)/, '$1.$2')
                    .replace(/(\d{3})(\d{1,2})$/, '$1-$2')
                    .slice(0, 14);
    }

    // Função de máscara para telefone
    function maskTelefone(value) {
        return value.replace(/\D/g, '')
                    .replace(/^(\d{2})(\d)/, '($1) $2')
                    .replace(/(\d{5})(\d)/, '$1-$2')
                    .slice(0, 15);
    }

    // Aplicar máscara de CPF
    cpfInput.addEventListener('input', function () {
        this.value = maskCPF(this.value);
    });

    // Aplicar máscara de telefone
    telefoneInput.addEventListener('input', function () {
        this.value = maskTelefone(this.value);
    });

    // Impedir entrada de números no campo de nome completo
    nomeCompletoInput.addEventListener('keypress', function (event) {
        const char = String.fromCharCode(event.which);
        if (!/[a-zA-Zà-úÀ-Ú\s]/.test(char)) {
            event.preventDefault();
        }
    });

    // Validação e formatação do nome completo
    function validarNomeCompleto(nomeCompleto) {
        const regex = /^[a-zA-Zà-úÀ-Ú\s]+$/; // Permitir letras e espaços
        return regex.test(nomeCompleto);
    }

    function capitalizeWords(text) {
        return text.replace(/\b\w/g, char => char.toUpperCase());
    }

    nomeCompletoInput.addEventListener('input', function () {
        const nomeCompleto = nomeCompletoInput.value.trim();

        if (!validarNomeCompleto(nomeCompleto)) {
            mensagemErroNomeCompleto.textContent = 'O nome completo deve conter apenas letras e espaços.';
            nomeCompletoInput.setCustomValidity('O nome completo deve conter apenas letras e espaços.');
        } else {
            mensagemErroNomeCompleto.textContent = '';
            nomeCompletoInput.setCustomValidity('');
        }
        
        nomeCompletoInput.value = capitalizeWords(nomeCompleto);
    });

    // Validação para e-mails iguais
    function removerEspacosEmail(email) {
        return email.replace(/\s/g, ''); // Remove espaços em branco
    }
    
    function validarEmailsIguais() {
        if (emailInput.value !== confirmarEmailInput.value) {
            mensagemErroEmailDiferente.textContent = 'Os emails não coincidem.';
            confirmarEmailInput.setCustomValidity('Os emails não coincidem.');
        } else {
            mensagemErroEmailDiferente.textContent = '';
            confirmarEmailInput.setCustomValidity('');
        }
    }

    emailInput.addEventListener('input', function () {
        emailInput.value = removerEspacosEmail(emailInput.value);
        validarEmailsIguais();
    });

    confirmarEmailInput.addEventListener('input', function () {
        confirmarEmailInput.value = removerEspacosEmail(confirmarEmailInput.value);
        validarEmailsIguais();
    });

    // Validação para senhas iguais
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

    // Validação final do formulário
    function validarFormulario() {
        if (!validarNomeCompleto(nomeCompletoInput.value)) {
            alert('Nome completo inválido.');
            nomeCompletoInput.focus();
            return false;
        }

        if (emailInput.value !== confirmarEmailInput.value) {
            alert('Os emails não coincidem.');
            confirmarEmailInput.focus();
            return false;
        }

        if (senhaInput.value !== confirmarSenhaInput.value) {
            alert('As senhas não coincidem.');
            confirmarSenhaInput.focus();
            return false;
        }

        return true; // Se tudo estiver correto, o formulário será enviado
    }
});