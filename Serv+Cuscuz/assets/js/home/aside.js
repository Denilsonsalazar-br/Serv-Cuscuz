let cartItemCount = 0;  // Variável para contar os itens

// Função para adicionar um item ao carrinho
function addToCartFromModal() {
    const name = document.getElementById('modalNome').textContent;
    const quantity = parseInt(document.getElementById('modalQuantidade').textContent);
    const price = originalPrice;
    const totalAmount = price * quantity;

    const cartItemsList = document.getElementById('cartItemsList');
    const cartTotalAmount = document.getElementById('cartTotalAmount');
    const cartItemCountElement = document.getElementById('cartItemCount');

    // Verifica se o item já existe no carrinho
    let existingCartItem = Array.from(cartItemsList.getElementsByClassName('cart-item'))
        .find(item => item.querySelector('.item-name').textContent === name);

    if (existingCartItem) {
        // Se o item já estiver no carrinho, aumenta a quantidade e o total
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
        cartItem.innerHTML = `
            <span class="cart-item-details">
                <span class="item-name">${name}</span>
                <span class="item-quantity">Quantidade: 
                    <span class="item-quantity-number">${quantity}</span>
                </span>
                <span class="item-total">Total: R$ ${totalAmount.toFixed(2).replace('.', ',')}</span>
            </span>
            <button class="remove-item-btn" onclick="removeFromCart(this, ${price})">Remover</button>
        `;
        cartItemsList.appendChild(cartItem);
    }

    // Atualiza o valor total do carrinho
    let currentTotal = parseFloat(cartTotalAmount.textContent.replace('R$', '').replace(',', '.'));
    currentTotal += totalAmount;
    cartTotalAmount.textContent = `R$ ${currentTotal.toFixed(2).replace('.', ',')}`;

    // Atualiza o contador de itens
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

// Função para remover um item do carrinho
function removeFromCart(button, itemPrice) {
    const cartItem = button.closest('.cart-item');
    const quantityElement = cartItem.querySelector('.item-quantity-number');
    const quantity = parseInt(quantityElement.textContent);
    const totalAmount = itemPrice * quantity;

    const cartItemsList = document.getElementById('cartItemsList');
    const cartTotalAmount = document.getElementById('cartTotalAmount');
    const cartItemCountElement = document.getElementById('cartItemCount');

    // Remover o item da lista
    cartItemsList.removeChild(cartItem);

    // Atualiza o valor total do carrinho
    let currentTotal = parseFloat(cartTotalAmount.textContent.replace('R$', '').replace(',', '.'));
    currentTotal -= totalAmount;
    cartTotalAmount.textContent = `R$ ${currentTotal.toFixed(2).replace('.', ',')}`;

    // Atualiza o contador de itens
    cartItemCount -= quantity;
    cartItemCountElement.textContent = cartItemCount;

    // Atualiza o badge de contagem de itens
    const cartItemCountBadge = document.getElementById('cartItemCountBadge');
    cartItemCountBadge.textContent = cartItemCount;
    cartItemCountBadge.style.display = cartItemCount > 0 ? 'flex' : 'none';

    // Se o carrinho estiver vazio, oculta o aside
    if (cartItemCount === 0) {
        document.getElementById('cartAside').style.display = 'none';
    }
}

// Função para alternar a visibilidade do carrinho
function toggleCartVisibility() {
    const cartAside = document.getElementById('cartAside');
    cartAside.style.display = (cartAside.style.display === 'none' || cartAside.style.display === '') 
        ? 'block' 
        : 'none';
}
