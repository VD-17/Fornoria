@use('Illuminate\Support\Facades\Storage')

@props([
    'item',
    'showActions' => false,
    'showOrder' => false,
])

<div class="menu-item" data-category="{{ strtolower($item->category) }}">
    <div class="category-badge">
        <span>{{ $item->category }}</span>
    </div>

    <div class="item-pic">
        <img
            src="{{ $item->item_image ? Storage::url($item->item_image) : asset('images/placeholder.png') }}"
            alt="{{ $item->item_name }}"
        >
    </div>

    <div class="item-description">
        <h3 class="item-name">{{ $item->item_name }}</h3>
        <p class="item-ingredients">{{ $item->ingredients }}</p>
        <h4 class="item-price">R{{ number_format($item->price, 0) }}</h4>
    </div>

    @if ($showActions)
        <div class="menu-actions">
            <a href="{{ route('menu.edit', $item->id) }}" class="action-btn edit-btn" aria-label="Edit {{ $item->item_name }}">
                <i class="fa-solid fa-pen"></i>
            </a>
            <form action="{{ route('menu.destroy', $item->id) }}" method="post" onsubmit="return confirm('Delete this item?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="action-btn delete-btn" aria-label="Delete {{ $item->item_name }}">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>
        </div>
    @endif

    @if ($showOrder)
        <div class="menu-actions">
            <form action="{{ route('cart.add')}}" method="post">
                @csrf
                <input type="hidden" name="menuItem_id" value="{{ $item->id }}">
                <button type="submit" class="order-btn add-to-cart-btn" aria-label="Order {{ $item->item_name }}">
                    Order
                </button>
            </form>
        </div>
    @endif

</div>
