let cartItemCount = 0; // Variável para contar os itens

// Função para adicionar um item ao carrinho
function CartFromModal() {
    const cartItemsList = document.getElementById('cartItemsList');
    const cartItems = [];
    let totalItems = 0;
    let totalAmount = 0;

    // Coleta os dados do produto do modal
    const idElement = document.getElementById('modalId');
    if (!idElement || !idElement.value) {
        console.error('ID do produto não encontrado no modal. Carrinho não será atualizado.');
        // Caso o ID não esteja presente, não exibe o carrinho e retorna
        document.getElementById('cartAside').style.display = 'none';
        return; // Interrompe a função
    }

    const produtoId = idElement.value;
    const nomeProduto = document.getElementById('modalNome').textContent;
    const precoProduto = parseFloat(document.getElementById('modalPreco').textContent.replace('R$', '').replace(',', '.'));
    const quantidadeProduto = parseInt(document.getElementById('modalQuantidade').textContent);

    // Criando o objeto com os dados do produto
    const produto = {
        id: produtoId, // ID do produto
        name: nomeProduto, // nome do produto
        price: precoProduto, // preço unitário
        quantity: quantidadeProduto, // quantidade
        total: precoProduto * quantidadeProduto // total do item (preço * quantidade)
    };

    console.log("Objeto dos dados do produto:", produto);

    // Adiciona o novo produto ao carrinho (se já existir no carrinho, apenas atualiza a quantidade)
    const items = cartItemsList.getElementsByClassName('cart-item');
    let productExists = false;
    for (let item of items) {
        const existingProductId = item.getAttribute('data-id');
        if (existingProductId === produto.id) {
            const quantityElement = item.querySelector('.item-quantity-number');
            const newQuantity = parseInt(quantityElement.textContent.trim()) + produto.quantity;
            quantityElement.textContent = newQuantity;

            // Atualiza o total do item
            const totalElement = item.querySelector('.item-total');
            totalElement.textContent = 'Total: R$ ' + (precoProduto * newQuantity).toFixed(2).replace('.', ',');

            productExists = true;
            break;
        }
    }

    // Se o produto não existe no carrinho, adiciona-o como um novo item
    if (!productExists) {
        cartItems.push(produto);
    }

    // Atualiza os totais
    for (let item of items) {
        const quantity = parseInt(item.querySelector('.item-quantity-number').textContent.trim());
        const total = parseFloat(item.querySelector('.item-total').textContent.replace('Total: R$ ', '').replace(',', '.'));

        totalItems += quantity;
        totalAmount += total;
    }

    // Verifica se o carrinho não está vazio
    if (cartItems.length === 0) {
        console.error('Carrinho vazio');
        return;
    }

    // Envia os dados para o PHP via AJAX
    fetch('http://localhost/Serv-Cuscuz/Serv+Cuscuz/view/cliente/salvarCarrinhoSessao.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ cart: cartItems, totalItems: totalItems, totalAmount: totalAmount }) // Envia os totais também
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Carrinho salvo na sessão com sucesso!');
        } else {
            console.error('Erro ao salvar carrinho na sessão:', data.message);
        }

        // Atualiza a interface do carrinho
        atualizarCarrinho(data);
        // Fecha o modal após adicionar o produto
        closeModal();
    })
    .catch(error => {
        console.error('Erro na requisição AJAX:', error);
    });
}

// Função para atualizar o carrinho na interface
function atualizarCarrinho(data) {
    const cartItemsList = document.getElementById('cartItemsList');
    const cartTotalAmount = document.getElementById('cartTotalAmount');
    const cartItemCountElement = document.getElementById('cartItemCount');

    // Atualiza a contagem de itens no carrinho
    let cartItemCount = data.totalItems;
    cartItemCountElement.textContent = cartItemCount;

    // Atualiza o total no carrinho
    cartTotalAmount.textContent = 'R$ ' + data.totalAmount.toFixed(2).replace('.', ',');

    // Atualiza o badge de contagem de itens
    const cartItemCountBadge = document.getElementById('cartItemCountBadge');
    cartItemCountBadge.textContent = cartItemCount;
    cartItemCountBadge.style.display = cartItemCount > 0 ? 'flex' : 'none';

    // Garante que o aside do carrinho fique visível
    document.getElementById('cartAside').style.display = 'block';
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
        const price = originalPrice
        const quantity = parseInt(item.querySelector('.item-quantity-number').textContent);
        const total = parseFloat(item.querySelector('.item-total').textContent.replace('Total: R$', '').replace(',', '.'));

        cartItems.push({
            id,
            name,
            price,
            quantity,
            total
        });
    });

    console.log("Dados do carrinho para envio:", { cartItems, cartTotalAmount });

    // Envia os dados para o servidor via POST
    fetch('http://localhost/Serv-Cuscuz/Serv+Cuscuz/view/cliente/finalizarPedido.php', {
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
                window.location.href = 'http://localhost/Serv-Cuscuz/Serv+Cuscuz/view/cliente/finalizarPedido.php';
            } else {
                console.error("Erro ao finalizar a compra:", data.message);
            }
        })
        .catch(error => {
            console.error("Erro ao enviar os dados para o servidor:", error);
        });
       
}

// Script para controlar o modal
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('customEmptyCartModal');
    const closeButton = document.querySelector('.custom-close-button');
    const closeModalBtn = document.querySelector('.custom-close-modal-btn');

    // Fecha o modal ao clicar nos botões
    closeButton.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    closeModalBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Fecha o modal ao clicar fora do conteúdo
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});

// Atualiza o carrinho na interface
function atualizarCarrinhoNaInterface(cart) {
    const cartItemsList = document.getElementById('cartItemsList');
    const cartTotalAmount = document.getElementById('cartTotalAmount');
    const cartItemCountBadge = document.getElementById('cartItemCountBadge');

    // Limpa o carrinho atual
    cartItemsList.innerHTML = '';

    let totalItems = 0;
    let totalAmount = 0;

    // Adiciona os produtos do carrinho
    for (const produtoId in cart) {
        const produto = cart[produtoId];
        totalItems += produto.quantity;
        totalAmount += produto.total;

        const itemHTML = `
            <li class="cart-item" data-id="${produto.id}">
                <span>${produto.name}</span>
                <span>R$ ${produto.price.toFixed(2).replace('.', ',')}</span>
                <span>Qtd: ${produto.quantity}</span>
                <span>Total: R$ ${produto.total.toFixed(2).replace('.', ',')}</span>
            </li>
        `;
        cartItemsList.insertAdjacentHTML('beforeend', itemHTML);
    }

    // Atualiza os totais
    cartTotalAmount.textContent = `R$ ${totalAmount.toFixed(2).replace('.', ',')}`;
    cartItemCountBadge.textContent = totalItems;
    cartItemCountBadge.style.display = totalItems > 0 ? 'flex' : 'none';
}