<?php

namespace App\Livewire;

use Livewire\Component;

class Profile extends Component
{
    public function logout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('splash');
    }

    public function render()
    {
        $user = auth()->user();
        $walletCount = $user->wallets()->count();
        $txnCount = $user->transactions()->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->count();

        return view('livewire.profile', [
            'walletCount' => $walletCount,
            'txnCount' => $txnCount,
        ])->layout('layouts.app');
    }
}
