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