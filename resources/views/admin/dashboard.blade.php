@extends('layouts.admin_nav')

@section('title', 'Dashboard')

@push('styles')
    @vite('resources/css/dashboard.css')
@endpush

@section('heading', 'Dashboard')

@section('admin_page_content')
    <div class="dashboard-container">
        <div class="greetings">
            <h3><span>Hello</span>, {{ auth()->user()->name }}</h3>
            <p>Here's what's happening at Fornoria</p>
        </div>

        <div class="stats">
            <div class="item">
                <div class="icon-name">
                    <i class="fa-solid fa-utensils"></i>
                    <p>Menu</p>
                </div>
                <div class="num">
                    {{ $menuItems ? $menuItems->count() : 0 }}
                </div>
            </div>

            <div class="item">
                <div class="icon-name">
                    <i class="fa-solid fa-calendar-check"></i>
                    <p>Reservations</p>
                </div>
                <div class="num">
                    {{ $reservations ? $reservations->count() : 0 }}
                </div>
            </div>

            <div class="item">
                <div class="icon-name">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <p>Active Orders</p>
                </div>
                <div class="num">
                    {{ $orders ? $orders->count() : 0 }}
                </div>
            </div>

            <div class="item">
                <div class="icon-name">
                    <i class="fa-solid fa-envelope"></i>
                    <p>Messages</p>
                </div>
                <div class="num">
                    {{ $messages ? $messages->count() : 0 }}
                </div>
            </div>

            <div class="item">
                <div class="icon-name">
                    <i class="fa-solid fa-credit-card"></i>
                    <p>Payments</p>
                </div>
                <div class="num">
                    R{{ $payments ? $payments->sum('amount') : 0 }}
                </div>
            </div>
        </div>

        <div class="orders">
            <div class="table-title">
                <i class="fa-solid fa-clock"></i>
                <h5>Recent Orders</h5>
            </div>
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>#{{ $order->order_id }}</td>
                            <td>{{ $order->user->name ?? 'Guest' }}</td>
                            <td>{{ $order->orderItems->pluck('menuItem.item_name')->filter()->join(', ') }}</td>
                            <td class="total">R{{ number_format($order->totalAmount, 2) }}</td>
                            <td>
                                <form action="{{ route('admin.updateOrderStatus', $order->order_id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select
                                        name="status"
                                        class="status-dropdown"
                                        onchange="this.form.submit()"
                                    >
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : ''}}>
                                            Pending
                                        </option>
                                        <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>
                                            Preparing
                                        </option>
                                        <option value="out_for_delivery" {{ $order->status === 'out_for_delivery' ? 'selected' : '' }}>
                                            Out for Delivery
                                        </option>
                                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>
                                            Delivered
                                        </option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="no-orders">No orders yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
