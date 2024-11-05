  document.addEventListener('DOMContentLoaded', function() {
        const personalizavelCheckbox = document.getElementById('personalizavel');
        const personalizacaoFields = document.querySelector('.personalizacao-fields');

        personalizavelCheckbox.addEventListener('change', function() {
            if (this.checked) {
                personalizacaoFields.classList.add('active');
            } else {
                personalizacaoFields.classList.remove('active');
            }
        });
    });

