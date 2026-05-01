@extends('layouts.app')

@section('title', 'Contact')

@push('styles')
    @vite('resources/css/contact.css')
@endpush

@push('scripts')
    @vite('resources/js/contact.js')
@endpush

@section('page_content')
    <div class="contact section-p1">
        <div class="title">
            CONTACT US
        </div>

        <div class="contact-container">
            <form action="{{ route('contact.send') }}" method="POST" class="contact-form">
                @csrf
                <div>
                    <input type="text" name="name" placeholder="Name" value="{{ old('name') }}">
                </div>
                <span class="error">
                    @error('name')
                        {{ $message }}
                    @enderror
                </span>

                <div>
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
                </div>
                <span class="error">
                    @error('email')
                        {{ $message }}
                    @enderror
                </span>

                <div>
                    <input type="text" name="subject" placeholder="Subject" value="{{ old('subject') }}">
                </div>
                <span class="error">
                    @error('subject')
                        {{ $message }}
                    @enderror
                </span>

                <div>
                    <textarea name="message" placeholder="Your Message">{{ old('message') }}</textarea>
                </div>
                <span class="error">
                    @error('message')
                        {{ $message }}
                    @enderror
                </span>

                <div class="submit-container">
                    <button type="submit">Submit</button>
                </div>
            </form>

            <div class="contact-details">
                <div class="details">
                    <h4>Contact Details</h4>
                    <p class="highlight">+27 12 345 6789</p>
                    <p class="highlight">fornoria@restaurant.com</p>
                </div>
                <div class="location">
                    <h4>Location</h4>
                    <p>East Road, Mowbray, Cape Town, 8000</p>
                </div>
                <div class="time">
                    <h4>Time</h4>
                    <p>Monday to Sunday</p>
                    <p>10:00 am - 9:00 pm</p>
                </div>
            </div>
        </div>
    </div>
@endsection