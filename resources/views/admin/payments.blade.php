@extends('layouts.admin_nav')

@section('title', 'Admin - Payments')

@push('styles')
    @vite('resources/css/view_reservations.css')
@endpush

@section('heading', 'Payments')

@section('admin_page_content')
    <div class="reservations">
        <!-- <div class="table-title">
            <i class="fa-solid fa-clock"></i>
            <h5>Payments</h5>
        </div> -->
        <table class="reservation-table">
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($payments as $payment)
                    <tr>
                        <td>{{ $payment->payment_id }}</td>
                        <td>{{ $payment->user->name }}</td>
                        <td>R {{ number_format($payment->amount, 2) }}</td>
                        <td>{{ $payment->paymentMethod }}</td>
                        <td>{{ $payment->dateOfPayment }}</td>
                        <td class="status">
                            <span class="status-badge {{ strtolower($payment->paymentStatus) }}">
                                {{ $payment->paymentStatus }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="no-res">No payments yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
