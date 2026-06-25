@extends('layouts.app')

@section('title', 'My Cart')

@push('styles')
    @vite('resources/css/cart.css')
@endpush

@push('scripts')
    @vite('resources/js/cart.js')
@endpush

@section('page_content')
    <article class="cart-container">

        <section class="manage-cart">
            <!-- Title  -->
            <header class="title">
                MY CART
            </header>

            <!-- Main cart content  -->
            <div class="cart">
                <!-- Cart Items  -->
                @if ($cartItems->isEmpty())
                    <p class="cart-empty-state">Your cart is empty.</p>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>PRODUCT</th>
                                <th>PRICE</th>
                                <th>QTY</th>
                                <th>TOTAL</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($cartItems as $cartItem)
                                <tr>
                                    <td data-label = "Product">
                                        <figure class="product-detail">
                                            <img
                                                src="{{ $cartItem->menuItem->item_image ? Storage::url($cartItem->menuItem->item_image) : asset('images/placeholder.png') }}"
                                                alt="{{ $cartItem->menuItem->item_name }}"
                                            >
                                            <figcaption>{{ $cartItem->menuItem->item_name }}</figcaption>
                                        </figure>
                                    </td>
                                    <td data-label = "Price">R{{ number_format($cartItem->menuItem->price, 0) }}</td>
                                    <td data-label = "Qty">
                                        <div class="qty-control">
                                            <button class="qty-btn decrease-btn"
                                                    data-id="{{ $cartItem->cartItem_id }}"
                                                    data-price="{{ $cartItem->menuItem->price }}">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                            <span class="qty-value" id="qty-{{ $cartItem->cartItem_id }}">
                                                {{ $cartItem->quantity }}
                                            </span>
                                            <button class="qty-btn increase-btn"
                                                    data-id="{{ $cartItem->cartItem_id }}"
                                                    data-price="{{ $cartItem->menuItem->price }}">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td data-label="Total" class="item-total" id="total-{{ $cartItem->cartItem_id }}">
                                        R{{ number_format($cartItem->total_price, 0) }}
                                    </td>
                                    <td>
                                        <form action="{{ route('cart.remove', $cartItem->cartItem_id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="remove-btn" aria-label="Remove item">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <!-- Checkout  -->
            <aside class="checkout">
                <form action="{{ route('cart.placeOrder') }}" method="POST" id="checkout-form">
                    @csrf

                    @if ($errors->any())
                        <div class="checkout-error" style="display:block;">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Cart total  -->
                    <div class="cart-total">
                        <hr>
                        <span>Cart Total: <em id="cart-total-display">R{{ number_format($cartTotal, 0) }}</em></span>
                        <hr>
                    </div>

                    <!-- Delivery method  -->
                    <input type="hidden" name="delivery_method" id="delivery_method_input" value="">
                    <input type="hidden" name="payment_method" id="payment_method_input" value="">

                    <label for="delivery">Delivery Method:</label>
                    <div class="delivery">
                        <button type="button" class="delivery-btn" data-value="collect">
                            Collect
                        </button>
                        <button type="button" class="delivery-btn" data-value="deliver">
                            Deliver
                        </button>
                    </div>

                    <div class="delivery-address" id="address-field" style="display: none;">
                        <label for="address">Delivery Address</label>
                        <input type="text" name="address" id="address" placeholder="Enter your delivery address">
                    </div>

                    <!-- Payment method  -->
                    <label for="payment">Payment Method:</label>
                    <div class="payment">
                        <button type="button" class="payment-btn" data-value="payfast">
                            PayFast
                        </button>
                        <button type="button" class="payment-btn" data-value="pay_in_person">
                            Pay in Person
                        </button>
                    </div>

                    <p class="checkout-error" id="checkout-error" style="display:none;"></p>

                    <!-- Place order  -->
                    <div class="place-order-btn">
                        <button type="submit" id="place-order-submit">Place Order</button>
                    </div>
                </form>
            </aside>
        </section>
    </article>
@endsection
