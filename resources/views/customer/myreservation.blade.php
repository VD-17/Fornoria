@extends('layouts.app')

@section('title', 'My Reservation')

@push('styles')
    @vite('resources/css/reservation.css')
@endpush

@section('page_content')
    <div class="reservation">
        <div class="title">
            MY RESERVATIONS
        </div>

        <div class="reservation-items">
            @forelse ($reservations as $reservation)
                <div class="res-card">
                    <div class="status {{ strtolower($reservation->status) }}">
                        {{ $reservation->status }}
                    </div>

                    <div class="res-details">
                        <p class="res-name">{{ $reservation->name }}</p>
                        <p><span class="label">Date:</span> {{ $reservation->date }}</p>
                        <p><span class="label">Time:</span> {{ $reservation->time }}</p>
                        <p><span class="label">For:</span> {{ $reservation->num_people }} people</p>
                    </div>

                    <div class="cancel-btn">
                        <form action="{{ route('res.cancel', $reservation->reservation_id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Cancel</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="no-reservations">You have no reservations yet.</p>
            @endforelse
        </div>
    </div>
@endsection