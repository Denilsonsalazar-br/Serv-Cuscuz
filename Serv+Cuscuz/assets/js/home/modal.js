let originalPrice = 0;

function openModal(nome, descricao, preco, imagemSrc) {
    document.getElementById('modalNome').textContent = nome;
    document.getElementById('modalDescricao').textContent = descricao;
    document.getElementById('modalImagem').src = imagemSrc;

    // Analisa o preço e define no modal
    originalPrice = parseFloat(preco.replace(',', '.'));
    document.getElementById('modalPreco').textContent = `R$ ${originalPrice.toFixed(2).replace('.', ',')}`;
    document.getElementById('modalQuantidade').textContent = 1;

    // Exibe o modal
    document.getElementById('produtoModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('produtoModal').style.display = 'none';
}

// Função para fechar o modal ao clicar fora do conteúdo
function closeModalOnOutsideClick(event) {
    const modal = document.getElementById('produtoModal');
    if (event.target === modal) { // Verifica se o clique foi no modal de fundo
        closeModal();
    }
}

function updateQuantity(change) {
    const quantityElement = document.getElementById('modalQuantidade');
    let quantity = parseInt(quantityElement.textContent);

    // Atualiza a quantidade e impede que ela fique abaixo de 1
    quantity = Math.max(1, quantity + change);
    quantityElement.textContent = quantity;

    // Atualiza o preço total com base na quantidade
    const totalPrice = originalPrice * quantity;
    document.getElementById('modalPreco').textContent = `R$ ${totalPrice.toFixed(2).replace('.', ',')}`;
}

// Adiciona um evento de clique para fechar o modal ao clicar fora do conteúdo
document.getElementById('produtoModal').addEventListener('click', closeModalOnOutsideClick);

let lastFocusedElement; // Para guardar o elemento que estava com foco antes de abrir o modal

function openModal(nome, descricao, preco, imagemSrc) {
    // Guarda o elemento atualmente focado
    lastFocusedElement = document.activeElement;

    // Define o conteúdo do modal
    document.getElementById('modalNome').textContent = nome;
    document.getElementById('modalDescricao').textContent = descricao;
    document.getElementById('modalImagem').src = imagemSrc;
    
    originalPrice = parseFloat(preco.replace(',', '.'));
    document.getElementById('modalPreco').textContent = `R$ ${originalPrice.toFixed(2).replace('.', ',')}`;
    document.getElementById('modalQuantidade').textContent = 1;

    // Exibe o modal
    const modal = document.getElementById('produtoModal');
    modal.style.display = 'flex';

    // Move o foco para o modal
    modal.setAttribute('tabindex', '-1');
    modal.focus();
}

function closeModal() {
    // Oculta o modal
    document.getElementById('produtoModal').style.display = 'none';

    // Retorna o foco ao elemento anterior
    if (lastFocusedElement) {
        lastFocusedElement.focus();
    }
}

// Fechar o modal ao clicar fora do conteúdo
function closeModalOnOutsideClick(event) {
    const modal = document.getElementById('produtoModal');
    if (event.target === modal) {
        closeModal();
    }
}

// Configura evento para fechar o modal ao clicar fora do conteúdo
document.getElementById('produtoModal').addEventListener('click', closeModalOnOutsideClick);