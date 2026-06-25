@extends('layouts.app')

@section('title', 'Order')

@push('styles')
    @vite('resources/css/order.css')
@endpush

@push('scripts')
    @vite('resources/js/order.js')
@endpush

@section('page_content')
    <article class="order-container">
        <section class="order-topbar">
            <!-- Title  -->
            <header class="title">
                ORDER
            </header>

            <!-- Menu filter options  -->
            <div class="filter-row">
                <ul class="filter-items" id="filterItems">
                    <li class="filter-item active" data-filter="all">All</li>
                    <li class="filter-item" data-filter="starters">Starters</li>
                    <li class="filter-item" data-filter="pizzas">Pizzas</li>
                    <li class="filter-item" data-filter="drinks">Drinks</li>
                    <li class="filter-item" data-filter="desserts">Desserts</li>
                </ul>

                <!-- <button class="cart-toggle-btn" id="cartToggleBtn" aria-label="Open cart">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="cart-badge" id="cartBadge" style="display:none;">0</span>
                </button> -->
                
                <!-- Cart button  -->
                <a href="{{ route('cart.index') }}" class="cart-toggle-btn" id="cartToggleBtn" aria-label="Open cart">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="cart-badge" id="cartBadge" style="display:none;">0</span>
                </a>
            </div>
        </section>

        <!-- Display menu  -->
        <section class="display-menu">
            @forelse ($menuItems as $item)
                @include('components.menu_item', ['item' => $item, 'showActions' => false, 'showOrder' => true])
            @empty
                <p class="empty-state">No menu items available.</p>
            @endforelse
        </section>
    </article>

    <!-- @include('components.cart_sidebar') -->
@endsection
