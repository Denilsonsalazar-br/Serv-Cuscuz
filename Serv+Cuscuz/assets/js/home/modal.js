let originalPrice = 0;
let currentProductId = 0; // Variável para armazenar o ID do produto

// Função para adicionar o produto ao carrinho
function addToCartFromModal() {
    const id = document.getElementById('modalId').value;  // Obtém o ID do produto do campo oculto
    const name = document.getElementById('modalNome').textContent;
    const quantity = parseInt(document.getElementById('modalQuantidade').textContent);
    const price = originalPrice;
    const totalAmount = price * quantity;

    const cartItemsList = document.getElementById('cartItemsList');
    const cartTotalAmount = document.getElementById('cartTotalAmount');
    const cartItemCountElement = document.getElementById('cartItemCount');

    // Verifica se o item já existe no carrinho
    let existingCartItem = Array.from(cartItemsList.getElementsByClassName('cart-item'))
        .find(item => item.dataset.id === id.toString());

    if (existingCartItem) {
        // Atualiza a quantidade e o total do item existente
        const itemQuantityElement = existingCartItem.querySelector('.item-quantity-number');
        const newQuantity = parseInt(itemQuantityElement.textContent) + quantity;
        itemQuantityElement.textContent = newQuantity;

        const itemTotalElement = existingCartItem.querySelector('.item-total');
        const newTotal = price * newQuantity;
        itemTotalElement.textContent = `Total: R$ ${newTotal.toFixed(2).replace('.', ',')}`;
    } else {
        // Cria o item do carrinho se ele ainda não existir
        const cartItem = document.createElement('li');
        cartItem.className = 'cart-item';
        cartItem.dataset.id = id;  // Salva o ID no dataset do elemento
        cartItem.innerHTML = `
            <span class="cart-item-details">
                <span class="item-name">${name}</span>
                <span class="item-quantity">Quantidade: 
                    <span class="item-quantity-number">${quantity}</span>
                </span>
                <span class="item-total">Total: R$ ${totalAmount.toFixed(2).replace('.', ',')}</span>
            </span>
            <button class="remove-item-btn" onclick="removeFromCart(this, ${price}, ${id})">Remover</button>
        `;
        cartItemsList.appendChild(cartItem);
    }

    // Atualiza o valor total do carrinho
    let currentTotal = parseFloat(cartTotalAmount.textContent.replace('R$', '').replace(',', '.'));
    currentTotal += totalAmount;
    cartTotalAmount.textContent = `R$ ${currentTotal.toFixed(2).replace('.', ',')}`;

    // Atualiza o contador de itens
    let cartItemCount = parseInt(cartItemCountElement.textContent);
    cartItemCount += quantity;
    cartItemCountElement.textContent = cartItemCount;

    // Atualiza o badge de contagem de itens
    const cartItemCountBadge = document.getElementById('cartItemCountBadge');
    cartItemCountBadge.textContent = cartItemCount;
    cartItemCountBadge.style.display = cartItemCount > 0 ? 'flex' : 'none';

    // Garante que o aside do carrinho fique visível
    document.getElementById('cartAside').style.display = 'block';
    closeModal();
}

function openModal(nome, descricao, preco, imagemSrc, id) {

    //console.log("ID do produto no openModal:", id); 
    //console.log("nome do produto no openModal:", nome);
    //console.log("descrição do produto no openModal:", descricao);
    //console.log("imagem do produto no openModal:", imagemSrc);
    //console.log("preço do produto no openModal:", preco);

    // Define os valores no modal
    document.getElementById('modalNome').textContent = nome;
    document.getElementById('modalDescricao').textContent = descricao;
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