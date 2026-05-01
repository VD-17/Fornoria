@extends('layouts.admin_nav')

@section('title', 'Admin - View Users')

@push('styles')
    @vite('resources/css/view_reservations.css')
@endpush

@section('heading', 'Users')

@section('admin_page_content')
    <div class="reservations">
        <!-- <div class="table-title">
            <i class="fa-solid fa-clock"></i>
            <h5>Users</h5>
        </div> -->
        <table class="reservation-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Joined</th>
                    <th>Orders</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone_number ?? 'N/A' }}</td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>{{ $count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="no-res">No users yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
