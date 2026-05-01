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
    <div class="add-item">

        <div class="menu-topbar">
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
        </div>

        <div class="display-menu">
            @forelse ($menuItems as $item)
                @include('components.menu_item', ['item' => $item, 'showActions' => true])
            @empty
                <p class="empty-state">No menu items yet</p>
            @endforelse
        </div>
    </div>

    @include('dialogs.add_menu_modal')

@endsection
