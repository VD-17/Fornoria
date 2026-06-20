@extends('layouts.admin_nav')

@section('title', 'Edit Menu Item')

@push('styles')
    @vite('resources/css/add_menu.css')
@endpush

@push('scripts')
    @vite('resources/js/add_menu.js')
@endpush

@section('heading', 'Menu Management')

@section('admin_page_content')
    <article class="add-item">
        @include('dialogs.edit_menu_modal', ['item' => $menu])
    </article>
@endsection
