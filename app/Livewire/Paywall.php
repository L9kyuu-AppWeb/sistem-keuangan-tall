<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\On;
use Livewire\Component;

class Paywall extends Component
{
    public bool $alreadyUsedTrial = false;

    public bool $isPro = false;

    public bool $showConfirmModal = false;

    public function mount(): void
    {
        $user = Auth::user();
        $this->alreadyUsedTrial = $user->hasUsedTrial();
        $this->isPro = $user->isPro();
    }

    public function openConfirmModal(): void
    {
        if ($this->alreadyUsedTrial || $this->isPro) {
            return;
        }
        $this->showConfirmModal = true;
    }

    public function closeConfirmModal(): void
    {
        $this->showConfirmModal = false;
    }

    public function confirmStartTrial()
    {
        $user = Auth::user();

        // Double-check: hanya aktifkan jika belum pernah trial
        if ($user->hasUsedTrial()) {
            return;
        }

        // Aktifkan 7 hari Pro
        $user->is_pro = true;
        $user->pro_expires_at = now()->addDays(7);
        $user->trial_used_at = now();
        $user->save();

        $this->showConfirmModal = false;

        // Redirect ke dashboard dengan notifikasi session
        session()->flash('success', '🎉 Selamat! Trial 7 hari Pro berhasil diaktifkan!');

        return redirect()->route('dashboard');
    }

    public function pay($plan)
    {
        if (! in_array($plan, ['monthly', 'yearly'])) {
            return;
        }

        try {
            $snapToken = $this->getSnapToken($plan);
            $this->dispatch('initiate-payment', token: $snapToken);
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    private function getSnapToken($plan)
    {
        $user = Auth::user();
        $price = $plan === 'yearly' ? 249000 : 29000;
        $orderId = 'FAMI-'.$user->id.'-'.$plan.'-'.time();

        $serverKey = config('services.midtrans.server_key');
        $isProduction = config('services.midtrans.is_production');

        $url = $isProduction
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $price,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => 'pro_'.$plan,
                    'price' => $price,
                    'quantity' => 1,
                    'name' => 'FamiBalance Pro - '.ucfirst($plan),
                ],
            ],
        ];

        $request = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->withBasicAuth($serverKey, '');

        if (! $isProduction) {
            $request->withoutVerifying();
        }

        $response = $request->post($url, $payload);

        if ($response->successful()) {
            return $response->json()['token'];
        }

        throw new \Exception('Gagal mendapatkan token transaksi: '.($response->json()['error_messages'][0] ?? $response->body()));
    }

    #[On('payment-completed')]
    public function handlePaymentCompleted($result)
    {
        $orderId = $result['order_id'] ?? null;
        if (! $orderId) {
            return;
        }

        // Verify status with Midtrans
        $success = $this->verifyAndActivate($orderId);

        if ($success) {
            session()->flash('success', '🎉 Pembayaran Berhasil! Langganan Pro Anda telah aktif.');

            return redirect()->route('paywall');
        } else {
            session()->flash('error', 'Status pembayaran belum berhasil atau masih diverifikasi.');
        }
    }

    private function verifyAndActivate($orderId)
    {
        $serverKey = config('services.midtrans.server_key');
        $isProduction = config('services.midtrans.is_production');

        $url = $isProduction
            ? "https://api.midtrans.com/v2/{$orderId}/status"
            : "https://api.sandbox.midtrans.com/v2/{$orderId}/status";

        $request = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->withBasicAuth($serverKey, '');

        if (! $isProduction) {
            $request->withoutVerifying();
        }

        $response = $request->get($url);

        if ($response->successful()) {
            $data = $response->json();
            $transactionStatus = $data['transaction_status'] ?? '';

            // Check if transaction is successful
            if ($transactionStatus === 'settlement' || $transactionStatus === 'capture') {
                $this->activateSubscription($orderId);

                return true;
            }
        }

        return false;
    }

    private function activateSubscription($orderId)
    {
        $parts = explode('-', $orderId);
        if (count($parts) < 4 || $parts[0] !== 'FAMI') {
            return;
        }

        $userId = $parts[1];
        $plan = $parts[2];

        $user = User::find($userId);
        if (! $user) {
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
    }

    public function render()
    {
        return view('livewire.paywall')->layout('layouts.app');
    }
}
