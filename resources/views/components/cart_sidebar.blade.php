<div class="cart-overlay" id="cartOverlay" aria-hidden="true"></div>

<aside class="cart-sidebar" id="cartSidebar" aria-label="Shopping cart" role="complementary">

    <div class="cart-sidebar-header">
        <h2 class="cart-title">My Cart</h2>
        <button class="cart-close-btn" id="cartCloseBtn" aria-label="Close cart">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <div class="cart-col-headings">
        <span>PRODUCT</span>
        <span>PRICE</span>
        <span>QTY</span>
        <span>TOTAL</span>
        <span></span>{{-- remove col --}}
    </div>

    <div class="cart-items-list" id="cartItemsList">
        <p class="cart-empty-state" id="cartEmptyState">Your cart is empty.</p>
    </div>

    <div class="cart-footer" id="cartFooter" style="display:none;">
        <div class="cart-subtotal">
            <span>Subtotal</span>
            <span id="cartSubtotal">R0</span>
        </div>
        <a href="" class="cart-checkout-btn">View Full Cart</a>
        <a href="" class="cart-checkout-btn checkout-primary">Checkout</a>
    </div>

</aside>
