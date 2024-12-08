let cartItemCount = 0; // Variável para contar os itens

// TODO ALTERADO APAGUEI CartFromModal e atualizarCarrinho

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
    cartItemCountElement.textContent = newCartItemCount;

    // Atualiza o badge de contagem de itens
    const cartItemCountBadge = document.getElementById('cartItemCountBadge');
    cartItemCountBadge.textContent = newCartItemCount;
    cartItemCountBadge.style.display = newCartItemCount > 0 ? 'flex' : 'none';

    // Atualiza a sessão com o carrinho atualizado
    saveCartToSession();

    // Oculta o carrinho se estiver vazio
    if (newCartItemCount === 0) {
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

// TODO ALTERADO para calcular o total do carrinho
function addToCartFromModal() {
    const id = document.getElementById('modalId').value;  // Obtém o ID do produto
    const name = document.getElementById('modalNome').textContent;

    // Obtém o preço unitário do atributo `data-preco-unitario`
    const unitPrice = parseFloat(document.getElementById('modalPreco').getAttribute('data-preco-unitario'));
    const quantity = parseInt(document.getElementById('modalQuantidade').textContent);

    if (isNaN(unitPrice) || isNaN(quantity)) {
        console.error('Erro: Preço ou quantidade inválidos.', { unitPrice, quantity });
        return;
    }

    const totalAmount = unitPrice * quantity;

    // Atualiza o carrinho
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
        const newTotal = unitPrice * newQuantity;
        itemTotalElement.textContent = `Total: R$ ${newTotal.toFixed(2).replace('.', ',')}`;
    } else {
        // Adiciona o novo item ao carrinho
        const cartItem = document.createElement('li');
        cartItem.className = 'cart-item';
        cartItem.dataset.id = id;
        cartItem.innerHTML = `
            <span class="cart-item-details">
                <span class="item-name">${name}</span>
                <span class="item-quantity">Quantidade: 
                    <span class="item-quantity-number">${quantity}</span>
                </span>
                <span class="item-total">Total: R$ ${totalAmount.toFixed(2).replace('.', ',')}</span>
            </span>
            <button class="remove-item-btn" onclick="removeFromCart(this, ${unitPrice}, ${id})">Remover</button>
        `;
        cartItemsList.appendChild(cartItem);
    }

    // Atualiza o valor total do carrinho
    let currentTotal = 0; // Reinicia o total para recalcular
    Array.from(cartItemsList.getElementsByClassName('cart-item')).forEach(item => {
        const itemTotal = parseFloat(
            item.querySelector('.item-total')
                .textContent.replace('Total: R$ ', '')
                .replace(',', '.')
        );
        currentTotal += itemTotal;
    });
    cartTotalAmount.textContent = `R$ ${currentTotal.toFixed(2).replace('.', ',')}`;

    // Atualiza o contador de itens
    let cartItemCount = parseInt(cartItemCountElement.textContent) || 0;
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

// TODO ALTERADO para pegar o preco unitario do produto
function finalizarPedido() {
    const cartItemsList = document.getElementById('cartItemsList');
    const cartItems = [];
    const cartTotalAmount = document.getElementById('cartTotalAmount').textContent;

    // Verifica se o carrinho está vazio
    if (cartItemsList.children.length === 0) {
        const modal = document.getElementById('customEmptyCartModal');
        modal.style.display = 'flex'; // Exibe o modal
        return; // Impede o avanço
    }

    // Coleta os dados do carrinho
    Array.from(cartItemsList.getElementsByClassName('cart-item')).forEach(item => {
        const id = item.dataset.id;
        const name = item.querySelector('.item-name').textContent;

        // Atualiza para obter o preço unitário do item
        const itemTotal = parseFloat(
            item.querySelector('.item-total').textContent.replace('Total: R$', '').replace(',', '.')
        );
        const quantity = parseInt(item.querySelector('.item-quantity-number').textContent);
        const price = itemTotal / quantity; // Calcula o preço unitário a partir do total e quantidade

        cartItems.push({
            id,
            name,
            price: parseFloat(price.toFixed(2)), // Armazena o preço unitário correto
            quantity,
            total: parseFloat(itemTotal.toFixed(2)) // Armazena o total do item
        });
    });

    console.log("Dados do carrinho para envio:", { cartItems, cartTotalAmount });

    // TODO VOLTAR URL
    const url_base = 'http://localhost/Serv-Cuscuz/Serv+Cuscuz/view/cliente/finalizarPedido.php';

    // Envia os dados para o servidor via POST
    fetch(url_base, {
        method: 'POST',
        credentials: 'include',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            cartItems,
            cartTotalAmount,
        }),
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erro HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                console.log("Compra finalizada com sucesso:", data);
                // Redireciona ou exibe mensagem de sucesso
                window.location.href = url_base;
            } else {
                console.error("Erro ao finalizar a compra:", data.message);
            }
        })
        .catch(error => {
            console.error("Erro ao enviar os dados para o servidor:", error);
        });
}

// Script para controlar o modal
document.addEventListener('DOMContentLoaded', function () {
    if (typeof cartItems !== 'undefined' && cartItems.length > 0) {
        const cartItemsList = document.getElementById('cartItemsList');
        const cartTotalElement = document.getElementById('cartTotalAmount');
        const cartItemCountElement = document.getElementById('cartItemCount');
        const cartItemCountBadge = document.getElementById('cartItemCountBadge');
        let totalItems = 0;
        let totalAmount = 0;

        cartItemsList.innerHTML = ''; // Limpa os itens do carrinho no DOM

        cartItems.forEach(item => {
            const cartItem = document.createElement('li');
            cartItem.className = 'cart-item';
            cartItem.dataset.id = item.id;
            cartItem.innerHTML = `
                <span class="cart-item-details">
                    <span class="item-name">${item.name}</span>
                    <span class="item-quantity">Quantidade: 
                        <span class="item-quantity-number">${item.quantity}</span>
                    </span>
                    <span class="item-total">Total: R$ ${item.total.toFixed(2).replace('.', ',')}</span>
                </span>
                <button class="remove-item-btn" onclick="removeFromCart(this, ${item.price}, ${item.id})">Remover</button>
            `;
            cartItemsList.appendChild(cartItem);

            totalItems += item.quantity;
            totalAmount += item.total; // Soma o total de cada item
        });

        cartTotalElement.textContent = `R$ ${totalAmount.toFixed(2).replace('.', ',')}`;
        cartItemCountElement.textContent = totalItems;
        cartItemCountBadge.textContent = totalItems;
        cartItemCountBadge.style.display = totalItems > 0 ? 'flex' : 'none';
    } else {
        console.warn('Nenhum item no carrinho.');
    }
});