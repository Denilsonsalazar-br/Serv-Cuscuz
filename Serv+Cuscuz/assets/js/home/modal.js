let originalPrice = 0;
let currentProductId = 0; // Variável para armazenar o ID do produto
function openModal(nome, descricao, preco, imagemSrc, id) {

    //console.log("ID do produto no openModal:", id); 
    //console.log("nome do produto no openModal:", nome);
    //console.log("descrição do produto no openModal:", descricao);
    //console.log("imagem do produto no openModal:", imagemSrc);
    //console.log("preço do produto no openModal:", preco);

    // Define os valores no modal
    document.getElementById('modalNome').textContent = nome;
    document.getElementById('modalDescricao').innerHTML = descricao;
    document.getElementById('modalImagem').src = imagemSrc;

    // Armazena o ID do produto no modal
    currentProductId = id;
    document.getElementById('modalId').value = id; // Coloca o ID no campo oculto

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