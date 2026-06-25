@extends('layouts.base')

@section('title', 'Login')

@push('styles')
    @vite('resources/css/auth.css')
@endpush

@section('content')
    <section class="register">
        <div class="register-form">
            <!-- Logo image  -->
            <figure class="logo">
                <img src="images/icons/fornoria_logo.png" alt="Fornoria">
            </figure>

            <h2>Login</h2>

            <div class="register-columns">
                <!-- Login form  -->
                <div class="local">
                    <form action="{{url('/login')}}" method="post">
                        @csrf

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
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password">
                            <span class="error">
                                @error('password')
                                    {{$message}}
                                @enderror
                            </span>
                        </div>

                        <button type="submit" class="btn">Login</button>
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
                    <a href="{{url('/auth/google/redirect')}}" class="circle" title="Login with Google"><i class="fa-brands fa-google"></i></a>
                </div>
            </div>

            <p class="register-footer">
                Don't have an Account? <a href="{{url('/register')}}">Sign Up</a>
            </p>

        </div>
    </section>
@endsection
