document.addEventListener("DOMContentLoaded", function () {
    const nomeInput = document.getElementById('nome');
    const sobrenomeInput = document.getElementById('sobrenome');
    const cpfInput = document.getElementById('cpf');
    const telefoneInput = document.getElementById('telefone');
    const emailInput = document.getElementById('email');
    const confirmarEmailInput = document.getElementById('confirmarEmail');
    const senhaInput = document.getElementById('senha');
    const confirmarSenhaInput = document.getElementById('confirmarSenha');

    const mensagemErroSobrenome = document.getElementById('mensagemErroSobrenome');
    const mensagemErroNome = document.getElementById('mensagemErroNome');
    const mensagemErroEmailDiferente = document.getElementById('mensagemErroEmailDiferente');
    const mensagemErroSenhaDiferente = document.getElementById('mensagemErroSenhaDiferente');

    // Função de máscara para CPF
    function maskCPF(value) {
        value = value.replace(/\D/g, '');
        if (value.length > 11) value = value.slice(0, 11);
        return value.replace(/(\d{3})(\d)/, '$1.$2')
                    .replace(/(\d{3})(\d)/, '$1.$2')
                    .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    }

    // Função de máscara para telefone
    function maskTelefone(value) {
        return value.replace(/\D/g, '')
                    .replace(/^(\d{2})(\d)/, '($1) $2')
                    .replace(/(\d{5})(\d)/, '$1-$2');
    }

    // Aplicar máscara de CPF
    cpfInput.addEventListener('input', function () {
        this.value = maskCPF(this.value);
    });

    // Aplicar máscara de telefone
    telefoneInput.addEventListener('input', function () {
        this.value = maskTelefone(this.value);
    });

    // Função para capitalizar as palavras
    function capitalizeWords(text) {
        return text.replace(/\b\w/g, char => char.toUpperCase());
    }

    // Validação de nome
    function validarNome(nome) {
        const regex = /^[a-zA-Zà-úÀ-Ú\s]+$/;
        return regex.test(nome);
    }

    // Validação de nome ao digitar
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
        const regex = /^[a-zA-Zà-úÀ-Ú\s]+$/; // Permitir letras e espaços
        return regex.test(sobrenome);
    }
    
    // Validação de sobrenome ao digitar
    sobrenomeInput.addEventListener('input', function() {
        const sobrenome = sobrenomeInput.value;
    
        // Não interrompe o usuário ao digitar espaços entre palavras
        if (!validarSobrenome(sobrenome)) {
            mensagemErroSobrenome.textContent = 'Sobrenome deve estar completo e conter apenas letras e espaços entre palavras.';
            sobrenomeInput.setCustomValidity('Escreva seu sobrenome completo.');
        } else {
            mensagemErroSobrenome.textContent = '';
            sobrenomeInput.setCustomValidity('');
        }
    });
    
    // Capitalização das palavras após perder o foco no campo
    sobrenomeInput.addEventListener('blur', function() {
        sobrenomeInput.value = capitalizeWords(sobrenomeInput.value.trim());
    });
    
    function capitalizeWords(text) {
        return text.replace(/\b\w/g, char => char.toUpperCase());
    }

    function removerEspacosEmail(email) {
        return email.replace(/\s/g, ''); // Remove todos os espaços em branco
    }
    
    // Validação do campo de email para não aceitar espaços
    emailInput.addEventListener('input', function() {
        emailInput.value = removerEspacosEmail(emailInput.value);
        validarEmailsIguais(); // Chama a função de validação para verificar igualdade entre emails
    });
    
    // Validação do campo de confirmar email para não aceitar espaços
    confirmarEmailInput.addEventListener('input', function() {
        confirmarEmailInput.value = removerEspacosEmail(confirmarEmailInput.value);
        validarEmailsIguais(); // Chama a função de validação para verificar igualdade entre emails
    });

    // Validação de emails iguais
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

    // Validação de senhas iguais
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

    // Validação final no envio do formulário
    function validarFormulario() {
        if (!validarNome(nomeInput.value)) {
            alert('Nome inválido.');
            nomeInput.focus(); // Força o foco no campo inválido
            return false;
        }

        if (!validarSobrenome(sobrenomeInput.value)) {
            alert('Sobrenome inválido.');
            sobrenomeInput.focus(); // Força o foco no campo inválido
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