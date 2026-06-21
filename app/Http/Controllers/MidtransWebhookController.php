<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function handleNotification(Request $request): JsonResponse
    {
        $payload = $request->all();
        Log::info('Midtrans Webhook Payload: ', $payload);

        $orderId = $payload['order_id'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;

        if (! $orderId || ! $statusCode || ! $grossAmount || ! $signatureKey) {
            return response()->json(['message' => 'Missing signature properties'], 400);
        }

        // Verify signature
        $serverKey = config('services.midtrans.server_key');
        $localSignature = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

        if ($localSignature !== $signatureKey) {
            Log::warning('Midtrans signature verification failed.', [
                'order_id' => $orderId,
                'received' => $signatureKey,
                'calculated' => $localSignature,
            ]);

            return response()->json(['message' => 'Invalid signature'], 400);
        }

        // Check if settlement or capture
        if ($transactionStatus === 'settlement' || $transactionStatus === 'capture') {
            $this->activateSubscription($orderId);
        }

        return response()->json(['message' => 'Webhook processed successfully']);
    }

    private function activateSubscription(string $orderId): void
    {
        // orderId format: FAMI-{userId}-{plan}-{timestamp}
        $parts = explode('-', $orderId);
        if (count($parts) < 4 || $parts[0] !== 'FAMI') {
            Log::warning("Midtrans Webhook: invalid orderId format: {$orderId}");

            return;
        }

        $userId = $parts[1];
        $plan = $parts[2];

        $user = User::find($userId);
        if (! $user) {
            Log::warning("Midtrans Webhook: user not found: {$userId}");

            return;
        }

        // Extend subscription
        $currentExpiry = $user->isPro() ? $user->pro_expires_at : now();
        if ($plan === 'yearly') {
            $newExpiry = (clone $currentExpiry)->addYear();
        } else {
            $newExpiry = (clone $currentExpiry)->addMonth();
        }

        $user->is_pro = true;
        $user->pro_expires_at = $newExpiry;
        $user->save();

        // Send notification
        UserNotification::create([
            'user_id' => $user->id,
            'type' => 'system',
            'title' => '🔑 FamiBalance Pro Aktif!',
            'message' => 'Terima kasih! Langganan '.($plan === 'yearly' ? 'Tahunan' : 'Bulanan').' berhasil diaktifkan. Berlaku hingga '.$newExpiry->format('d M Y').'.',
        ]);

        Log::info("User ID {$userId} subscription extended. New expiry: ".$newExpiry->toDateTimeString());
    }
}
