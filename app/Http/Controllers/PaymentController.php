<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

    // public function notify(Request $request) {
    //     $paymentId = $request->input('m_payment_id');
    //     $pfPaymentId = $request->input('pf_payment_id');
    //     $paymentStatus = $request->input('payment_status');

    //     $payment = Payment::findOrFail($paymentId);

    //     if ($paymentStatus === 'COMPLETE') {
    //         $payment->update([
    //             'paymentStatus' => 'paid',
    //             'transaction_id' =>$pfPaymentId,
    //             'dateOfPayment' => Carbon::now(),
    //         ]);
    //     } elseif ($paymentStatus === 'FAILED') {
    //         $payment->update([
    //             'paymentStatus' => 'failed',
    //         ]);
    //     } else {
    //         $payment->update([
    //             'paymentStatus' => 'pending',
    //         ]);
    //     }

    //     return response('OK', 200);
    // }

    public function notify(Request $request)
    {
        // PayFast expects an immediate 200 OK acknowledgement.
        // We validate first; if anything fails we just log and still return 200
        // (returning an error code makes PayFast retry the same ITN repeatedly).

        $pfData = $request->all();

        Log::info('PayFast ITN received', $pfData);

        // 1. Verify signature
        if (!$this->isValidSignature($pfData)) {
            Log::warning('PayFast ITN: invalid signature', $pfData);
            return response('OK', 200);
        }

        // 2. Verify the request came from a real PayFast IP
        if (!$this->isValidPayFastIp($request->ip())) {
            Log::warning('PayFast ITN: invalid source IP', ['ip' => $request->ip()]);
            return response('OK', 200);
        }

        // 3. Confirm the data with PayFast directly (server-to-server)
        if (!$this->isValidData($pfData)) {
            Log::warning('PayFast ITN: data validation with PayFast failed', $pfData);
            return response('OK', 200);
        }

        $paymentId     = $pfData['m_payment_id'] ?? null;
        $pfPaymentId   = $pfData['pf_payment_id'] ?? null;
        $paymentStatus = $pfData['payment_status'] ?? null;
        $amountGross   = $pfData['amount_gross'] ?? null;

        $payment = Payment::find($paymentId);

        if (!$payment) {
            Log::warning('PayFast ITN: payment not found', ['m_payment_id' => $paymentId]);
            return response('OK', 200);
        }

        // 4. Verify the amount matches what we expect (protects against tampering)
        if ($amountGross !== null && round((float) $amountGross, 2) !== round((float) $payment->amount, 2)) {
            Log::warning('PayFast ITN: amount mismatch', [
                'expected' => $payment->amount,
                'received' => $amountGross,
            ]);
            return response('OK', 200);
        }

        if ($paymentStatus === 'COMPLETE') {
            $payment->update([
                'paymentMethod'  => 'PayFast',
                'paymentStatus'  => 'paid',
                'transaction_id' => $pfPaymentId,
                'dateOfPayment'  => Carbon::now(),
            ]);
        } elseif ($paymentStatus === 'FAILED') {
            $payment->update(['paymentStatus' => 'failed']);
        } else {
            $payment->update(['paymentStatus' => 'pending']);
        }

        return response('OK', 200);
    }

    private function isValidSignature(array $pfData): bool
    {
        $signature = $pfData['signature'] ?? null;
        if (!$signature) {
            return false;
        }

        unset($pfData['signature']);

        $pfOutput = '';
        foreach ($pfData as $key => $value) {
            if ($value !== '') {
                $pfOutput .= $key . '=' . urlencode(trim($value)) . '&';
            }
        }
        $pfOutput = rtrim($pfOutput, '&');

        $passphrase = config('payfast.passphrase');
        if (!empty($passphrase)) {
            $pfOutput .= '&passphrase=' . urlencode(trim($passphrase));
        }

        return hash_equals(md5($pfOutput), $signature);
    }

    private function isValidPayFastIp(string $ip): bool
    {
        // PayFast publishes the valid hostnames/IP ranges for their ITN servers.
        // Resolve hostnames at request time rather than hardcoding IPs, since they can change.
        $validHosts = [
            'www.payfast.co.za',
            'sandbox.payfast.co.za',
            'w1w.payfast.co.za',
            'w2w.payfast.co.za',
        ];

        foreach ($validHosts as $host) {
            if (gethostbyname($host) === $ip) {
                return true;
            }
        }

        return false;
    }

    private function isValidData(array $pfData): bool
    {
        $url = config('payfast.sandbox')
            ? 'https://sandbox.payfast.co.za/eng/query/validate'
            : 'https://www.payfast.co.za/eng/query/validate';

        $response = \Illuminate\Support\Facades\Http::asForm()->post($url, $pfData);

        return trim($response->body()) === 'VALID';
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
