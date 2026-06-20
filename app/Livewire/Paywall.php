<?php

namespace App\Livewire;

use App\Models\Subscription;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Paywall extends Component
{
    public string $selectedPlan = 'monthly';
    public bool $processing = false;
    public bool $hasTrial = false;
    public ?Subscription $activeSub = null;

    public function mount()
    {
        $this->hasTrial = Subscription::where('user_id', auth()->id())
            ->whereNotNull('trial_starts_at')
            ->exists();

        $this->activeSub = Subscription::where('user_id', auth()->id())
            ->whereIn('status', ['trial', 'active'])
            ->latest()
            ->first();
    }

    public function selectPlan(string $plan): void
    {
        $this->selectedPlan = $plan;
    }

    public function startTrial(): void
    {
        if ($this->hasTrial) {
            session()->flash('error', 'Anda sudah menggunakan masa percobaan.');
            return;
        }

        $user = auth()->user();

        Subscription::create([
            'user_id' => $user->id,
            'plan' => 'monthly',
            'status' => 'trial',
            'trial_starts_at' => now(),
            'trial_ends_at' => now()->addDays(7),
        ]);

        $user->update([
            'is_pro' => true,
            'pro_expires_at' => now()->addDays(7),
        ]);

        $this->hasTrial = true;

        session()->flash('success', 'Masa percobaan 7 hari sudah dimulai! Nikmati semua fitur Pro.');

        $this->mount();
    }

    public function pay()
    {
        $this->processing = true;

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . base64_encode(config('services.midtrans.server_key') . ':'),
                'Content-Type' => 'application/json',
            ])->post(route('midtrans.token'), [
                'plan' => $this->selectedPlan,
            ]);

            if ($response->successful()) {
                $this->dispatch('openMidtransPayment', [
                    'snap_token' => $response->json('snap_token'),
                ]);
            } else {
                session()->flash('error', 'Gagal memuat pembayaran. Coba lagi.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Koneksi ke payment gateway gagal.');
        }

        $this->processing = false;
    }

    public function render()
    {
        return view('livewire.paywall')->layout('layouts.app');
    }
}
