<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
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

    public function render()
    {
        return view('livewire.paywall')->layout('layouts.app');
    }
}