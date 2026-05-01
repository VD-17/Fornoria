@extends('layouts.app')

@section('title', 'Home - Fornoria')

@push('styles')
    @vite('resources/css/home.css')
@endpush

@section('body_class', 'page-home')

@section('page_content')
    <!-- Hero  -->
    <section class="hero">
        <div class="hero-bg">
            <img src="images/restaurant/hero.jpeg" width="1880" height="950" alt="">
        </div>

        <div class="slogan">
            <p class="hero-sub">DELIGHTFUL EXPERIENCE</p>
            <h1>For the love of delicious food</h1>
            <p class="hero-desc">Come with family & feel the joy of mouthwatering food</p>
        </div>

        <div class="action-btns">
            <a href="#menu" class="btn-menu">View Our Menu</a>
            <a href="{{ route('order') }}" class="btn-order">ORDER</a>
        </div>
    </section>

     <!-- Menu  -->
    <section class="menu">
        <div class="bg-images">
            <div class="bg-image1">
                <img src="images/restaurant/menu_bg.jpeg" alt="">
            </div>
            <div class="bg-image2">
                <img src="images/restaurant/menu_bg_image_2.jpeg" alt="">
            </div>
        </div>

        <div class="dome-menu-heading">
            <img src="images/icons/logo.png" alt="">
            <h1>MENU</h1>
            <h4>Try Our Menu</h4>
        </div>

        <div class="view-menu">
            <div class="menus">
                <div class="categories">
                    <h3><span>STARTERS</span></h3>
                    <div class="items-grid">
                        @forelse ($starters as $starter)
                            <div class="menu-item">
                                <div class="menu-image">
                                    <img src="{{ $starter->item_image ? Storage::url($starter->item_image) : asset('images/placeholder.png') }}" alt="{{ $starter->item_name }}">
                                </div>
                                <div class="details">
                                    <span class="item-name">{{ $starter->item_name }}</span>
                                    <p>{{ $starter->ingredients }}</p>
                                </div>
                                <div class="price">
                                    <span>R {{ $starter->price }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="empty-msg">No starters available.</p>
                        @endforelse
                    </div>
                </div>

                <div class="categories">
                    <h3><span>PIZZAS</span></h3>
                    <div class="items-grid">
                        @forelse ($pizzas as $pizza)
                            <div class="menu-item">
                                <div class="menu-image">
                                    <img src="{{ $pizza->item_image ? Storage::url($pizza->item_image) : asset('images/placeholder.png') }}" alt="{{ $pizza->item_name }}">
                                </div>
                                <div class="details">
                                    <span class="item-name">{{ $pizza->item_name }}</span>
                                    <p>{{ $pizza->ingredients }}</p>
                                </div>
                                <div class="price">
                                    <span>R {{ $pizza->price }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="empty-msg">No pizzas available.</p>
                        @endforelse
                    </div>
                </div>

                <div class="categories">
                    <h3><span>DRINKS</span></h3>
                    <div class="items-grid">
                        @forelse ($drinks as $drink)
                            <div class="menu-item">
                                <div class="menu-image">
                                    <img src="{{ $drink->item_image ? Storage::url($drink->item_image) : asset('images/placeholder.png') }}" alt="{{ $drink->item_name }}">
                                </div>
                                <div class="details">
                                    <span class="item-name">{{ $drink->item_name }}</span>
                                    <p>{{ $drink->ingredients }}</p>
                                </div>
                                <div class="price">
                                    <span>R {{ $drink->price }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="empty-msg">No drinks available.</p>
                        @endforelse
                    </div>
                </div>

                <div class="categories">
                    <h3><span>DESSERTS</span></h3>
                    <div class="items-grid">
                        @forelse ($desserts as $dessert)
                            <div class="menu-item">
                                <div class="menu-image">
                                    <img src="{{ $dessert->item_image ? Storage::url($dessert->item_image) : asset('images/placeholder.png') }}" alt="{{ $dessert->item_name }}">
                                </div>
                                <div class="details">
                                    <span class="item-name">{{ $dessert->item_name }}</span>
                                    <p>{{ $dessert->ingredients }}</p>
                                </div>
                                <div class="price">
                                    <span>R {{ $dessert->price }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="empty-msg">No desserts available.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About us  -->
    <section class="about">
        <div class="about-image">
            <img src="images/restaurant/about_image_3.jpeg" alt="">
        </div>
        <div class="about-details">
            <p>OUR STORY</p>
            <h3>Every Flavour Tells A Story</h3>
            <a href="">Read More</a>
        </div>
        <div class="about-image">
            <img src="images/restaurant/about_image_3.jpeg" alt="">
        </div>
    </section>

    <!-- Secret  -->
     <section class="secret">
        <div class="secret-box">
            <div class="secret-icon">
                <i class="fa-solid fa-fire-flame-curved"></i>
            </div>
            <div class="secret-details">
                <h4>Wood-Fired</h4>
                <p>Our 900°F brick oven creates the perfect char and smoky flavour in just 90 seconds.</p>
            </div>
        </div>

        <div class="secret-box">
            <div class="secret-icon">
                <i class="fa-solid fa-leaf"></i>
            </div>
            <div class="secret-details">
                <h4>Fresh Ingredients</h4>
                <p>We source San Marzano tomatoes, buffalo mozzarella, and fresh basil flown in weekly from Italy.</p>
            </div>
        </div>

        <div class="secret-box">
            <div class="secret-icon">
                <i class="fa-solid fa-heart"></i>
            </div>
            <div class="secret-details">
                <h4>Made With Love</h4>
                <p>Every pizza is handcrafted by our team of passionate chefs.</p>
            </div>
        </div>
     </section>

    <!-- Gallery  -->
    <section class="gallery-section">
        <div class="gallery-grid">
            <!-- Left Large Image -->
            <div class="gallery-item gallery-left"></div>

            <!-- Center Column -->
            <div class="gallery-center">
                <div class="gallery-title-box">
                    <h2 class="gallery-heading">OUR<br>GALLERY</h2>
                </div>
                <div class="gallery-item gallery-center-mid"></div>
                <div class="gallery-item gallery-center-bottom"></div>
            </div>

            <!-- Right Column -->
            <div class="gallery-right">
                <div class="gallery-item gallery-right-top"></div>
                <div class="gallery-item gallery-right-bottom"></div>
            </div>
        </div>
    </section>

    <!-- Reservation  -->
    <section class="reservation">
        <div class="title">
            Reserve A Table
        </div>

        <div class="res-form">
            <form action="{{ route('res.book') }}" method="post">
                @csrf
                <div class="person-details">
                    <div>
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="name" placeholder="Full Name" value="{{old('name')}}">
                        <span class="error">
                            @error('name')
                                {{$message}}
                            @enderror
                        </span>
                    </div>
                    <div>
                        <i class="fa-solid fa-phone"></i>
                        <input type="text" name="phone" placeholder="Phone Number" value="{{old('phone')}}">
                        <span class="error">
                            @error('phone')
                                {{$message}}
                            @enderror
                        </span>
                    </div>
                </div>

                <div class="details">
                    <div>
                        <i class="fa-solid fa-user-group"></i>
                        <input type="number" name="num_people" placeholder="0 Person" value="{{old('num_people')}}">
                        <span class="error">
                            @error('num_people')
                                {{$message}}
                            @enderror
                        </span>
                    </div>

                    <div>
                        <!-- <i class="fa-solid fa-calendar"></i> -->
                        <input type="date" name="date" value="{{old('date', now()->format('d-m-Y'))}}">
                        <span class="error">
                            @error('date')
                                {{$message}}
                            @enderror
                        </span>
                    </div>

                    <div>
                        <i class="fa-solid fa-clock"></i>
                        <input type="text" list="time" name="time" placeholder="" value="{{old('time')}}">
                        <datalist id="time">
                            <option value="9:00 am"></option>
                            <option value="10:00 am"></option>
                            <option value="11:00 am"></option>
                            <option value="12:00 pm"></option>
                            <option value="1:00 pm"></option>
                            <option value="2:00 pm"></option>
                            <option value="3:00 pm"></option>
                            <option value="4:00 pm"></option>
                            <option value="5:00 pm"></option>
                            <option value="6:00 pm"></option>
                            <option value="7:00 pm"></option>
                            <option value="8:00 pm"></option>
                        </datalist>
                        <!-- <i class="fa-solid fa-angle-down"></i> -->
                         <span class="error">
                            @error('time')
                                {{$message}}
                            @enderror
                        </span>
                    </div>
                </div>

                <div class="add-notes">
                    <textarea name="note" id="note" placeholder="Addition Notes">

                    </textarea>
                    <span class="error">
                        @error('note')
                            {{$message}}
                        @enderror
                    </span>
                </div>

                <div class="book-btn">
                    <button type="submit">
                        BOOK
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
