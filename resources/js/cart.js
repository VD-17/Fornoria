document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.increase-btn, .decrease-btn').forEach(button => {
        button.addEventListener('click', async (e) => {
            const btn        = e.currentTarget;
            const cartItemId = btn.dataset.id;
            // FIX: parse price as float explicitly — dataset values are always strings
            const price      = parseFloat(btn.dataset.price);
            const isIncrease = btn.classList.contains('increase-btn');

            const qtySpan   = document.getElementById(`qty-${cartItemId}`);
            const totalCell = document.getElementById(`total-${cartItemId}`);

            let currentQty = parseInt(qtySpan.textContent.trim());
            if (!isIncrease && currentQty <= 1) return;

            const newQty = isIncrease ? currentQty + 1 : currentQty - 1;

            // Optimistic UI — update display immediately before the request returns
            qtySpan.textContent   = newQty;
            totalCell.textContent = `R${formatNumber(newQty * price)}`;
            updateCartTotalDisplay();

            setRowLoading(cartItemId, true);

            try {
                const response = await fetch(`/cart/${cartItemId}/quantity`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept':       'application/json',
                    },
                    body: JSON.stringify({ quantity: newQty }),
                });

                if (!response.ok) throw new Error(`Server error ${response.status}`);

                const data = await response.json();

                totalCell.textContent = `R${formatNumber(data.item_total)}`;

                const cartTotalEl = document.getElementById('cart-total-display');
                if (cartTotalEl) {
                    cartTotalEl.textContent = `R${formatNumber(data.cart_total)}`;
                }

            } catch (err) {
                // Roll back optimistic update on any failure
                qtySpan.textContent   = currentQty;
                totalCell.textContent = `R${formatNumber(currentQty * price)}`;
                updateCartTotalDisplay();
                showToast('Could not update quantity. Please try again.');
                console.error('updateQuantity failed:', err);
            } finally {
                setRowLoading(cartItemId, false);
            }
        });
    });

    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', async (e) => {
            const btn        = e.currentTarget;
            const menuItemId = btn.dataset.id;
            const itemName   = btn.dataset.name;

            btn.disabled    = true;
            btn.textContent = 'Adding…';

            try {
                const response = await fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept':       'application/json',
                    },
                    body: JSON.stringify({ menuItem_id: menuItemId, quantity: 1 }),
                });

                if (!response.ok) throw new Error(`Server responded with ${response.status}`);

                const data = response.headers.get('Content-Type')?.includes('application/json')
                    ? await response.json()
                    : {};

                btn.textContent = '✓ Added';
                btn.classList.add('added');

                if (data.cart_count !== undefined) updateCartBadge(data.cart_count);

                showToast(`${itemName} added to cart!`);

            } catch (err) {
                console.error('Add to cart failed:', err);
                btn.textContent = 'Error – retry';
                btn.classList.add('error');
            } finally {
                setTimeout(() => {
                    btn.disabled    = false;
                    btn.textContent = 'Order';
                    btn.classList.remove('added', 'error');
                }, 2000);
            }
        });
    });

    function updateCartTotalDisplay() {
        let total = 0;
        document.querySelectorAll('.item-total').forEach(cell => {
            const val = parseFloat(cell.textContent.replace(/[^0-9.]/g, ''));
            if (!isNaN(val)) total += val;
        });
        const display = document.getElementById('cart-total-display');
        if (display) display.textContent = `R${formatNumber(total)}`;
    }

    function formatNumber(value) {
        return parseFloat(value).toLocaleString('en-ZA', { maximumFractionDigits: 0 });
    }

    function setRowLoading(cartItemId, loading) {
        document.querySelectorAll(
            `.increase-btn[data-id="${cartItemId}"], .decrease-btn[data-id="${cartItemId}"]`
        ).forEach(btn => {
            btn.disabled = loading;
            btn.classList.toggle('loading', loading);
        });
    }

    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    }

    function updateCartBadge(count) {
        document.querySelectorAll('#cart-badge, .cart-badge').forEach(badge => {
            badge.textContent   = count;
            badge.style.display = count > 0 ? 'inline-flex' : 'none';
        });
    }

    function showToast(message) {
        document.querySelector('.cart-toast')?.remove();

        const toast = document.createElement('div');
        toast.className = 'cart-toast';
        toast.textContent = message;

        Object.assign(toast.style, {
            position:     'fixed',
            bottom:       '24px',
            right:        '24px',
            background:   '#c0633a',
            color:        '#f5f0e8',
            padding:      '12px 20px',
            borderRadius: '6px',
            fontFamily:   'Raleway, sans-serif',
            fontSize:     '0.9rem',
            fontWeight:   '700',
            boxShadow:    '0 4px 16px rgba(0,0,0,0.35)',
            zIndex:       '9999',
            opacity:      '0',
            transform:    'translateY(10px)',
            transition:   'opacity 0.25s ease, transform 0.25s ease',
        });

        document.body.appendChild(toast);
        requestAnimationFrame(() => {
            toast.style.opacity   = '1';
            toast.style.transform = 'translateY(0)';
        });
        setTimeout(() => {
            toast.style.opacity   = '0';
            toast.style.transform = 'translateY(10px)';
            setTimeout(() => toast.remove(), 300);
        }, 2500);
    }
});
