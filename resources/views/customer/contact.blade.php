@extends('layouts.app')

@section('title', 'Contact')

@push('styles')
    @vite('resources/css/contact.css')
@endpush

@section('page_content')
    <section class="contact section-p1">
        <header class="title">
            CONTACT US
        </header>

        <div class="contact-container">
            <h2 id="contact-form-heading" class="sr-only">Send us a message</h2>
            <form action="{{ route('contact.send') }}" method="POST" class="contact-form">
                @csrf
                <div>
                    <label for="name" class="sr-only">Name</label>
                    <input type="text" name="name" placeholder="Name" value="{{ old('name') }}">
                </div>
                <span class="error">
                    @error('name')
                        {{ $message }}
                    @enderror
                </span>

                <div>
                    <label for="email" class="sr-only">Email</label>
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
                </div>
                <span class="error">
                    @error('email')
                        {{ $message }}
                    @enderror
                </span>

                <div>
                    <label for="subject" class="sr-only">Subject</label>
                    <input type="text" name="subject" placeholder="Subject" value="{{ old('subject') }}">
                </div>
                <span class="error">
                    @error('subject')
                        {{ $message }}
                    @enderror
                </span>

                <div>
                    <label for="message" class="sr-only">Your Message</label>
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

            <aside class="contact-details">
                <h2 id="contact-info-heading" class="sr-only">Contact Information</h2>
                <section class="details">
                    <h4>Contact Details</h4>
                    <p class="highlight">+27 12 345 6789</p>
                    <p class="highlight">fornoria@restaurant.com</p>
                </section>
                <section class="location">
                    <h4>Location</h4>
                    <p>East Road, Mowbray, Cape Town, 8000</p>
                </section>
                <section class="time">
                    <h4>Time</h4>
                    <p>Monday to Sunday</p>
                    <p>10:00 am - 9:00 pm</p>
                </section>
            </aside>
        </div>
    </section>
@endsection
