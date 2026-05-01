<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Order history page (all orders)
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
                       ->with(['orderItems.menuItem', 'payment'])
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('customer.reorder', compact('orders'));
    }

    // Track page (most recent order)
    public function track_index()
    {
        $order = Order::where('user_id', Auth::id())
                      ->with(['orderItems.menuItem', 'payment'])
                      ->orderBy('created_at', 'desc')
                      ->firstOrFail();

        return view('customer.track', compact('order'));
    }

    // Track a specific order by ID
    public function track($orderId)
    {
        $order = Order::where('order_id', $orderId)
                      ->where('user_id', Auth::id())
                      ->with(['orderItems.menuItem', 'payment'])
                      ->firstOrFail();

        return view('customer.track', compact('order'));
    }

    // Cancel an order
    public function cancel($orderId)
    {
        $order = Order::where('order_id', $orderId)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

        if ($order->status !== 'Preparing') {
            return redirect()->route('order.track', $orderId)
                             ->with('error', 'Order cannot be cancelled as it is already ' . $order->status . '.');
        }

        $order->delete();

        return redirect()->route('order.index')
                         ->with('success', 'Order cancelled successfully.');
    }
}
