<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index() {
        $admin = User::all();
        $menuItems = MenuItem::all();
        $reservations = Reservation::all();

        $orders = Order::with(['user', 'orderItems.menuItem'])
            ->where('status', '!=', 'delivered')
            ->get();

        $messages = Contact::all();
        $payments = Payment::all();

        return view('admin.dashboard', compact('admin', 'menuItems', 'reservations', 'orders', 'messages', 'payments'));
    }

    public function updateStatus(Request $request, $id) {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => ['required', 'in:preparing,out_for_delivery,delivered'],
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated.');
    }

    public function admin_orders_index() {
        $activeOrders = Order::with(['user', 'orderItems.menuItem'])
        ->where('status', '!=', 'delivered')
        ->get();

        $deliveredOrders = Order::with(['user', 'orderItems.menuItem'])
        ->where('status', 'delivered')
        ->get();

        return view('admin.orders', compact('activeOrders', 'deliveredOrders'));
    }

    public function admin_payment_index() {
        $payments = Payment::with(['user'])->get();

        return view('admin.payments', compact('payments'));
    }

    public function admin_user_index() {
        $users = User::all();
        $orders = Order::all();
        $count = $orders->count();

        return view('admin.users', compact('users', 'count'));
    }
}
