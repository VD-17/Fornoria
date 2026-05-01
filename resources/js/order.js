const CART_KEY = 'fornoria_cart';

function getCart() {
    try {
        return JSON.parse(localStorage.getItem(CART_KEY)) || [];
    } catch {
        return [];
    }
}

function saveCart(cart) {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
}

function addToCart(id, name, price, image) {
    const cart = getCart();
    const existing = cart.find(item => item.id === id);
    if (existing) {
        existing.qty += 1;
    } else {
        cart.push({ id, name, price: parseFloat(price), image, qty: 1 });
    }
    saveCart(cart);
    return cart;
}

function removeFromCart(id) {
    const cart = getCart().filter(item => item.id !== id);
    saveCart(cart);
    return cart;
}

function updateQty(id, delta) {
    const cart = getCart();
    const item = cart.find(i => i.id === id);
    if (!item) return cart;
    item.qty = Math.max(1, item.qty + delta);
    saveCart(cart);
    return cart;
}

function cartTotal(cart) {
    return cart.reduce((sum, i) => sum + i.price * i.qty, 0);
}

function cartItemCount(cart) {
    return cart.reduce((sum, i) => sum + i.qty, 0);
}

function renderCart() {
    const cart = getCart();
    const list = document.getElementById('cartItemsList');
    const emptyState = document.getElementById('cartEmptyState');
    const footer = document.getElementById('cartFooter');
    const subtotal = document.getElementById('cartSubtotal');
    const badge = document.getElementById('cartBadge');

    if (!list) return;

    list.querySelectorAll('.cart-row').forEach(r => r.remove());

    if (cart.length === 0) {
        emptyState.style.display = 'block';
        footer.style.display     = 'none';
        badge.style.display      = 'none';
        return;
    }

    emptyState.style.display = 'none';
    footer.style.display     = 'flex';

    const count = cartItemCount(cart);
    badge.textContent    = count > 99 ? '99+' : count;
    badge.style.display  = 'flex';

    subtotal.textContent = `R${cartTotal(cart).toFixed(0)}`;

    cart.forEach(item => {
        const row = document.createElement('div');
        row.className      = 'cart-row';
        row.dataset.itemId = item.id;

        row.innerHTML = `
            <div class="cart-row-product">
                <img src="${item.image}" alt="${item.name}">
                <span class="cart-row-product-name">${item.name}</span>
            </div>
            <span class="cart-row-price">R${item.price.toFixed(0)}</span>
            <div class="cart-qty-controls">
                <button class="cart-qty-btn qty-minus" data-id="${item.id}" aria-label="Decrease quantity">−</button>
                <span class="cart-qty-value">${item.qty}</span>
                <button class="cart-qty-btn qty-plus" data-id="${item.id}" aria-label="Increase quantity">+</button>
            </div>
            <span class="cart-row-total">R${(item.price * item.qty).toFixed(0)}</span>
            <button class="cart-remove-btn" data-id="${item.id}" aria-label="Remove ${item.name}">✕</button>
        `;

        list.appendChild(row);
    });
}

function openCart() {
    document.getElementById('cartSidebar')?.classList.add('open');
    document.getElementById('cartOverlay')?.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeCart() {
    document.getElementById('cartSidebar')?.classList.remove('open');
    document.getElementById('cartOverlay')?.classList.remove('active');
    document.body.style.overflow = '';
}

// Category filter
function initFilter() {
    const pills = document.querySelectorAll('.filter-item');
    const cards = document.querySelectorAll('.menu-item');

    if (!pills.length) return;

    pills.forEach(pill => {
        pill.addEventListener('click', () => {
            pills.forEach(p => p.classList.remove('active'));
            pill.classList.add('active');

            const filter = pill.dataset.filter;

            cards.forEach(card => {
                const category = (card.dataset.category || '').toLowerCase();
                if (filter === 'all' || category === filter) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    renderCart();
    initFilter();

    document.getElementById('cartToggleBtn')?.addEventListener('click', openCart);

    document.getElementById('cartCloseBtn')?.addEventListener('click', closeCart);

    document.getElementById('cartOverlay')?.addEventListener('click', closeCart);

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeCart();
    });

    document.getElementById('displayMenu')?.addEventListener('click', e => {
        const btn = e.target.closest('.add-to-cart-btn');
        if (!btn) return;

        const { id, name, price, image } = btn.dataset;
        addToCart(id, name, price, image);
        renderCart();
        openCart();

        btn.textContent = 'Added!';
        btn.classList.add('added');
        setTimeout(() => {
            btn.textContent = 'Order';
            btn.classList.remove('added');
        }, 1200);
    });

    document.getElementById('cartItemsList')?.addEventListener('click', e => {
        const minus = e.target.closest('.qty-minus');
        const plus = e.target.closest('.qty-plus');
        const remove = e.target.closest('.cart-remove-btn');

        if (minus) {
            updateQty(minus.dataset.id, -1);
            renderCart();
        }
        if (plus) {
            updateQty(plus.dataset.id,  +1);
            renderCart();
        }
        if (remove) {
            removeFromCart(remove.dataset.id);
            renderCart();
        }
    });
});
