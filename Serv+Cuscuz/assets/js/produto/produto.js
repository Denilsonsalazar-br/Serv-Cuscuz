// Aguarda o carregamento completo do DOM antes de executar o código
document.addEventListener('DOMContentLoaded', function() {
    // Seleciona o checkbox de "personalizável" usando o ID 'personalizavel'
    const personalizavelCheckbox = document.getElementById('personalizavel');
    
    // Seleciona os campos de personalização usando a classe 'personalizacao-fields'
    const personalizacaoFields = document.querySelector('.personalizacao-fields');

    // Adiciona um ouvinte de evento para o checkbox, que dispara sempre que o estado do checkbox muda
    personalizavelCheckbox.addEventListener('change', function() {
        // Verifica se o checkbox está marcado (valor 'checked' é verdadeiro)
        if (this.checked) {
            // Se o checkbox estiver marcado, adiciona a classe 'active' aos campos de personalização,
            // fazendo com que eles fiquem visíveis (dependendo do CSS)
            personalizacaoFields.classList.add('active');
        } else {
            // Se o checkbox não estiver marcado, remove a classe 'active',
            // fazendo com que os campos de personalização sejam ocultados
            personalizacaoFields.classList.remove('active');
        }
    });
});
