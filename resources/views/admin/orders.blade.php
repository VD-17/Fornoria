@extends('layouts.admin_nav')

@section('title', 'Admin -Orders')

@push('styles')
    @vite('resources/css/dashboard.css')
@endpush

@section('heading', 'Orders')

@section('admin_page_content')
    <div class="dashboard-container">
        <!-- Recent orders  -->
        <div class="orders">
            <div class="table-title">
                <i class="fa-solid fa-clock"></i>
                <h5>Active Orders</h5>
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
                    @forelse ($activeOrders as $order)
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

        <!-- Delivered orders  -->
        <div class="orders">
            <div class="table-title">
                <i class="fa-solid fa-clock"></i>
                <h5>Delivered Orders</h5>
            </div>
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($deliveredOrders as $order)
                        <tr>
                            <td>#{{ $order->order_id }}</td>
                            <td>{{ $order->user->name ?? 'Guest' }}</td>
                            <td>{{ $order->orderItems->pluck('menuItem.item_name')->filter()->join(', ') }}</td>
                            <td class="total">R{{ number_format($order->totalAmount, 2) }}</td>
                            <td>
                                <span class="status-badge">{{ $order->status}}</span>
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
