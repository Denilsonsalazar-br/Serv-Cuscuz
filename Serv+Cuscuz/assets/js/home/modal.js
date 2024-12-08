let originalPrice = 0;
let currentProductId = 0; // Variável para armazenar o ID do produto

// TODO ALTERADO para pegar preco unitario do produto
function openModal(nome, descricao, preco, imagemSrc, id) {
    // Define os valores no modal
    document.getElementById('modalNome').textContent = nome;
    document.getElementById('modalDescricao').textContent = descricao;
    document.getElementById('modalImagem').src = imagemSrc;

    // Armazena o ID do produto no modal
    currentProductId = id;
    document.getElementById('modalId').value = id; // Coloca o ID no campo oculto

    // Define o preço unitário no atributo `data-preco-unitario` e exibe o preço total
    originalPrice = parseFloat(preco.replace(',', '.'));
    const modalPrecoElement = document.getElementById('modalPreco');
    modalPrecoElement.setAttribute('data-preco-unitario', originalPrice);
    modalPrecoElement.textContent = `R$ ${originalPrice.toFixed(2).replace('.', ',')}`;

    // Define a quantidade inicial
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

// TODO ALTERADO
function updateQuantity(change) {
    const quantityElement = document.getElementById('modalQuantidade');
    let quantity = parseInt(quantityElement.textContent);

    // Atualiza a quantidade e impede que ela fique abaixo de 1
    quantity = Math.max(1, quantity + change);
    quantityElement.textContent = quantity;

    // Recalcula o preço total com base no preço unitário e quantidade
    const modalPrecoElement = document.getElementById('modalPreco');
    const unitPrice = parseFloat(modalPrecoElement.getAttribute('data-preco-unitario'));
    const totalPrice = unitPrice * quantity;
    modalPrecoElement.textContent = `R$ ${totalPrice.toFixed(2).replace('.', ',')}`;
}

// Adiciona um evento de clique para fechar o modal ao clicar fora do conteúdo
document.getElementById('produtoModal').addEventListener('click', closeModalOnOutsideClick);