@extends('layouts.base')

@section('title', 'Register')

@push('styles')
    @vite('resources/css/auth.css')
@endpush

@section('content')
    <section class="register">
        <div class="register-form">
            <!-- Logo image  -->
            <div class="logo">
                <img src="images/icons/fornoria_logo.png" alt="Fornoria">
            </div>

            <h2>Sign Up</h2>

            <div class="register-columns">
                <!-- Registration form  -->
                <div class="local">
                    <form action="{{url('/register')}}" method="post">
                        @csrf

                        <div>
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" value="{{old('name')}}">
                            <span class="error">
                                @error('name')
                                    {{$message}}
                                @enderror
                            </span>
                        </div>

                        <div>
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{old('email')}}">
                            <span class="error">
                                @error('email')
                                    {{$message}}
                                @enderror
                            </span>
                        </div>

                        <div>
                            <label for="phone">Phone Number</label>
                            <input type="text" id="phone" name="phone" value="{{old('phone')}}">
                            <span class="error">
                                @error('phone')
                                    {{$message}}
                                @enderror
                            </span>
                        </div>

                        <div>
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password">
                            <span class="error">
                                @error('password')
                                    {{$message}}
                                @enderror
                            </span>
                        </div>

                        <button type="submit" class="btn">Sign Up</button>
                    </form>
                </div>

                <!-- Seperator  -->
                <div class="register-divider">
                    <div class="divider-line"></div>
                    <h3>OR</h3>
                    <div class="divider-line"></div>
                </div>

                <!-- Google oAuth  -->
                <div class="google">
                    <a href="{{url('/auth/google/redirect')}}" class="circle" title="Sign up with Google"><i class="fa-brands fa-google"></i></a>
                </div>
            </div>

            <p class="register-footer">
                Already a Member? <a href="{{url('/login')}}">Sign In</a>
            </p>

        </div>
    </section>
@endsection
