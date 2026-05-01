@extends('layouts.admin_nav')

@section('title', 'Admin - Profile')

@push('styles')
    @vite('resources/css/profile.css')
@endpush

@push('scripts')
    @vite('resources/js/profile.js')
@endpush

@section('heading', 'Profile')

@section('admin_page_content')

    <div class="profile">
        <div class="edit-profile">
            <h3>Edit Profile</h3>
            <form action="{{ route('admin.profile.edit') }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="{{ auth()->user()->name }}">
                    <span class="error">
                        @error('name') {{ $message }} @enderror
                    </span>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="{{ auth()->user()->email }}">
                    <span class="error">
                        @error('email') {{ $message }} @enderror
                    </span>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone" value="{{ auth()->user()->phone_number }}">
                    <span class="error">
                        @error('phone') {{ $message }} @enderror  {{-- was @error('name') --}}
                    </span>
                </div>

                <div class="submit">
                    <button type="submit">Save Changes</button>
                </div>
            </form>
        </div>

        <div class="sign-out">
            <h3>Sign Out</h3>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Sign Out</button>
            </form>
        </div>

        <div class="change-password">
            <h3>Change Password</h3>
            <form action="{{ route('admin.change.password') }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="currentPassword">Current Password</label>
                    <input type="password" name="currentPassword">
                    <span class="error">
                        @error('currentPassword') {{ $message }} @enderror
                    </span>
                </div>

                <div class="form-group">
                    <label for="newPassword">New Password</label>
                    <input type="password" name="newPassword">
                    <span class="error">
                        @error('newPassword') {{ $message }} @enderror
                    </span>
                </div>

                <div class="submit">
                    <button type="submit">Change Password</button>
                </div>
            </form>
        </div>

        <!-- <div class="delete-account">
            <h3>Delete Account</h3>
            <form action="{{ route('admin.profile.delete', auth()->user()->id) }}" method="POST">  {{-- missing id param --}}
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </div> -->
    </div>

    <!-- @include('layouts.profile')  -->

@endsection
