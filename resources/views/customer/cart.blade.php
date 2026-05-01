@extends('layouts.app')

@section('title', 'My Cart')

@push('styles')
    @vite('resources/css/cart.css')
@endpush

@push('scripts')
    @vite('resources/js/cart.js')
@endpush

@section('page_content')
    <div class="cart-container">
        <div class="title">
            MY CART
        </div>

        <div class="manage-cart">
            <div class="cart">
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
                                    <td>
                                        <div class="product-detail">
                                            <img
                                                src="{{ $cartItem->menuItem->item_image ? Storage::url($cartItem->menuItem->item_image) : asset('images/placeholder.png') }}"
                                                alt="{{ $cartItem->menuItem->item_name }}"
                                            >
                                            <span>{{ $cartItem->menuItem->item_name }}</span>
                                        </div>
                                    </td>
                                    <td>R{{ number_format($cartItem->menuItem->price, 0) }}</td>
                                    <td>
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
                                    <td class="item-total" id="total-{{ $cartItem->cartItem_id }}">
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

            <div class="checkout">
                <form action="{{ route('cart.placeOrder') }}" method="POST">
                    @csrf

                    <label for="address">Delivery Address</label>
                    <input type="text" name="address" id="address" placeholder="Enter your delivery address">

                    <div class="cart-total">
                        <hr>
                        <span>Cart Total: <em id="cart-total-display">R{{ number_format($cartTotal, 0) }}</em></span>
                        <hr>
                    </div>

                    <div class="payment">
                        <button type="submit" name="payment_method" value="payfast">PayFast</button>
                        <button type="submit" name="payment_method" value="pay_in_person">Pay in Person</button>
                    </div>

                    <div class="place-order-btn">
                        <button type="submit">Place Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
