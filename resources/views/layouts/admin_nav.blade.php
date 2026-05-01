@extends('layouts.base')

@push('styles')
    @vite('resources/css/admin_nav.css')
@endpush

@push('scripts')
    @vite('resources/js/admin_nav.js')
@endpush

@section('content')
    <div class="nav-overlay" id="navOverlay" aria-hidden="true"></div>

    <div class="nav-heading">
        <aside>
            <div class="side-nav-bar" id="sideNavBar">
                <button class="nav-close-btn" id="navCloseBtn" aria-label="Close menu">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <div class="logo-wrap">
                    <a href="{{ route('admin.index') }}" class="logo-link">
                        <img src="images/icons/fornoria_logo.png" alt="Admin - Dashboard">
                    </a>
                    <span class="admin-label">Admin Panel</span>
                    <hr class="logo-divider">
                </div>

                <nav class="navbar" id="navbar" aria-label="Main navigation">

                    <ul class="nav-list {{request()->is('dashboard') ? 'active' : ''}}">
                        <li class="navbar-item">
                            <i class="fa-solid fa-border-all"></i>
                            <a href="{{ route('admin.index') }}">Dashboard</a>
                            @if (request()->is('dashboard'))
                                <i class="fa-solid fa-angle-right"></i>
                            @endif
                        </li>

                        <li class="navbar-item {{request()->is('menu') ? 'active' : ''}}">
                            <i class="fa-solid fa-utensils"></i>
                            <a href="{{ route('menu.index') }}">Menu</a>
                            @if (request()->is('menu'))
                                <i class="fa-solid fa-angle-right"></i>
                            @endif
                        </li>

                        <li class="navbar-item {{request()->is('admin/reservation*') ? 'active' : ''}}">
                            <i class="fa-solid fa-calendar"></i>
                            <a href="{{ route('admin.res.index') }}">Reservations</a>
                            @if (request()->is('admin/reservation*'))
                                <i class="fa-solid fa-angle-right"></i>
                            @endif
                        </li>

                        <li class="navbar-item {{request()->is('admin/order*') ? 'active' : ''}}">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <a href="{{ route('admin.orders.index') }}">Orders</a>
                            @if (request()->is('admin/order*'))
                                <i class="fa-solid fa-angle-right"></i>
                            @endif
                        </li>

                        <li class="navbar-item {{request()->is('admin/payment*') ? 'active' : ''}}">
                            <i class="fa-solid fa-credit-card"></i>
                            <a href="{{ route('admin.payment.index') }}">Payments</a>
                            @if (request()->is('admin/payment*'))
                                <i class="fa-solid fa-angle-right"></i>
                            @endif
                        </li>

                        <li class="navbar-item {{request()->is('admin/contact*') ? 'active' : ''}}">
                            <i class="fa-solid fa-envelope"></i>
                            <a href="{{ route('admin.form.index') }}">Contact Forms</a>
                            @if (request()->is('admin/contact*'))
                                <i class="fa-solid fa-angle-right"></i>
                            @endif
                        </li>

                        <li class="navbar-item {{request()->is('admin/user*') ? 'active' : ''}}">
                            <i class="fa-solid fa-user-group"></i>
                            <a href="{{ route('admin.user.index') }}">Users</a>
                            @if (request()->is('admin/user*'))
                                <i class="fa-solid fa-angle-right"></i>
                            @endif
                        </li>

                        <li class="navbar-item {{request()->is('admin/add*') ? 'active' : ''}}">
                            <i class="fa-solid fa-user-shield"></i>
                            <a href="{{ route('admin.add.index') }}">Admins</a>
                            @if (request()->is('admin/add*'))
                                <i class="fa-solid fa-angle-right"></i>
                            @endif
                        </li>

                        <li class="navbar-item {{request()->is('gallery*') ? 'active' : ''}}">
                            <i class="fa-solid fa-images"></i>
                            <a href=" {{ route('gallery.index') }}">Gallery</a>
                            @if (request()->is('gallery*'))
                                <i class="fa-solid fa-angle-right"></i>
                            @endif
                        </li>

                        <li class="navbar-item {{request()->is('admin/profile*') ? 'active' : ''}}">
                            <i class="fa-solid fa-circle-user"></i>
                            <a href="{{ route('admin.profile.index') }}">Profile</a>
                            @if (request()->is('admin/profile*'))
                                <i class="fa-solid fa-angle-right"></i>
                            @endif
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="main-column">
            <header class="heading-topbar">
                <button class="nav-open-btn" id="navOpenBtn" aria-label="Open menu" aria-expanded="false">
                    <span class="line line-1"></span>
                    <span class="line line-2"></span>
                    <span class="line line-3"></span>
                </button>

                <h2 class="topbar-title">@yield('heading', 'Dashboard')</h2>
            </header>

            <main>
                @yield('admin_page_content')
            </main>
        </div>
    </div>

@endsection
