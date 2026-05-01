<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function redirectToPayFast($orderId) {
        $order = Order::where('order_id', $orderId)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

        $payment = Payment::where('order_id', $order->order_id)->firstOrFail();

        $payfastUrl = 'https://sandbox.payfast.co.za/eng/process';

        $data = [
            'merchant_id'  => config('payfast.merchant_id'),
            'merchant_key' => config('payfast.merchant_key'),
            'return_url'   => route('payment.success', $order->order_id),
            'cancel_url'   => route('payment.cancel',  $order->order_id),
            'notify_url'   => route('payment.notify'),
            'm_payment_id' => $payment->payment_id,
            'amount'       => number_format($order->totalAmount, 2, '.', ''),
            'item_name'    => 'Fornoria Order #' . $order->order_id,
        ];

        $data['signature'] = $this->generateSignature($data);

        return view('customer.payfast-redirect', compact('payfastUrl', 'data'));
    }

    public function notify(Request $request) {
        $paymentId = $request->input('m_payment_id');
        $pfPaymentId = $request->input('pf_payment_id');
        $paymentStatus = $request->input('payment_status');

        $payment = Payment::findOrFail($paymentId);

        if ($paymentStatus === 'COMPLETE') {
            $payment->update([
                'paymentStatus' => 'paid',
                'transaction_id' =>$pfPaymentId,
                'dateOfPayment' => Carbon::now(),
            ]);
        } elseif ($paymentStatus === 'FAILED') {
            $payment->update([
                'paymentStatus' => 'failed',
            ]);
        } else {
            $payment->update([
                'paymentStatus' => 'pending',
            ]);
        }

        return response('OK', 200);
    }

    public function success($orderId) {
        $order = Order::where('order_id', $orderId)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

        return redirect()->route('order.index')
                         ->with('success', 'Payment successful! Your order #' . $order->order_id . ' is confirmed.');
    }

    public function cancel($orderId) {
        $order = Order::where('order_id', $orderId)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

        Payment::where('order_id', $order->order_id)
                ->update(['paymentStatus' => 'pending']);

        return redirect()->route('cart.index')
                         ->with('error', 'Payment cancelled. Your order has not been confirmed.');
    }

    private function generateSignature(array $data): string {
        unset($data['signature']);

        $pfOutput = '';
        foreach ($data as $key => $value) {
            if ($value !== '') {
                $pfOutput .= $key . '=' . urlencode(trim($value)) . '&';
            }
        }

        $pfOutput = rtrim($pfOutput, '&');

        $passphrase = config('payfast.passphrase');
        if (!empty($passphrase)) {
            $pfOutput .= '&passphrase=' . urlencode(trim($passphrase));
        }

        return md5($pfOutput);
    }
}
