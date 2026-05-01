@extends('layouts.app')
@section('title', 'Order History')

@push('styles')
    @vite('resources/css/reorder.css')
@endpush

@section('page_content')
    <div class="track-order">
        <div class="title">
            MY ORDERS
        </div>

        <div class="tracking">
            @forelse($orders as $order)
                <div class="order">
                    <div class="ref">
                        <span>Ref: #{{ $order->order_id }}</span>
                        <span>{{ \Carbon\Carbon::parse($order->orderDate)->format('d M Y, H:i') }}</span>
                    </div>

                    <div class="details">
                        <p>
                            <span class="label">Items:</span>
                            @foreach($order->orderItems as $orderItem)
                                {{ $orderItem->menuItem->item_name }} x{{ $orderItem->quantity }}{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        </p>
                        <p>
                            <span class="label">Total: </span>
                            <span class="total-value">R{{ number_format($order->totalAmount, 0) }}</span>
                        </p>
                        <p>
                            <span class="label">Payment: </span>
                            {{ $order->payment?->paymentMethod ?? 'N/A' }}
                        </p>
                        <p>
                            <span class="label">Status: </span>
                            {{ $order->status }}
                        </p>
                    </div>

                    <div class="reorder-btn">
                        <form action="{{ route('order.reorder', $order->order_id) }}" method="POST">
                            @csrf
                            <button type="submit">Re-Order</button>
                        </form>
                    </div>
                </div>
            @empty
                <p>You have no orders yet.</p>
            @endforelse
        </div>
    </div>
@endsection
