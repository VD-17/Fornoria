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

        <header class="menu-topbar">
            <div class="menu-meta">
                <h3>Add item on Menu</h3>
                <p>
                    @if ($menuItems)
                        {{$menuItems->count()}} items on menu
                    @else
                        0 items on menu
                    @endif
                </p>
            </div>
            <button class="add-btn" id="openAddMenuModal">
                <i class="fa-solid fa-plus"></i>
                Add Item
            </button>
        </header>

        <section class="display-menu">
            @forelse ($menuItems as $item)
                @include('components.menu_item', ['item' => $item, 'showActions' => true])
            @empty
                <p class="empty-state">No menu items yet</p>
            @endforelse
        </section>
    </article>

    @include('dialogs.add_menu_modal')

    @foreach ($menuItems as $item)
        @include('dialogs.edit_menu_modal', ['menu' => $item])
    @endforeach

@endsection
