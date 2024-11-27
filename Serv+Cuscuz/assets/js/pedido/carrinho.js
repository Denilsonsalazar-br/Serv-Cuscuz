// carrinho.js

// Função para salvar o carrinho no localStorage
function salvarCarrinhoNoLocalStorage(carrinho) {
    localStorage.setItem('carrinho', JSON.stringify(carrinho));
}

// Função para carregar o carrinho do localStorage
function carregarCarrinhoDoLocalStorage() {
    const carrinho = localStorage.getItem('carrinho');
    return carrinho ? JSON.parse(carrinho) : [];
}

// Função para atualizar a interface com os itens do carrinho
function atualizarCarrinhoUI(carrinho) {
    // Exemplo de como você poderia atualizar o número de itens no carrinho
    const cartItemCountBadge = document.getElementById('cartItemCountBadge');
    cartItemCountBadge.textContent = carrinho.length;
    cartItemCountBadge.style.display = carrinho.length > 0 ? 'block' : 'none';

    // Atualize o conteúdo do carrinho na página
    // (Você pode adaptar o seguinte para o seu layout)
    const cartContent = document.getElementById('cartContent');
    cartContent.innerHTML = '';  // Limpa o conteúdo atual do carrinho

    if (carrinho.length > 0) {
        carrinho.forEach(item => {
            const itemElement = document.createElement('div');
            itemElement.classList.add('cart-item');
            itemElement.innerHTML = `
                <span>${item.name}</span>
                <span>Quantidade: ${item.quantity}</span>
                <span>R$ ${item.total.toFixed(2).replace('.', ',')}</span>
            `;
            cartContent.appendChild(itemElement);
        });
    } else {
        cartContent.innerHTML = '<p>Carrinho vazio</p>';
    }
}

// Adicionar produto ao carrinho
function adicionarAoCarrinho(produto) {
    let carrinho = carregarCarrinhoDoLocalStorage();
    
    const produtoExistente = carrinho.find(item => item.id === produto.id);
    
    if (produtoExistente) {
        produtoExistente.quantity += produto.quantity;
        produtoExistente.total += produto.total;
    } else {
        carrinho.push(produto);
    }

    salvarCarrinhoNoLocalStorage(carrinho);
    atualizarCarrinhoUI(carrinho);
}

// Exemplo de como remover um item do carrinho
function removerDoCarrinho(produtoId) {
    let carrinho = carregarCarrinhoDoLocalStorage();
    carrinho = carrinho.filter(item => item.id !== produtoId);
    salvarCarrinhoNoLocalStorage(carrinho);
    atualizarCarrinhoUI(carrinho);
}
