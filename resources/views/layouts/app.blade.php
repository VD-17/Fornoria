@extends('layouts.base')

@push('styles')
    @vite('resources/css/header.css')
@endpush

@push('scripts')
    @vite('resources/js/header.js')
@endpush

@section('content')
    <div class="nav-overlay" id="navOverlay"></div>

    <Header>
        <div class="topbar">
            <div>
                <i class="fa-solid fa-location-dot"></i>
                <p>East Road, Mowbaray, Cape Town, 8000</p>
            </div>

            <div>
                <i class="fa-solid fa-clock"></i>
                <p>Daily, 10:00 am to 9:00 pm</p>
            </div>

            <div>
                <i class="fa-solid fa-phone"></i>
                <a href="tel:+27 12 345 6789">+27 12 345 6789</a>
            </div>

            <div>
                <i class="fa-solid fa-envelope"></i>
                <a href="mailto:fornoria@restaurant.com">fornoria@restaurant.com</a>
            </div>
        </div>

        <div class="separator">
            <hr>
        </div>

        <div class="header">
            <div class="logo">
                <a href="{{'/'}}" class="logo">
                    <img src="images/icons/fornoria_logo.png" alt="Fornoria - Home">
                </a>
            </div>

            <nav class="navbar" id="navbar" aria-label="Main navigation">
                <button class="nav-close-btn" id="navCloseBtn" aria-label="Close menu">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <ul class="nav-list">
                    <li class="navbar-item">
                        <a href="{{ url('/') }}" class="{{request()->is('/') ? 'active' : ''}}">HOME</a>
                    </li>

                    <li class="navbar-item">
                        <a href="{{ route('order') }}" class="{{request()->is('order') ? 'active' : ''}}">ORDER</a>
                    </li>

                    <li class="navbar-item">
                        <a href="{{ route('myres.index') }}" class="{{request()->is('reservation') ? 'active' : ''}}">RESERVATION</a>
                    </li>

                    <li class="navbar-item">
                        <a href="{{ route('about')}}" class="{{request()->is('about') ? 'active' : ''}}">ABOUT US</a>
                    </li>

                    <li class="navbar-item">
                        <a href="{{ route('contact.index')}}" class="{{request()->is('contact') ? 'active' : ''}}">CONTACT</a>
                    </li>
                </ul>
            </nav>

            @auth
                <div class="user-profile" id="userProfile" aria-haspopup="true" aria-expanded="false" role="button" tabindex="0">
                    <i class="fa-regular fa-user"></i>
                    <span>{{auth()->user()->name}}</span>
                    <div class="profile-dropdown">
                        <i class="fa-solid fa-angle-down profile-chevron" id="dropdown"></i>
                    </div>

                    <div class="dropdown-content" id="dropdownContent" role="menu">
                        <a href="{{ route('profile.index') }}" role="menuItem">Profile</a>
                        <a href="{{ route('cart.index') }}" role="menuItem">My Cart</a>
                        <a href="{{ route('myres.index') }}" role="menuItem">My Reservation</a>
                        <a href="{{ route('order.index') }}" role="menuItem">Order History</a>
                        <hr>
                        <a href="{{ url('/logout') }}" class="logout" role="menuitem"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display:none;">
                            @csrf
                        </form>
                    </div>
                </div>
            @else
                <div class="auth-buttons">
                    <a href="{{ url('/login') }}" class="btn-login">Login</a>
                    <a href="{{ url('/register') }}" class="btn-signup">Sign Up</a>
                </div>
            @endauth

            <button class="nav-open-btn" id="navOpenBtn" aria-label="Open menu" aria-expanded="false">
                <span class="line line-1"></span>
                <span class="line line-2"></span>
                <span class="line line-3"></span>
            </button>
        </div>
    </Header>

    <main>
        @yield('page_content')
    </main>

    <footer>
        <div class="footer-bg-image">
            <img src="images/restaurant/footer.jpeg" alt="">
        </div>

        <div class="footer-1-sec">
            <h3>Fornoria</h3>
            <p>Your slice of happiness</p>
            <div class="socials">
                <i class="fa-brands fa-facebook-f"></i>
                <i class="fa-brands fa-instagram"></i>
                <i class="fa-brands fa-twitter"></i>
            </div>
            <div class="Install">
                <button>Install App</button>
            </div>
        </div>

        <div class="mid-sec">
            <div class="footer-logo">
                <img src="images/icons/fornoria_logo.png" alt="">
            </div>
            <div class="contact-details">
                <p>East Road, Mowbray, Cape Town, 8000</p>
                <p>fornoria@restaurant.com</p>
                <p>+27 12 345 6789</p>
                <p>Open: 10:00 am - 9:00 pm</p>
            </div>
        </div>

        <div class="div-last-sec">
            <ul class="footer-links">
                <li><a href="{{ url('/') }}">HOME</a></li>
                <li><a href="{{ url('/#menu' )}}">MENU</a></li>
                <li><a href="{{ route('order') }}">ORDER</a></li>
                <li><a href="{{ url('/#reservation') }}">RESERVATION</a></li>
                <li><a href="{{ route('about') }}">ABOUT US</a></li>
                <li><a href="{{ route('contact.index') }}">CONTACT US</a></li>
                <li><a href="#">PRIVACY</a></li>
            </ul>
        </div>

        <p><i class="fa-regular fa-copyright"></i> 2026 Fornoria. All Rights Reserved</p>
    </footer>

@endsection
