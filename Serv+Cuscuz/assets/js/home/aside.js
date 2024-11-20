let cartItemCount = 0;  // Variável para contar os itens


// Função para adicionar um item ao carrinho
function addToCartFromModal() {
    const id = document.getElementById('modalId').value;// Obtém o ID do produto atual
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
        cartItem.dataset.id = id; // Salva o ID no dataset do elemento
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
    cartItemCount += quantity;
    cartItemCountElement.textContent = cartItemCount;

    // Atualiza o badge de contagem de itens
    const cartItemCountBadge = document.getElementById('cartItemCountBadge');
    cartItemCountBadge.textContent = cartItemCount;
    cartItemCountBadge.style.display = cartItemCount > 0 ? 'flex' : 'none';

    // Garante que o aside do carrinho fique visível
    document.getElementById('cartAside').style.display = 'block';

    // Salva o carrinho na sessão
    saveCartToSession();

    // Fecha o modal (se aplicável)
    closeModal();
    
}


// Função para salvar o carrinho na sessão
function saveCartToSession() {
    const cartItemsList = document.getElementById('cartItemsList');
    const cartItems = [];

    // Obtém os itens do carrinho
    const items = cartItemsList.getElementsByClassName('cart-item');
    for (let item of items) {
        const name = item.querySelector('.item-name').textContent.trim();
        const quantity = parseInt(item.querySelector('.item-quantity-number').textContent.trim());
        const total = parseFloat(item.querySelector('.item-total').textContent.replace('Total: R$ ', '').replace(',', '.'));

        // Adiciona os itens ao array
        cartItems.push({ name: name, quantity: quantity, total: total });
    }

    // Verifica se o carrinho não está vazio
    if (cartItems.length === 0) {
        console.error('Carrinho vazio');
        return;
    }

    // Envia os dados para o PHP via AJAX
    fetch('../../view/cliente/salvarCarrinhoSessao.php', {
        method: 'POST',  // Certifica-se de que o método é POST
        headers: {
            'Content-Type': 'application/json'  // Define o tipo de conteúdo como JSON
        },
        body: JSON.stringify({ cart: cartItems })  // Envia os itens do carrinho como JSON
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Carrinho salvo na sessão com sucesso!');
        } else {
            console.error('Erro ao salvar carrinho na sessão:', data.message);
        }
    })
    .catch(error => {
        console.error('Erro na requisição AJAX:', error);
    });
}

// Função para remover um item do carrinho
function removeFromCart(button, itemPrice, id) {
    const cartItem = button.closest('.cart-item');
    const quantityElement = cartItem.querySelector('.item-quantity-number');
    const quantity = parseInt(quantityElement.textContent);
    const totalAmount = itemPrice * quantity;

    const cartItemsList = document.getElementById('cartItemsList');
    const cartTotalAmount = document.getElementById('cartTotalAmount');
    const cartItemCountElement = document.getElementById('cartItemCount');

    // Remove o item do carrinho
    cartItemsList.removeChild(cartItem);

    // Atualiza o total do carrinho
    let currentTotal = parseFloat(cartTotalAmount.textContent.replace('R$', '').replace(',', '.'));
    currentTotal -= totalAmount;
    cartTotalAmount.textContent = `R$ ${Math.max(0, currentTotal).toFixed(2).replace('.', ',')}`;

    // Recalcula a contagem total de itens no carrinho
    const remainingItems = cartItemsList.getElementsByClassName('cart-item');
    let newCartItemCount = 0;
    for (let item of remainingItems) {
        const itemQuantity = parseInt(item.querySelector('.item-quantity-number').textContent);
        newCartItemCount += itemQuantity;
    }
    cartItemCount = newCartItemCount;
    cartItemCountElement.textContent = cartItemCount;

    // Atualiza o badge de contagem de itens
    const cartItemCountBadge = document.getElementById('cartItemCountBadge');
    cartItemCountBadge.textContent = cartItemCount;
    cartItemCountBadge.style.display = cartItemCount > 0 ? 'flex' : 'none';

    // Atualiza a sessão com o carrinho atualizado
    saveCartToSession();

    // Oculta o carrinho se estiver vazio
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