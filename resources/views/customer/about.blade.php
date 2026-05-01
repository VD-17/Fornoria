@extends('layouts.app')

@section('title', 'About')

@push('styles')
    @vite('resources/css/about.css')
@endpush

@section('page_content')
    <div class="about-container">
        <div class="title">
            ABOUT US
        </div>

        <div class="about">
            <div class="about-details">
                <h2>Every Flavour Tells A Story</h2>
                <p>
                    At Fornoria, we believe time is the most important
                    ingredient. Our signature dough undergoes a rigorous
                    48-hour fermentation process, allowing the natural
                    yeasts to develop a complex flavor profile and an
                    airy, digestible structure.
                </p>
                <p>
                    Once perfected, it meets the smoky embrace of our
                    900-degree coal oven. Unlike standard wood fires,
                    the intense, dry heat of coal creates a unique
                    "leopard-spotting" char that locks in moisture
                    while delivering an unmistakable crunch.
                </p>
            </div>

            <div class="res-image">
                <img src="images/restaurant/about.png" alt="">
            </div>
        </div>


    </div>
@endsection
