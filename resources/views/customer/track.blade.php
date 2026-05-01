@extends('layouts.app')

@section('title', 'Track Order')

@push('styles')
    @vite('resources/css/track.css')
@endpush

@section('page_content')
    <div class="track-order">
        <div class="title">
            TRACK ORDER
        </div>

        <div class="tracking">
            <div class="ref">
                <span>Ref: #{{ $order->order_id }}</span>
                <span>{{ \Carbon\Carbon::parse($order->orderDate)->format('d M Y, H:i') }}</span>
            </div>

            <div class="track-status">
                <div class="status">
                    @if ($order->status === 'Preparing') 
                        <i class="fa-solid fa-hourglass-start"></i>
                        <span>Preparing</span>
                    @elseif ($order->status === 'Out for Delivery')
                        <i class="fa-solid fa-truck"></i>
                        <span>Out for Delivery</span>
                    @else
                        <i class="fa-regular fa-circle-check"></i>
                        <span>Delivered</span>
                    @endif
                </div>
            </div>

            <div class="order-details">
                <div class="details">
                    @foreach($order->orderItems as $orderItem)
                        <p>{{ $orderItem->menuItem->item_name }} x{{ $orderItem->quantity }}</p>
                    @endforeach
                    <span>R{{ number_format($order->totalAmount, 0) }}</span>
                </div>

                @if ($order->status === 'Preparing')
                    <div class="cancel-btn">
                        <form action="{{ route('order.cancel', $order->order_id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Are you sure you want to cancel this order?')">
                                Cancel Order
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
