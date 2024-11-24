document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modalTermos');
    const abrirModal = document.getElementById('abrirModalTermos');
    const fecharModal = document.querySelector('.modal-termos-close');
    const aceitarTermosBtn = document.getElementById('aceitarTermos');
    const checkboxTermos = document.getElementById('termos');

    // Abre o modal ao clicar no link
    abrirModal.addEventListener('click', (e) => {
        e.preventDefault(); // Evita o redirecionamento
        modal.style.display = 'flex';
    });

    // Fecha o modal ao clicar no botão de fechar
    fecharModal.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Fecha o modal ao clicar fora do conteúdo
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Marca o checkbox automaticamente ao clicar em "Aceitar"
    aceitarTermosBtn.addEventListener('click', () => {
        checkboxTermos.checked = true;
        modal.style.display = 'none';
    });
});
