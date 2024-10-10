document.addEventListener("DOMContentLoaded", function () {
  const cpfInput = document.getElementById('cpf');
  const telefoneInput = document.getElementById('telefone');
  const nomeInput = document.getElementById('nome');
  const sobrenomeInput = document.getElementById('sobrenome');

  const mensagemErroSobrenome = document.getElementById('mensagemErroSobrenome');
  const mensagemErroNome = document.getElementById('mensagemErroNome');

  // Função para aplicar a máscara de CPF no formato "###.###.###-##"
  function maskCPF(value) {
      value = value.replace(/\D/g, ''); // Remove tudo que não é dígito
      if (value.length > 11) {
          value = value.slice(0, 11);
      }
      return value
          .replace(/(\d{3})(\d)/, '$1.$2')
          .replace(/(\d{3})(\d)/, '$1.$2')
          .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
  }

  // Função para aplicar a máscara de telefone
  function maskTelefone(value) {
      return value
          .replace(/\D/g, '')
          .replace(/^(\d{2})(\d)/, '($1) $2')
          .replace(/(\d{5})(\d)/, '$1-$2');
  }

  // Adiciona evento de input para aplicar a máscara ao CPF
  cpfInput.addEventListener('input', function () {
      this.value = maskCPF(this.value);
  });

  // Adiciona evento de input para aplicar a máscara ao telefone
  telefoneInput.addEventListener('input', function () {
      this.value = maskTelefone(this.value);
  });

  // Função para formatar texto para capitalização
  function capitalizeWords(text) {
      return text.replace(/\b\w/g, char => char.toUpperCase());
  }

  // Função para validar o campo nome
  function validarNome(nome) {
      const regex = /^[a-zA-Zà-úÀ-Ú]+$/;
      return regex.test(nome);
  }

  // Event listener para o campo nome
  nomeInput.addEventListener('input', function() {
      const nome = nomeInput.value.trim();
      if (!validarNome(nome)) {
          mensagemErroNome.textContent = 'Seu nome deve conter apenas letras.';
          nomeInput.setCustomValidity('Seu nome deve conter apenas letras.');
      } else {
          mensagemErroNome.textContent = '';
          nomeInput.setCustomValidity('');
      }
      // Capitaliza a primeira letra de cada palavra
      nomeInput.value = capitalizeWords(nome);
  });

// Função para validar o campo sobrenome
function validarSobrenome(sobrenome) {
  const regex = /^[a-zA-Zà-úÀ-Ú]{2,}(?: [a-zA-Zà-úÀ-Ú]{2,})*$/;
  return regex.test(sobrenome);
}

// Event listener para o campo sobrenome
sobrenomeInput.addEventListener('input', function() {
  const sobrenome = sobrenomeInput.value;

  // Permite que o usuário digite o espaço
  if (sobrenome.endsWith(" ")) {
      mensagemErroSobrenome.textContent = ''; // Limpa a mensagem de erro ao digitar espaço
      sobrenomeInput.setCustomValidity('');
      return; // Não valida enquanto o usuário não digitar a segunda palavra
  }

  // Após digitar uma palavra ou mais, valida o sobrenome
  if (!validarSobrenome(sobrenome)) {
      mensagemErroSobrenome.textContent = 'Sobrenome deve estar completo.';
      sobrenomeInput.setCustomValidity('Escreva seu sobrenome completo.');
  } else {
      mensagemErroSobrenome.textContent = '';
      sobrenomeInput.setCustomValidity('');
  }

  // Capitaliza a primeira letra de cada palavra
  sobrenomeInput.value = capitalizeWords(sobrenome.trim());
});

});

// Função para verificar se os emails estão iguais no formulário
function validarFormulario() {
  const nomeInput = document.getElementById('nome');
  const sobrenomeInput = document.getElementById('sobrenome');

  // Chamar as funções de validação diretamente aqui
  if (!validarNome(nomeInput.value)) {
      alert('Nome inválido.');
      return false;
  }

  if (!validarSobrenome(sobrenomeInput.value)) {
      alert('Sobrenome inválido.');
      return false;
  }

  const email = document.getElementById('email').value;
  const confirmarEmail = document.getElementById('confirmarEmail').value;

  if (email !== confirmarEmail) {
      alert('Os emails não coincidem.');
      return false;
  }

  // Se tudo estiver correto, o formulário pode ser enviado
  return true;
}