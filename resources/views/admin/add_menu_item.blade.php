@extends('layouts.admin_nav')

@section('title', 'Menu Management')

@push('styles')
    @vite('resources/css/add_menu.css')
@endpush

@push('scripts')
    @vite('resources/js/add_menu.js')
@endpush

@section('heading', 'Menu Management')

@section('admin_page_content')
    <article class="add-item">

        <!-- Title  -->
        <header class="menu-topbar">
            <div class="menu-meta">
                <h3>Add item on Menu</h3>
                <!-- Menu item count  -->
                <p>
                    @if ($menuItems)
                        {{$menuItems->count()}} items on menu
                    @else
                        0 items on menu
                    @endif
                </p>
            </div>
            <!-- Add menu item button  -->
            <button class="add-btn" id="openAddMenuModal">
                <i class="fa-solid fa-plus"></i>
                Add Item
            </button>
        </header>

        <!-- Displaying menu  -->
        <section class="display-menu">
            @forelse ($menuItems as $item)
                @include('components.menu_item', ['item' => $item, 'showActions' => true])
            @empty
                <p class="empty-state">No menu items yet</p>
            @endforelse
        </section>
    </article>

    <!-- Menu modal  -->
    @include('dialogs.add_menu_modal')

    <!-- Menu item  -->
    @foreach ($menuItems as $item)
        @include('dialogs.edit_menu_modal', ['menu' => $item])
    @endforeach

@endsection
