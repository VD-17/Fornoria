@extends('layouts.admin_nav')

@section('title', 'Add Admins')

@push('styles')
    @vite('resources/css/add_admin.css')
@endpush

@push('scripts')
    @vite('resources/js/add_admin.js')
@endpush

@section('heading', 'Admin Management')

@section('admin_page_content')
    <div class="add-admin">
        <div class="admin-topbar">
            <div class="admin-meta">
                <h3>Add Admins</h3>
                <p>
                    @if ($admins)
                        {{ $admins->count() }} admins
                    @else
                        0 admins
                    @endif
                </p>
            </div>
            <button class="add-btn" id="openAddAdminModal">
                <i class="fa-solid fa-plus"></i>
                Add Admin
            </button>
        </div>

        <!-- @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif -->

        <div class="display-admin">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Added On</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($admins as $admin)
                        <tr>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->phone_number ?? '—' }}</td>
                            <td>{{ $admin->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if ($admin->id !== Auth::id())
                                    <form action="{{ route('admin.delete', $admin->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn cancel-btn"
                                            onclick="return confirm('Are you sure you want to remove this admin?')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="you-badge">You</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="no-admin">No admins yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @include('dialogs.add_admin_modal')
@endsection
