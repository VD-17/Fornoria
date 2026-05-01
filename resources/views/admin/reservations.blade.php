@extends('layouts.admin_nav')

@section('title', 'Admin - Reservations')

@push('styles')
    @vite('resources/css/view_reservations.css')
@endpush

@section('heading', 'Reservations')

@section('admin_page_content')
    <div class="reservations">
        <!-- <div class="table-title">
            <i class="fa-solid fa-clock"></i>
            <h5>Upcoming Reservations</h5>
        </div> -->
        <table class="reservation-table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Phone Number</th>
                    <th>People</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reservations as $res)
                    <tr>
                        <td>{{ $res->name }}</td>
                        <td>{{ $res->phone }}</td>
                        <td>{{ $res->num_people }}</td>
                        <td>{{ $res->date }}</td>
                        <td>{{ $res->time }}</td>
                        <td class="status">
                            <span class="status-badge status-{{ strtolower($res->status) }}">
                                {{ $res->status }}
                            </span>
                        </td>
                        <td>
                            {{-- Confirm button --}}
                            <form action="{{ route('res.updateResStatus', $res->reservation_id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="Confirmed">
                                <button type="submit" class="action-btn confirm-btn">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                            </form>
                            {{-- Cancel button --}}
                            <form action="{{ route('res.updateResStatus', $res->reservation_id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="Cancelled">
                                <button type="submit" class="action-btn cancel-btn">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="no-res">No reservations yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
