<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\MenuItem;
use App\Models\OrderItem;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Symfony\Component\Clock\now;

class CartController extends Controller
{
    public function index() {
        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id()]
        );

        $cartItems = $cart->cartItems()->with('menuItem')->get();
        $cartTotal = $cartItems->sum('total_price');

        return view('customer.cart', compact('cartItems', 'cartTotal'));
    }

    public function add_to_cart(Request $request) {
        $request->validate([
            'menuItem_id' => 'required|exists:menu_items,id',
            'quantity' => 'sometimes|integer|min:1',
        ]);

        $menuItem = MenuItem::findOrFail($request->menuItem_id);
        $quantity = $request->input('quantity', 1);

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $cartItem = CartItem::where('cart_id', $cart->cart_id)
            ->where('menuItem_id', $menuItem->id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->total_price = $cartItem->quantity * $menuItem->price;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->cart_id,
                'menuItem_id' => $menuItem->id,
                'quantity' => $quantity,
                'total_price' => $menuItem->price * $quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Item added to cart');
    }

    public function updateQuantity(Request $request, $cartItemId) {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::findOrFail($cartItemId);
        abort_if($cartItem->cart->user_id !== Auth::id(), 403);

        $cartItem->quantity = $request->quantity;
        $cartItem->total_price = $cartItem->quantity * $cartItem->menuItem->price;
        $cartItem->save();

        $cart = $cartItem->cart;
        $cartTotal = $cart->cartItems()->sum('total_price');

        return response()->json([
            'item_total' => $cartItem->total_price,
            'cart_total' => $cartTotal,
        ]);
    }

    public function remove_from_cart($cartItemId)
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        abort_if($cartItem->cart->user_id !== Auth::id(), 403);

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    public function placeOrder(Request $request) {
        $request->validate([
            'address' => 'required|string|max:255',
            'payment_method' => 'required|in:payfast,pay_in_person',
        ]);

        $cart = Cart::where('user_id', Auth::id())->firstOrFail();
        $cartItems = $cart->cartItems()->with('menuItem')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->router('cart.index')->with('error', 'Your cart is empty');
        }

        $cartTotal = $cartItems->sum('total_price');

        $order = Order::create([
            'user_id' => Auth::id(),
            'orderDate' => Carbon::now(),
            'totalAmount' => $cartTotal,
            'deliveryAddress' => $request->address,
        ]);

        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id'    => $order->order_id,
                'menuItem_id' => $cartItem->menuItem_id,
                'quantity'    => $cartItem->quantity,
                'unit_price'  => $cartItem->menuItem->price,
                'total_price' => $cartItem->total_price,
            ]);
        }

        $paymentMethod = $request->payment_method === 'payfast' ? 'payfast' : 'PayInPerson';

        Payment::create([
            'order_id' => $order->order_id,
            'user_id' => Auth::id(),
            'paymentMethod' => $paymentMethod,
            'amount'        => $cartTotal,
            'transaction_id' => $paymentMethod === 'PayFast'
                                    ? 'PF-PENDING-' . $order->order_id  // replaced after PayFast callback
                                    : 'IN-PERSON-'  . $order->order_id,
            'dateOfPayment' => Carbon::now(),
            'paymentStatus' => $paymentMethod === 'PayFast' ? 'pending' : 'pending',
        ]);

        $cart->cartItems()->delete();

        if ($request->payment_method === 'payfast') {
            return redirect()->route('payment.payfast', $order->order_id);
        }

        return redirect()->route('order.track.latest')->with('success', 'Order placed successfully!');
    }

    public function reorder($orderId) {
        $order = Order::where('order_id', $orderId)->where('user_id', Auth::id())->firstOrFail();

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        foreach ($order->orderItems as $orderItem) {
            $cartItem = CartItem::where('cart_id', $cart->cart_id)
                ->where('menuItem_id', $orderItem->menuItem_id)
                ->first();

            if ($cartItem) {
                $cartItem->quantity    += $orderItem->quantity;
                $cartItem->total_price  = $cartItem->quantity * $orderItem->menuItem->price;
                $cartItem->save();
            } else {
                CartItem::create([
                    'cart_id'     => $cart->cart_id,
                    'menuItem_id' => $orderItem->menuItem_id,
                    'quantity'    => $orderItem->quantity,
                    'total_price' => $orderItem->quantity * $orderItem->menuItem->price,
                ]);
            }
        }

        return redirect()->route('cart.index')->with('success', 'Items added to cart!');
    }
}
