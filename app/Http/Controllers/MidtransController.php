<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isProduction = config('services.midtrans.production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createToken(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:monthly,yearly',
        ]);

        $user = auth()->user();
        $orderId = 'FB-' . Str::upper(Str::random(6)) . '-' . now()->format('YmdHis');
        $amount = $request->plan === 'monthly' ? 29000 : 249000;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => $request->plan,
                    'price' => $amount,
                    'quantity' => 1,
                    'name' => $request->plan === 'monthly' ? 'FamiBalance Pro Bulanan' : 'FamiBalance Pro Tahunan',
                ],
            ],
            'callbacks' => [
                'finish' => route('paywall.callback'),
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json([
            'snap_token' => $snapToken,
            'order_id' => $orderId,
        ]);
    }

    public function callback(Request $request)
    {
        $orderId = $request->order_id;
        $statusCode = $request->status_code;
        $transactionStatus = $request->transaction_status;

        $user = auth()->user();

        if ($transactionStatus === 'capture' || $transactionStatus === 'settlement') {
            $plan = str_starts_with($orderId, 'FB-') ? 'yearly' : 'monthly';
            // detect plan from order id pattern
            $sub = Subscription::where('midtrans_order_id', $orderId)->first();

            if ($sub) {
                $sub->update([
                    'status' => 'active',
                    'midtrans_transaction_id' => $request->transaction_id,
                    'starts_at' => now(),
                    'ends_at' => $sub->plan === 'monthly' ? now()->addMonth() : now()->addYear(),
                ]);

                $user->update([
                    'is_pro' => true,
                    'pro_expires_at' => $sub->ends_at,
                ]);
            }
        }

        return redirect()->route('profile')->with('success', 'Pembayaran berhasil! Akun Pro aktif.');
    }

    public function webhook(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        $signature = $request->signature_key;
        $orderId = $request->order_id;
        $statusCode = $request->status_code;
        $grossAmount = $request->gross_amount;

        // verify signature
        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signature !== $expectedSignature) {
            return response()->json(['status' => 'invalid signature'], 403);
        }

        $sub = Subscription::where('midtrans_order_id', $orderId)->first();
        if (!$sub) {
            return response()->json(['status' => 'order not found'], 404);
        }

        $transactionStatus = $request->transaction_status;
        $fraudStatus = $request->fraud_status;

        if ($transactionStatus === 'capture') {
            if ($fraudStatus === 'accept') {
                $this->activateSubscription($sub);
            }
        } elseif ($transactionStatus === 'settlement') {
            $this->activateSubscription($sub);
        } elseif ($transactionStatus === 'cancel' || $transactionStatus === 'deny' || $transactionStatus === 'expire') {
            $sub->update(['status' => 'expired']);
        }

        return response()->json(['status' => 'ok']);
    }

    private function activateSubscription(Subscription $sub): void
    {
        $sub->update([
            'status' => 'active',
            'starts_at' => now(),
            'ends_at' => $sub->plan === 'monthly' ? now()->addMonth() : now()->addYear(),
        ]);

        $sub->user->update([
            'is_pro' => true,
            'pro_expires_at' => $sub->ends_at,
        ]);
    }
}
